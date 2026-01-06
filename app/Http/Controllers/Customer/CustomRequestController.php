<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\{CustomRequest, CustomRequestFile, Designer, Order, OrderItem, Design};

class CustomRequestController extends Controller
{
    public function index()
    {
        $crs = CustomRequest::where('customer_id', Auth::user()->customer->id)
            ->latest()->paginate(12);
        return view('customer.custom_requests.index', compact('crs'));
    }

    public function create()
    {
        $designers = Designer::with('user')->orderBy('display_name')->get();
        return view('customer.custom_requests.create', compact('designers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:150'],
            'brief' => ['nullable','string'],
            'designer_id' => ['nullable','exists:designers,id'],
            'revisions_allowed' => ['nullable','integer','min:1','max:10'],
            'reference_links' => ['nullable','array'],
            'reference_links.*' => ['nullable','url'],
            'files.*' => ['nullable','file','max:8192'],

            // delivery preference written into a comment (not columns)
            'shipping_method' => ['required','in:digital,ship'],
            'ship_name'       => ['required_if:shipping_method,ship','nullable','string','max:100'],
            'ship_phone'      => ['required_if:shipping_method,ship','nullable','string','max:30'],
            'ship_address'    => ['required_if:shipping_method,ship','nullable','string','max:255'],
            'ship_city'       => ['required_if:shipping_method,ship','nullable','string','max:100'],
            'ship_province'   => ['required_if:shipping_method,ship','nullable','string','max:100'],
            'ship_postal_code'=> ['required_if:shipping_method,ship','nullable','string','max:20'],
        ]);

        $code = 'CR-'.now()->format('Ym').'-'.strtoupper(Str::random(5));

        $cr = CustomRequest::create([
            'code' => $code,
            'customer_id' => Auth::user()->customer->id,
            'designer_id' => $data['designer_id'] ?? Designer::inRandomOrder()->value('id'),
            'title' => $data['title'],
            'brief' => $data['brief'] ?? null,
            'reference_links' => $data['reference_links'] ?? [],
            'revisions_allowed' => $data['revisions_allowed'] ?? 2,
            'revisions_used' => 0,
            'status' => 'submitted',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $f) {
                if (!$f) continue;
                $path = $f->store("custom_requests/{$cr->id}/references", 'public');
                CustomRequestFile::create([
                    'custom_request_id' => $cr->id,
                    'type' => 'reference',
                    'path' => $path,
                    'note' => null,
                ]);
            }
        }

        // Save delivery preference as a COMMENT (will be parsed on acceptQuote)
        if ($data['shipping_method'] === 'ship') {
            $msg = "DELIVERY: ship\n"
                 . "Name: ".($data['ship_name'] ?? '-')."\n"
                 . "Phone: ".($data['ship_phone'] ?? '-')."\n"
                 . "Address: ".($data['ship_address'] ?? '-').", "
                 . ($data['ship_city'] ?? '-').", "
                 . ($data['ship_province'] ?? '-')." "
                 . ($data['ship_postal_code'] ?? '-');
        } else {
            $msg = "DELIVERY: digital";
        }

        $cr->comments()->create([
            'user_id' => Auth::id(),
            'message' => $msg,
        ]);

