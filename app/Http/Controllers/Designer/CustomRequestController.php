<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{CustomRequest, CustomRequestFile};

class CustomRequestController extends Controller
{
    public function index()
    {
        $designerId = Auth::user()->designer->id;

        $crs = CustomRequest::where('designer_id', $designerId)
            ->latest()
            ->paginate(12);

        return view('designer.custom_requests.index', compact('crs'));
    }

    public function show(CustomRequest $custom_request)
    {
        $cr = $custom_request;

        if ($cr->designer_id !== Auth::user()->designer->id) {
            abort(403);
        }

        $cr->load(['customer.user', 'files', 'comments.user']);

        // parse delivery so the view knows digital/ship
        $delivery = $this->parseDelivery($cr);

        return view('designer.custom_requests.show', compact('cr','delivery'));
    }

    public function quote(Request $request, CustomRequest $custom_request)
    {
        $cr = $custom_request;

        if ($cr->designer_id !== Auth::user()->designer->id) {
            abort(403);
        }

        // determine customer's delivery choice
        $delivery = $this->parseDelivery($cr);
        $method   = $delivery['method'] ?? 'digital';

        // VALIDATION: if digital -> NO shipping fields
        $rules = [
            'price_agreed'       => ['required', 'integer', 'min:1000'],
            'revisions_allowed'  => ['nullable', 'integer', 'min:1', 'max:10'],
            'note'               => ['nullable', 'string', 'max:1000'],
        ];
        if ($method === 'ship') {
            // visible & validated only for ship
            $rules['shipping_note'] = ['nullable', 'string', 'max:500'];
            $rules['shipping_fee']  = ['nullable', 'integer', 'min:0'];
        }

        $data = $request->validate($rules);

        // update core fields
        $cr->update([
            'price_agreed'      => $data['price_agreed'],
            'revisions_allowed' => $data['revisions_allowed'] ?? $cr->revisions_allowed,
            'status'            => 'quoted',
        ]);

        // build comment
        $commentParts = [];
        $commentParts[] = 'Quote: Rp ' . number_format($data['price_agreed'], 0, ',', '.');

        if (!empty($data['note'])) {
            $commentParts[] = 'Note: ' . $data['note'];
        }

        // add shipping info ONLY if method=ship
        if ($method === 'ship') {
            if (!empty($data['shipping_note'])) {
                $commentParts[] = 'Shipping info (estimate): ' . $data['shipping_note'];
            }
            if (isset($data['shipping_fee'])) {
                $commentParts[] = 'Shipping fee: Rp ' . number_format($data['shipping_fee'], 0, ',', '.');
                // token for parsing on customer accept
                $commentParts[] = 'SHIPFEE=' . (int)$data['shipping_fee'];
            }
        }

        if ($commentParts) {
            $cr->comments()->create([
                'user_id' => Auth::id(),
                'message' => implode(' | ', $commentParts),
            ]);
        }

        return back()->with('success', 'Quote sent to the customer.');
    }

    public function decision(Request $request, CustomRequest $custom_request)
    {
        $cr = $custom_request;

        if ($cr->designer_id !== Auth::user()->designer->id) {
            abort(403);
        }

        $data = $request->validate([
            'decision' => ['required', 'in:accept,decline'],
            'note'     => ['nullable', 'string', 'max:1000'],
        ]);

        if ($data['decision'] === 'accept') {
            $cr->update(['status' => 'submitted']);
        } else {
            $cr->update(['status' => 'declined']);
        }

        if (!empty($data['note'])) {
            $cr->comments()->create([
                'user_id' => Auth::id(),
                'message' => 'Designer: ' . $data['note'],
            ]);
        }

        return back()->with(
            'success',
            $data['decision'] === 'accept'
                ? 'Request accepted. Please send a quote.'
                : 'Request declined.'
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
}
