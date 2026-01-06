<x-app-layouts title="Custom Request Detail">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $cr->code }} — {{ $cr->title }}</h4>
            <a href="{{ route('customer.custom-requests.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- DELIVERY PARSER (no migration) --}}
            @php
                $delivery = [
                    'method' => 'digital',
                    'name' => null,
                    'phone' => null,
                    'address' => null,
                    'city' => null,
                    'province' => null,
                    'postal' => null,
                ];
                $shipFeeFromQuote = 0;

                foreach ($cr->comments as $c) {
                    // parse delivery
                    if (stripos($c->message, 'DELIVERY:') === 0) {
                        $msg = $c->message;
                        if (preg_match('/^DELIVERY:\s*(ship|digital)/mi', $msg, $m)) {
                            $delivery['method'] = strtolower($m[1]);
                        }
                        if (preg_match('/^Name:\s*(.+)$/mi', $msg, $m)) {
                            $delivery['name'] = trim($m[1]);
                        }
                        if (preg_match('/^Phone:\s*(.+)$/mi', $msg, $m)) {
                            $delivery['phone'] = trim($m[1]);
                        }
                        if (preg_match('/^Address:\s*(.+)$/mi', $msg, $m)) {
                            $delivery['address'] = trim($m[1]);
                            if (preg_match('/,\s*([^,]+),\s*([^\d,]+)\s+(\S+)$/u', $delivery['address'], $mm)) {
                                $delivery['city'] = trim($mm[1]);
                                $delivery['province'] = trim($mm[2]);
                                $delivery['postal'] = trim($mm[3]);
                            }
                        }
                    }

                    // parse possible shipping fee from quote
                    if (!$shipFeeFromQuote) {
                        if (preg_match('/SHIPFEE\s*[:=]\s*(\d+)/i', $c->message, $mm)) {
                            $shipFeeFromQuote = (int) $mm[1];
                        } elseif (preg_match('/(?:Ongkir|Shipping\s*fee)\D+([\d\.]+)/i', $c->message, $mm)) {
                            $shipFeeFromQuote = (int) str_replace('.', '', $mm[1]);
                        }
                    }
                }
            @endphp

            <div class="row g-3">
                <div class="col-md-6">
                    <div><strong>Designer:</strong> {{ $cr->designer->display_name ?? $cr->designer->user->name }}</div>
                    <div><strong>Status:</strong> <span class="badge bg-secondary">{{ $cr->status }}</span></div>
                    <div><strong>Revision Limit:</strong> {{ $cr->revisions_allowed }}</div>
                    <div class="mt-2"><strong>Brief:</strong><br>{!! nl2br(e($cr->brief)) !!}</div>

                    @if ($cr->reference_links && count($cr->reference_links))
                        <div class="mt-2"><strong>Links:</strong>
                            <ul class="mb-0">
                                @foreach ($cr->reference_links as $l)
                                    <li><a href="{{ $l }}" target="_blank">{{ $l }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <div class="fw-semibold mb-1">Reference Files</div>
                    @forelse($cr->files as $f)
                        <div class="small">
                            <i class="fas fa-paperclip"></i>
                            <a href="{{ asset('storage/' . $f->path) }}" target="_blank">{{ basename($f->path) }}</a>
                            <span class="text-muted">({{ $f->type }})</span>
                        </div>
                    @empty
                        <span class="text-muted">No files.</span>
                    @endforelse
                </div>
            </div>

            {{-- Delivery summary: ALWAYS visible after create if "Ship Package" --}}
            @if ($delivery['method'] === 'ship')
                <div class="border rounded p-3 mt-3">
                    <div class="fw-semibold mb-1">Delivery</div>
                    <span class="badge bg-primary">Ship Package</span>
                    <div class="small mt-2">
                        <div><strong>Recipient:</strong> {{ $delivery['name'] ?? '-' }}
                            ({{ $delivery['phone'] ?? '-' }})</div>
                        <div><strong>Address:</strong>
                            {{ $delivery['address'] }}
                            @if ($delivery['city'])
                                , {{ $delivery['city'] }}
                            @endif
                            @if ($delivery['province'])
                                , {{ $delivery['province'] }}
                            @endif
                            @if ($delivery['postal'])
                                {{ $delivery['postal'] }}
                            @endif
                        </div>
                        @if ($shipFeeFromQuote > 0)
                            <div class="mt-1"><strong>Shipping Fee (from quote):</strong>
                                Rp {{ number_format($shipFeeFromQuote, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">
                                When you accept the quote, the order total will include this shipping fee.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Quote + Accept --}}
            @if ($cr->status === 'quoted' && $cr->price_agreed)
                <hr>
                <div class="mb-2">
                    <div class="fw-semibold">Designer’s Quote</div>
                    <div>Price: <strong>Rp {{ number_format($cr->price_agreed, 0, ',', '.') }}</strong></div>
                    <div>Revision Limit: {{ $cr->revisions_allowed }}</div>
                </div>

                <form method="POST" action="{{ route('customer.custom-requests.accept-quote', $cr) }}">
                    @csrf
                    <button class="btn btn-primary">Accept Quote & Create Order</button>
                </form>
            @endif

        </div>
    </div>
</x-app-layouts>