        return redirect()->route('customer.custom-requests.show', $cr)
            ->with('success','Custom request created. The designer can see your delivery preference and (if ship) estimate shipping.');
    }

    public function show(CustomRequest $custom_request)
    {
        $cr = $custom_request;
        if ($cr->customer_id !== Auth::user()->customer->id) abort(403);
        $cr->load(['designer.user','files','comments.user']);
        return view('customer.custom_requests.show', compact('cr'));
    }

    // Customer approves quote -> create Order + OrderItem
    public function acceptQuote(Request $request, CustomRequest $custom_request)
    {
        $cr = $custom_request;
        if ($cr->customer_id !== Auth::user()->customer->id) abort(403);
        if ($cr->status !== 'quoted' || !$cr->price_agreed) {
            return back()->with('success','No quote/price has been approved yet.');
        }

        // Read delivery choice from DELIVERY comment (no migration)
        $delivery = $this->parseDelivery($cr);
        $method   = $delivery['method'] ?? 'digital';

        // Minimal validation for ship
        if ($method === 'ship' && !($delivery['name'] && $delivery['phone'] && $delivery['address'])) {
            return back()->withErrors(['shipping' => 'Please complete the shipping address on the custom request (ship method) before accepting.']);
        }

        // Get shipping fee from designer comment (token SHIPFEE=xxxx), if any
        $shipFeeFromCR = ($method === 'ship') ? $this->parseShipFeeFromComments($cr) : 0;

        // design placeholder
        $slug = 'cr-'.Str::slug($cr->code.'-'.$cr->title.'-'.Str::random(4));
        $design = Design::firstOrCreate(
            ['slug' => $slug],
            [
                'designer_id' => $cr->designer_id,
                'title' => 'Custom: '.$cr->title,
                'description' => 'Custom request '.$cr->code,
                'price' => $cr->price_agreed,
                'status' => 'draft',
            ]
        );

        $designer = $cr->designer;

        $order = Order::create([
            'code' => 'JAS-'.now()->format('Ym').'-'.strtoupper(Str::random(5)),
            'customer_id' => $cr->customer_id,
            'designer_id' => $cr->designer_id,
            'status' => 'awaiting_payment',
            'payment_status' => 'unpaid',
            'pay_bank_name' => $designer->bank_name,
            'pay_bank_account_no' => $designer->bank_account_no,
            'pay_qris_image' => $designer->qris_image,

            'shipping_method'  => $method,
            'shipping_status'  => $method === 'ship' ? 'pending' : null,

            // Take address from parsed comment
            'ship_name'        => $method==='ship' ? $delivery['name']    : null,
            'ship_phone'       => $method==='ship' ? $delivery['phone']   : null,
            'ship_address'     => $method==='ship' ? $delivery['address'] : null,
            'ship_city'        => $method==='ship' ? ($delivery['city'] ?? null)      : null,
            'ship_province'    => $method==='ship' ? ($delivery['province'] ?? null)  : null,
            'ship_postal_code' => $method==='ship' ? ($delivery['postal'] ?? null)    : null,

            'subtotal'     => $cr->price_agreed,
            'fee'          => 0,
            'shipping_fee' => $shipFeeFromCR, // prefilled if available
            'total'        => $cr->price_agreed + $shipFeeFromCR,
            'note'         => 'CR: '.$cr->code,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'design_id' => $design->id,
            'designer_id' => $cr->designer_id,
            'title_snapshot' => 'Custom: '.$cr->title,
            'price_snapshot' => $cr->price_agreed,
            'qty' => 1,
            'item_status' => 'processing',
        ]);

        $cr->update(['status' => 'awaiting_payment']);

        return redirect()->route('customer.orders.show', $order)
            ->with('success',
                $method==='ship'
                    ? ($shipFeeFromCR > 0
                        ? 'Order created. Total already includes shipping. You can proceed to payment.'
                        : 'Order created. Waiting for the designer to set the shipping fee before payment.')
                    : 'Order created. Please proceed to payment.'
            );
    }

    /**
     * Parse "DELIVERY:" comment into delivery meta.
     */
    private function parseDelivery(CustomRequest $cr): array
    {
        $meta = [
            'method'   => 'digital',
            'name'     => null,
            'phone'    => null,
            'address'  => null,
            'city'     => null,
            'province' => null,
            'postal'   => null,
        ];

        $messages = $cr->comments()->latest()->pluck('message');
        $msg = null;
        foreach ($messages as $m) {
            if (stripos($m, 'DELIVERY:') === 0) { $msg = $m; break; }
        }
        if (!$msg) return $meta;

        if (preg_match('/^DELIVERY:\s*(ship|digital)/mi', $msg, $mm)) {
            $meta['method'] = strtolower($mm[1]) === 'ship' ? 'ship' : 'digital';
        }
        if (preg_match('/^Name:\s*(.+)$/mi', $msg, $mm))  $meta['name'] = trim($mm[1]);
        if (preg_match('/^Phone:\s*(.+)$/mi', $msg, $mm)) $meta['phone'] = trim($mm[1]);
        if (preg_match('/^Address:\s*(.+)$/mi', $msg, $mm)) {
            $addr = trim($mm[1]);
            $meta['address'] = $addr;

            if (preg_match('/,\s*([^,]+),\s*([^\d,]+)\s+(\S+)$/u', $addr, $ma)) {
                $meta['city']     = trim($ma[1]);
                $meta['province'] = trim($ma[2]);
                $meta['postal']   = trim($ma[3]);
            }
        }

        return $meta;
    }

    /**
     * Get shipping fee from designer comments.
     * Looks for:
     *   - SHIPFEE=12345   (recommended)
     *   - "Ongkir: Rp 12.345" / "Shipping fee: 12.345" (fallback)
     */
    private function parseShipFeeFromComments(CustomRequest $cr): int
    {
        $messages = $cr->comments()->latest()->pluck('message');
        foreach ($messages as $m) {
            if (preg_match('/SHIPFEE\s*[:=]\s*(\d+)/i', $m, $mm)) {
                return (int)$mm[1];
            }
            if (preg_match('/(?:Ongkir|Shipping\s*fee)\D+([\d\.]+)/i', $m, $mm)) {
                return (int) str_replace('.', '', $mm[1]);
            }
        }
        return 0;
    }
}
