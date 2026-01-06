<x-app-layouts title="Custom Request Details">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $cr->code }} — {{ $cr->title }}</h4>
            <a href="{{ route('designer.custom-requests.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
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
                foreach ($cr->comments as $c) {
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
                        break;
                    }
                }
            @endphp

            <div class="row g-3">
                <div class="col-md-6">
                    <div><strong>Customer:</strong> {{ $cr->customer->user->name ?? '-' }}</div>
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
                        </div>
                    @empty
                        <span class="text-muted">No files.</span>
                    @endforelse
                </div>
            </div>

            {{-- Delivery summary --}}
            <div class="border rounded p-3 mt-3">
                <div class="fw-semibold mb-1">Delivery Method</div>
                <div>
                    @if ($delivery['method'] === 'ship')
                        <span class="badge bg-primary">Ship Package</span>
                        <div class="small mt-2">
                            <div><strong>Recipient:</strong> {{ $delivery['name'] }} ({{ $delivery['phone'] }})</div>
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
                        </div>
                    @else
                        <span class="badge bg-success">Digital Download</span>
                        <div class="small text-muted mt-2">No physical shipping required.</div>
                    @endif
                </div>
            </div>

            <hr>

            {{-- Initial decision --}}
            @if (in_array($cr->status, ['submitted']))
                <form method="POST" action="{{ route('designer.custom-requests.decision', $cr) }}"
                    class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="hidden" name="decision" value="accept">
                    <input type="text" name="note" class="form-control" placeholder="Note (optional)">
                    <button class="btn btn-success">Accept Request</button>
                </form>
                <form method="POST" action="{{ route('designer.custom-requests.decision', $cr) }}"
                    class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="decision" value="decline">
                    <input type="text" name="note" class="form-control" placeholder="Reason (optional)">
                    <button class="btn btn-outline-danger">Decline</button>
                </form>
            @endif

            {{-- Send Quote --}}
            @if (in_array($cr->status, ['submitted', 'quoted']))
                <div class="mt-3 border rounded p-3">
                    <div class="fw-semibold mb-2">Send / Update Quote</div>

                    <form method="POST" action="{{ route('designer.custom-requests.quote', $cr) }}" class="row g-2">
                        @csrf
                        <div class="col-md-3">
                            <input type="number" name="price_agreed" class="form-control" placeholder="Price (IDR)"
                                required value="{{ old('price_agreed', $cr->price_agreed) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="revisions_allowed" class="form-control" min="1"
                                max="10" value="{{ old('revisions_allowed', $cr->revisions_allowed) }}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="note" class="form-control"
                                placeholder="Note to customer (optional)" value="{{ old('note') }}">
                        </div>

                        @if (($delivery['method'] ?? 'digital') === 'ship')
                            <div class="col-md-3">
                                <input type="number" name="shipping_fee" class="form-control" min="0"
                                    placeholder="Shipping fee (IDR)" value="{{ old('shipping_fee') }}">
                                <small class="text-muted">If provided, this will automatically be included in the Order
                                    when the customer approves.</small>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="shipping_note" class="form-control"
                                    placeholder="Shipping info (optional)" value="{{ old('shipping_note') }}">
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert alert-light border small mb-0">
                                    Digital download — no shipping required.
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <button class="btn btn-primary">Send / Update Quote</button>
                        </div>
                    </form>
                </div>
            @endif

            @if ($cr->status === 'quoted' && $cr->price_agreed)
                <div class="alert alert-info mt-3">
                    Awaiting customer approval. After approval, the system will create an order for payment.
                </div>
            @endif
        </div>
    </div>
</x-app-layouts>
