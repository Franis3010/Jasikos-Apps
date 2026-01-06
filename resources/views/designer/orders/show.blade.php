<x-app-layouts title="Designer Order Details">
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Order {{ $order->code }}</h4>
            <a href="{{ route('designer.orders.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>

        <div class="card-body">
            @php
                // minimal satu item berstatus delivered/completed (artinya designer sudah submit)
                $anyDeliveredItem = $order->items->contains(
                    fn($it) => in_array($it->item_status, ['delivered', 'completed']),
                );
                // ada berkas deliverable apa pun
                $hasAnyDeliverable = $order->items->some(fn($it) => $it->deliverables->count() > 0);
            @endphp

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
            @if ($order->payment_status !== 'paid' && !$anyDeliveredItem)
                <div class="alert alert-info">
                    Customers can still cancel until you upload the first deliverable.
                    Once you submit (the item status is delivered), customers can no longer cancel.
                </div>
            @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <div><strong>Customer:</strong> {{ $order->customer->user->name ?? '-' }}</div>
                    <div><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</div>
                    <div>
                        <strong>Payment:</strong>
                        <span
                            class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'submitted' ? 'warning text-dark' : 'secondary') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded p-2">
                        <div class="fw-semibold mb-1">Payment Destination (snapshot)</div>
                        <div>Bank: {{ $order->pay_bank_name ?? '-' }}</div>
                        <div>Account No.: {{ $order->pay_bank_account_no ?? '-' }}</div>

                        <div class="mt-2">
                            @if ($order->pay_qris_image)
                                @php $qrUrl = asset('storage/' . $order->pay_qris_image); @endphp

                                {{-- QR thumbnail (click to enlarge) --}}
                                <img src="{{ $qrUrl }}" class="img-fluid rounded border"
                                    style="max-height:160px; cursor: zoom-in;" alt="QRIS" data-bs-toggle="modal"
                                    data-bs-target="#qrPreviewModal">

                                {{-- Actions for QR --}}
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#qrPreviewModal">
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

            {{-- Payment proofs --}}
            <h5>Payment Proofs</h5>

            @if (!$anyDeliveredItem)
                <p class="text-muted mb-3">
                    Payment will be processed after you <strong>submit at least one deliverable</strong>
                    (set an item status to <em>delivered</em>). Until then, the customer can still cancel.
                </p>
            @else
                @if ($order->paymentProofs->isEmpty())
                    <p class="text-muted">No proofs yet.</p>
                @else
                    <div class="row g-2 mb-3">
                        @foreach ($order->paymentProofs as $p)
                            @php
                                $proofUrl = asset('storage/' . $p->image_path);
                                $modalId = 'proofModal-' . $p->id;
                            @endphp

                            <div class="col-md-3 col-6">
                                <div class="border rounded p-2">
                                    {{-- Proof thumbnail (click to open modal) --}}
                                    <img src="{{ $proofUrl }}" class="img-fluid rounded mb-2 border"
                                        style="max-height:140px; cursor: zoom-in;"
                                        alt="Payment Proof #{{ $p->id }}" data-bs-toggle="modal"
                                        data-bs-target="#{{ $modalId }}">

                                    <div class="small mb-2">
                                        <span
                                            class="badge bg-{{ $p->status === 'accepted' ? 'success' : ($p->status === 'rejected' ? 'danger' : 'warning text-dark') }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </div>

                                    {{-- Actions for proof --}}
                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                            Enlarge
                                        </button>
                                        <a href="{{ $proofUrl }}" target="_blank" rel="noopener"
                                            class="btn btn-sm btn-outline-secondary">
                                            Open
                                        </a>
                                        <a href="{{ $proofUrl }}" download class="btn btn-sm btn-primary">
                                            Download
                                        </a>
                                    </div>

                                    {{-- Accept payment button (if still submitted & order not paid) --}}
                                    @if ($order->payment_status !== 'paid' && $p->status === 'submitted')
                                        <form method="POST" action="{{ route('designer.orders.confirm', $order) }}">
                                            @csrf
                                            <input type="hidden" name="proof_id" value="{{ $p->id }}">
                                            <button class="btn btn-sm btn-success w-100">Accept Payment</button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Modal Preview for each Payment Proof --}}
                            <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header py-2">
                                            <h6 class="modal-title">Payment Proof #{{ $p->id }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ $proofUrl }}" alt="Payment Proof #{{ $p->id }}"
                                                class="img-fluid rounded" style="max-height:80vh;">
                                        </div>
                                        <div class="modal-footer py-2">
                                            <a href="{{ $proofUrl }}" target="_blank" rel="noopener"
                                                class="btn btn-outline-secondary">Open in New Tab</a>
                                            <a href="{{ $proofUrl }}" download class="btn btn-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($order->payment_status !== 'paid')
                    <form method="POST" action="{{ route('designer.orders.confirm', $order) }}" class="mb-3">
                        @csrf
                        <button class="btn btn-success">Confirm Without Selecting Proof (accept payment)</button>
                    </form>
                @endif
            @endif

            {{-- SHIPPING (Designer) --}}
            @if ($order->shipping_method === 'ship')
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Shipping</h5>
                        <span
                            class="badge bg-secondary text-uppercase">{{ $order->shipping_status ?? 'pending' }}</span>
                    </div>
                    <div class="card-body">
                        {{-- Recipient address summary --}}
                        <div class="mb-3">
                            <div><strong>Recipient:</strong> {{ $order->ship_name }} ({{ $order->ship_phone }})</div>
                            <div><strong>Address:</strong> {{ $order->ship_address }}, {{ $order->ship_city }},
                                {{ $order->ship_province }} {{ $order->ship_postal_code }}</div>
                        </div>

                        {{-- Current status --}}
                        <div class="row g-2 mb-2">
                            <div class="col-md-4"><strong>Courier:</strong> {{ $order->shipping_courier ?? '-' }}
                            </div>
                            <div class="col-md-4"><strong>Tracking No.:</strong>
                                {{ $order->shipping_tracking_no ?? '-' }}</div>
                            <div class="col-md-4"><strong>Shipping Fee:</strong> Rp
                                {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }}</div>
                        </div>

                        @if ($order->payment_status !== 'paid')
                            {{-- STEP 1: Set shipping fee first --}}
                            <hr class="my-3">
                            <form method="POST" action="{{ route('designer.orders.shipping', $order) }}"
                                class="row g-2">
                                @csrf
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="shipping_fee"
                                        placeholder="Shipping Fee / Ongkir (required)"
                                        value="{{ old('shipping_fee', $order->shipping_fee) }}" required>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary btn-sm mt-2">Save Shipping Fee</button>
                                </div>
                            </form>
                            <div class="small text-muted mt-2">
                                1. Determine the shipping cost first. <br>
                                2. After saving, the customer will pay the TOTAL + shipping and upload proof of payment.
                            </div>
                        @else
                            {{-- STEP 2: After paid, fill courier & tracking --}}
                            <hr class="my-3">
                            <form method="POST" action="{{ route('designer.orders.shipping', $order) }}"
                                class="row g-2">
                                @csrf
                                <div class="col-md-4">
                                    <input class="form-control" name="shipping_courier"
                                        placeholder="Courier (JNE/JNT/SiCepat)"
                                        value="{{ old('shipping_courier', $order->shipping_courier) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" name="shipping_tracking_no"
                                        placeholder="Tracking No."
                                        value="{{ old('shipping_tracking_no', $order->shipping_tracking_no) }}"
                                        required>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary btn-sm mt-2">Save Courier & Tracking</button>
                                </div>
                            </form>

                            @php
                                $canShip =
                                    $order->shipping_courier &&
                                    $order->shipping_tracking_no &&
                                    $order->shipping_status !== 'shipped';
                            @endphp
                            <form method="POST" action="{{ route('designer.orders.mark-shipped', $order) }}"
                                class="mt-2">
                                @csrf
                                <button class="btn btn-outline-primary btn-sm" {{ $canShip ? '' : 'disabled' }}
                                    onclick="return confirm('Mark as SHIPPED?')">
                                    Mark as Shipped
                                </button>
                                @unless ($canShip)
                                    <div class="small text-muted mt-1">
                                        First fill in the courier & receipt number, or the order has been marked as SHIPPED.
                                    </div>
                                @endunless
                            </form>
                        @endif

                    </div>
                </div>
            @endif
            <hr>
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
                            <th>Discussion</th>
                            <th>Upload Deliverable</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $it)
                            <tr>
                                <td>{{ $it->title_snapshot }}</td>
                                <td>{{ $it->qty }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($it->item_status) }}</span></td>

                                {{-- Deliverables --}}
                                <td style="width:260px">
                                    @forelse($it->deliverables as $d)
                                        <div class="small">
                                            <i class="fas fa-paperclip"></i>
                                            <a href="{{ asset('storage/' . $d->file_path) }}"
                                                target="_blank">File</a>
                                            <span class="text-muted">({{ $d->visible_after }})</span>
                                        </div>
                                    @empty
                                        <span class="text-muted">None yet.</span>
                                    @endforelse
                                </td>

                                {{-- Discussion / Comments --}}
                                <td style="width:340px">
                                    <div class="mb-2 border rounded p-2" style="max-height:160px; overflow:auto">
                                        @forelse($it->comments as $cm)
                                            <div class="small mb-1">
                                                <strong>{{ $cm->user->name }}:</strong> {{ $cm->message }}
                                                <span class="text-muted">•
                                                    {{ $cm->created_at->format('d-m H:i') }}</span>
                                            </div>
                                        @empty
                                            <div class="text-muted small">No comments yet.</div>
                                        @endforelse
                                    </div>

                                    {{-- Reply to comment --}}
                                    <form method="POST"
                                        action="{{ route('designer.orders.items.comment', $it->id) }}"
                                        class="mb-2">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="message" class="form-control"
                                                placeholder="Reply to comment..." required>
                                            <button class="btn btn-outline-secondary" type="submit">Send</button>
                                        </div>
                                    </form>

                                    {{-- Optional: mark revised --}}
                                    <form method="POST"
                                        action="{{ route('designer.orders.items.mark-revised', $it->id) }}">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="note" class="form-control"
                                                placeholder="Revision note..." required>
                                            <button class="btn btn-outline-danger" type="submit">Mark
                                                Revised</button>
                                        </div>
                                    </form>
                                </td>

                                {{-- Upload Deliverable --}}
                                <td style="width:340px">
                                    <form method="POST" action="{{ route('designer.orders.deliverable', $it->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex flex-column gap-2">
                                            <input type="file" name="file" class="form-control form-control-sm"
                                                required>
                                            <div class="d-flex gap-2">
                                                <select name="visible_after" class="form-select form-select-sm">
                                                    <option value="paid">paid</option>
                                                    <option value="delivered">delivered</option>
                                                    <option value="completed">completed</option>
                                                </select>
                                                <button class="btn btn-sm btn-primary w-100">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>

                                {{-- Actions --}}
                                <td style="width:160px" class="text-end">
                                    <div class="d-grid gap-1">
                                        @if (in_array($it->item_status, ['processing', 'revised']))
                                            {{-- Send final to customer (request approval) --}}
                                            <form method="POST"
                                                action="{{ route('designer.orders.update', $order) }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="item_id" value="{{ $it->id }}">
                                                <input type="hidden" name="item_status" value="delivered">
                                                <button class="btn btn-sm btn-outline-primary w-100">Send Final
                                                    (request approval)
                                                </button>
                                            </form>
                                        @elseif ($it->item_status === 'delivered')
                                            <span class="badge bg-info w-100">Waiting for Approval</span>
                                        @elseif ($it->item_status === 'completed')
                                            <span class="badge bg-success w-100">Completed</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> {{-- /card-body --}}
    </div>

    {{-- QR Preview Modal --}}
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
                        <a href="{{ $qrUrl }}" target="_blank" rel="noopener"
                            class="btn btn-outline-secondary">Open in New Tab</a>
                        <a href="{{ $qrUrl }}" download class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Preview for each Payment Proof --}}
    @foreach ($order->paymentProofs as $p)
        @php
            $proofUrl = asset('storage/' . $p->image_path);
            $modalId = 'proofModal-' . $p->id;
        @endphp
        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title">Payment Proof #{{ $p->id }}</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ $proofUrl }}" alt="Payment Proof #{{ $p->id }}"
                            class="img-fluid rounded" style="max-height:80vh;">
                    </div>
                    <div class="modal-footer py-2">
                        <a href="{{ $proofUrl }}" target="_blank" rel="noopener"
                            class="btn btn-outline-secondary">Open in New Tab</a>
                        <a href="{{ $proofUrl }}" download class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layouts>
