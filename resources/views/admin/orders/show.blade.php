<x-app-layouts title="Order Detail">
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Order {{ $order->code }}</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
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

            <div class="row g-3">
                <div class="col-md-6">
                    <div><strong>Customer:</strong> {{ $order->customer->user->name ?? '-' }}</div>
                    <div><strong>Designer:</strong> {{ $order->designer->user->name ?? '-' }}</div>
                    <div><strong>Status:</strong> <span class="badge bg-secondary">{{ $order->status }}</span></div>
                    <div>
                        <strong>Payment:</strong>
                        <span
                            class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'submitted' ? 'warning text-dark' : 'secondary') }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                    <div><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>

                {{-- Payment Destination + QR Preview --}}
                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <div class="fw-semibold mb-1">Payment Destination</div>
                        <div>Bank: {{ $order->pay_bank_name ?? '-' }}</div>
                        <div>Account No.: <span class="text-monospace">{{ $order->pay_bank_account_no ?? '-' }}</span>
                        </div>

                        <div class="mt-2 text-center">
                            @if ($order->pay_qris_image)
                                @php $qrUrl = asset('storage/' . $order->pay_qris_image); @endphp

                                {{-- Thumbnail (click to enlarge) --}}
                                <img src="{{ $qrUrl }}" alt="Payment QRIS" class="img-fluid rounded border"
                                    style="max-height:220px;cursor:zoom-in;" data-bs-toggle="modal"
                                    data-bs-target="#qrPreviewModal">

                                {{-- Actions --}}
                                <div class="d-flex flex-wrap gap-2 justify-content-center mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#qrPreviewModal">
                                        Enlarge
                                    </button>
                                    <a href="{{ $qrUrl }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary">
                                        Open in New Tab
                                    </a>
                                    <a href="{{ $qrUrl }}" download class="btn btn-sm btn-primary">
                                        Download
                                    </a>
                                </div>
                            @else
                                <span class="text-muted">QRIS not available.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Design</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Item Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $it)
                            <tr>
                                <td>{{ $it->title_snapshot }}</td>
                                <td>{{ $it->qty }}</td>
                                <td>Rp {{ number_format($it->price_snapshot, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($it->price_snapshot * $it->qty, 0, ',', '.') }}</td>
                                <td><span class="badge bg-light text-dark">{{ $it->item_status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($order->shipping_method === 'ship')
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Shipping</h5>
                        <span
                            class="badge bg-secondary text-uppercase">{{ $order->shipping_status ?? 'pending' }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div><strong>Recipient:</strong> {{ $order->ship_name }} ({{ $order->ship_phone }})
                                </div>
                                <div><strong>Address:</strong> {{ $order->ship_address }}, {{ $order->ship_city }},
                                    {{ $order->ship_province }} {{ $order->ship_postal_code }}</div>
                            </div>
                            <div class="col-md-6">
                                <div><strong>Courier:</strong> {{ $order->shipping_courier ?? '-' }}</div>
                                <div><strong>Tracking No.:</strong> {{ $order->shipping_tracking_no ?? '-' }}</div>
                                <div><strong>Shipping Fee:</strong> Rp
                                    {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <hr>

            <div class="row">
                <div class="col-md-7">
                    <div class="fw-semibold mb-2">Payment Proofs</div>
                    @forelse($order->paymentProofs as $p)
                        @php $proofUrl = asset('storage/' . $p->image_path); @endphp
                        <div class="border rounded p-2 mb-2 d-flex align-items-center gap-3">
                            <input type="radio" form="admin-order-update" name="proof_id" value="{{ $p->id }}"
                                @checked(old('proof_id') == $p->id)>

                            <img src="{{ $proofUrl }}" style="width:120px;height:80px;object-fit:cover"
                                class="rounded" alt="Payment proof #{{ $p->id }}">

                            <div class="small">
                                <div>
                                    Status:
                                    <span
                                        class="badge bg-{{ $p->status === 'accepted' ? 'success' : ($p->status === 'rejected' ? 'danger' : 'warning text-dark') }}">
                                        {{ $p->status }}
                                    </span>
                                </div>
                                @if ($p->amount)
                                    <div>Amount: Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                                @endif
                                @if ($p->payer_name)
                                    <div>Payer: {{ $p->payer_name }}</div>
                                @endif
                                <div class="text-muted">Uploaded: {{ $p->created_at->format('d-m-Y H:i') }}</div>
                            </div>

                            {{-- Actions --}}
                            <div class="ms-auto d-flex flex-wrap gap-2">
                                <a href="{{ $proofUrl }}" target="_blank" rel="noopener"
                                    class="btn btn-sm btn-outline-secondary" title="Open proof in a new tab">
                                    Open
                                </a>
                                <a href="{{ $proofUrl }}" download class="btn btn-sm btn-primary"
                                    title="Download proof">
                                    Download
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No proofs yet.</div>
                    @endforelse
                    <div class="small text-muted">
                        Select one proof, then save to mark as <strong>paid</strong>.
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="border rounded p-3">
                        <div class="fw-semibold mb-2">Update Order</div>
                        <form id="admin-order-update" method="POST"
                            action="{{ route('admin.orders.update', $order) }}">
                            @csrf @method('PUT')
                            <div class="mb-2">
                                <label class="form-label">Order Status</label>
                                <select name="status" class="form-select">
                                    <option value="">— unchanged —</option>
                                    @foreach (['awaiting_payment', 'processing', 'delivered', 'completed', 'cancelled', 'declined'] as $s)
                                        <option value="{{ $s }}" @selected(old('status', $order->status) === $s)>
                                            {{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    <option value="">— unchanged —</option>
                                    @foreach (['unpaid', 'submitted', 'paid', 'rejected'] as $p)
                                        <option value="{{ $p }}" @selected(old('payment_status', $order->payment_status) === $p)>
                                            {{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Note</label>
                                <input type="text" name="note" class="form-control" placeholder="Note (optional)">
                            </div>
                            <button class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- QR Preview Modal (enlarge) --}}
    @if ($order->pay_qris_image)
        @php $qrUrl = asset('storage/' . $order->pay_qris_image); @endphp
        <div class="modal fade" id="qrPreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title">Payment QRIS</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ $qrUrl }}" alt="Payment QRIS" class="img-fluid rounded"
                            style="max-height:80vh;">
                    </div>
                    <div class="modal-footer py-2">
                        <a href="{{ $qrUrl }}" target="_blank" class="btn btn-outline-secondary">Open in New
                            Tab</a>
                        <a href="{{ $qrUrl }}" download class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layouts>
