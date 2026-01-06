<x-app-layouts title="Order Detail">
    <div class="card mb-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php
            $designerUser = $order->designer->user ?? null;
            $waNumber = $designerUser?->whatsapp;
            $waDigits = $waNumber ? preg_replace('/\D/', '', $waNumber) : null;
            $designerName = $order->designer->display_name ?? ($designerUser?->name ?? 'Designer');
            $waMessage = "Halo kak {$designerName}, ini terkait Order {$order->code}. Boleh diskusi sebentar?";
            $waLink = $waDigits ? 'https://wa.me/' . $waDigits . '?text=' . urlencode($waMessage) : null;
        @endphp
        @php $canCancel = $order->isCancellable(); @endphp
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Order {{ $order->code }}</h4>
                <div class="d-flex gap-2">
                    @if ($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener"
                            class="btn btn-sm btn-outline-success">
                            <i class="bi bi-whatsapp"></i> Chat Designer
                        </a>
                    @endif
                    @if ($canCancel)
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal"
                            data-target="#cancelModal">
                            Cancel Order
                        </button>
                    @endif

                    <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>

            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="mb-2"><strong>Designer:</strong>
                            {{ $order->designer->display_name ?? $order->designer->user->name }}</div>
                        <div class="mb-2"><strong>Status:</strong>
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </div>
                        <div class="mb-2"><strong>Payment:</strong>
                            <span
                                class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'submitted' ? 'warning text-dark' : 'secondary') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="mb-2"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded p-2">
                            <div class="fw-semibold mb-1">Payment Instructions</div>
                            <div>Bank: {{ $order->pay_bank_name ?? '-' }}</div>
                            <div>Account No.: {{ $order->pay_bank_account_no ?? '-' }}</div>
                            <div class="mt-2">
                                @if ($order->pay_qris_image)
                                    @php $qrUrl = asset('storage/' . $order->pay_qris_image); @endphp

                                    {{-- QR thumbnail (click to enlarge modal) --}}
                                    <img src="{{ $qrUrl }}" class="img-fluid rounded border"
                                        style="max-height:180px; cursor: zoom-in;" alt="Payment QRIS"
                                        data-bs-toggle="modal" data-bs-target="#qrPreviewModalCustomer">

                                    {{-- QR actions --}}
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal" data-bs-target="#qrPreviewModalCustomer">
                                            Enlarge
                                        </button>
                                        <a href="{{ $qrUrl }}" target="_blank" rel="noopener"
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $it)
                                <tr>
                                    <td>{{ $it->title_snapshot }}</td>
                                    <td>{{ $it->qty }}</td>
                                    <td>Rp {{ number_format($it->price_snapshot, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($it->price_snapshot * $it->qty, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Upload payment proof --}}
                @php
                    // semua item sudah diset completed?
                    $allItemsCompleted = $order->items->where('item_status', '!=', 'completed')->count() === 0;
                @endphp

                {{-- PAYMENT SECTION --}}
                @if ($allItemsCompleted && $order->payment_status !== 'paid')

                    @if ($order->payment_status === 'submitted')
                        <div class="alert alert-info mt-3">
                            Payment proof submitted. Waiting for designer to confirm.
                        </div>
                    @elseif ($order->shipping_method === 'ship' && is_null($order->shipping_fee))
                        <div class="alert alert-info mt-3">
                            Waiting for the designer to set the shipping fee. You can pay once the total includes
                            shipping.
                        </div>
                    @else
                        {{-- unpaid / rejected -> boleh upload --}}
                        @if ($order->payment_status === 'rejected')
                            <div class="alert alert-warning mt-3">
                                Your previous payment proof was rejected. Please re-upload a valid proof.
                            </div>
                        @endif

                        <div class="mt-3">
                            <div class="fw-semibold mb-2">Upload Proof of Payment</div>
                            <form method="POST" action="{{ route('customer.orders.proof', $order) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="file" name="image" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="amount" class="form-control"
                                            placeholder="Amount (optional)">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="payer_name" class="form-control"
                                            placeholder="Payer name (optional)">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary w-100">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif


                {{-- SHIPPING (Customer) --}}
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
                                    <div><strong>Recipient:</strong> {{ $order->ship_name }}
                                        ({{ $order->ship_phone }})
                                    </div>
                                    <div><strong>Address:</strong> {{ $order->ship_address }},
                                        {{ $order->ship_city }},
                                        {{ $order->ship_province }} {{ $order->ship_postal_code }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>Courier:</strong> {{ $order->shipping_courier ?? '-' }}</div>
                                    <div><strong>Tracking No.:</strong> {{ $order->shipping_tracking_no ?? '-' }}</div>
                                    <div><strong>Shipping Fee:</strong> Rp
                                        {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}</div>
                                    @if ($order->shipped_at)
                                        <div class="small text-muted">Shipped at: {{ $order->shipped_at }}</div>
                                    @endif
                                    @if ($order->delivered_at)
                                        <div class="small text-muted">Delivered at: {{ $order->delivered_at }}</div>
                                    @endif
                                </div>
                            </div>

                            @if ($order->payment_status === 'paid' && $order->shipping_status === 'shipped')
                                <form method="POST" action="{{ route('customer.orders.confirm-delivered', $order) }}"
                                    class="mt-3">
                                    @csrf
                                    <button class="btn btn-success btn-sm"
                                        onclick="return confirm('Confirm the package has been received?')">
                                        Confirm Package Received
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
                {{-- Items & Deliverables --}}
                <h5>Items</h5>
                <div class="table-responsive">

                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Design</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Deliverables</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $it)
                                <tr>
                                    <td>{{ $it->title_snapshot }}</td>
                                    <td>{{ $it->qty }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($it->item_status) }}</span></td>
                                    <td>
                                        @forelse($it->deliverables as $d)
                                            @php
                                                $can =
                                                    (($d->visible_after === 'paid' &&
                                                        $order->payment_status === 'paid') ||
                                                        ($d->visible_after === 'delivered' &&
                                                            in_array($it->item_status, ['delivered', 'completed'])) ||
                                                        ($d->visible_after === 'completed' &&
                                                            $order->status === 'completed')) &&
                                                    (is_null($d->expires_at) ||
                                                        now()->lessThanOrEqualTo($d->expires_at)) &&
                                                    (is_null($d->download_limit) || $d->download_limit > 0);
                                            @endphp



                                            <div
                                                class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                                <div class="small">
                                                    <i class="fas fa-paperclip me-1"></i> File
                                                    <span class="text-muted">({{ $d->visible_after }})</span>
                                                    @if (!is_null($d->download_limit))
                                                        <span class="ms-2 badge bg-light text-dark">Remaining
                                                            {{ $d->download_limit }}</span>
                                                    @endif
                                                    @if ($d->expires_at)
                                                        <span class="ms-2 small text-muted">Exp:
                                                            {{ \Carbon\Carbon::parse($d->expires_at)->format('d-m-Y H:i') }}</span>
                                                    @endif
                                                </div>
                                                @if ($can)
                                                    <a href="{{ route('customer.orders.deliverables.download', $d->id) }}"
                                                        class="btn btn-sm btn-primary">Download</a>
                                                @else
                                                    <span class="text-muted small">Not available yet</span>
                                                @endif
                                            </div>
                                        @empty
                                            <span class="text-muted">No files yet.</span>
                                        @endforelse
                                    </td>
                                    {{-- Customer actions for delivered items --}}
                                    @php
                                        $canAct = in_array($it->item_status, ['delivered', 'revised']);
                                    @endphp
                                    <td>
                                        @if ($canAct)
                                            <div class="d-flex gap-2">
                                                <form method="POST"
                                                    action="{{ route('customer.orders.items.accept', $it->id) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">Accept Result</button>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('customer.orders.items.revision', $it->id) }}"
                                                    class="d-flex gap-2">
                                                    @csrf
                                                    <input type="text" name="note"
                                                        class="form-control form-control-sm"
                                                        placeholder="Revision note..." required>
                                                    <button class="btn btn-sm btn-outline-danger">Request
                                                        Revision</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Rating & Review --}}
                @php
                    // semua item sudah selesai?
                    $allItemsCompleted = $order->items->where('item_status', '!=', 'completed')->count() === 0;

                    // boleh rating kalau:
                    // - semua item sudah completed, DAN
                    //   - pembayaran sudah paid, ATAU
                    //   - shipping sudah delivered (kalau pakai kirim fisik)
                    $canRate =
                        $allItemsCompleted &&
                        ($order->payment_status === 'paid' || $order->shipping_status === 'delivered');
                @endphp

                @if ($canRate)
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Designer Rating</h5>
                            @if ($order->rating)
                                <span class="badge bg-success">Rated: {{ $order->rating->stars }}/5</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (!$order->rating)
                                <form method="POST" action="{{ route('customer.orders.rating', $order) }}">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-md-2">
                                            <select name="stars" class="form-select" required>
                                                <option value="" selected disabled>Select stars</option>
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <option value="{{ $i }}">{{ $i }} ⭐
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="review" class="form-control"
                                                placeholder="Write a review (optional)">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary w-100">Submit Rating</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div>
                                    <strong>{{ $order->rating->stars }} / 5</strong> —
                                    {{ $order->rating->review ?? 'No review' }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif


            </div>
        </div>

        {{-- QR Preview Modal for Customer --}}
        @if ($order->pay_qris_image)
            @php $qrUrl = asset('storage/' . $order->pay_qris_image); @endphp
            <div class="modal fade" id="qrPreviewModalCustomer" tabindex="-1" aria-hidden="true">
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
                            <a href="{{ $qrUrl }}" target="_blank" rel="noopener"
                                class="btn btn-outline-secondary">Open in New Tab</a>
                            <a href="{{ $qrUrl }}" download class="btn btn-primary">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @push('modals')
            <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('customer.orders.cancel', ['order' => $order->id]) }}"
                        class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Cancel Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="small text-muted">
                                You can cancel as long as the designer hasn't submitted any deliverables and no payment has
                                been made.
                            </p>

                            <label class="form-label">Cancellation Reason</label>
                            <textarea name="cancel_reason" class="form-control @error('cancel_reason') is-invalid @enderror" rows="3"
                                required maxlength="1000">{{ old('cancel_reason') }}</textarea>
                            @error('cancel_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-danger" type="submit">Confirm Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endpush


        @if ($errors->has('cancel_reason'))
            @push('lastScripts')
                <script>
                    // pastikan jalan setelah semua script loaded
                    window.addEventListener('load', function() {
                        $('#cancelModal').modal('show');
                    });
                </script>
            @endpush
        @endif

</x-app-layouts>
