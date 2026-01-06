<x-app-layouts title="Orders">
    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                <select name="status" class="form-select" style="min-width: 200px" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    @foreach (['awaiting_payment', 'processing', 'delivered', 'completed', 'cancelled', 'declined'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                    @endforeach
                </select>

                <select name="pay" class="form-select" style="min-width: 200px" onchange="this.form.submit()">
                    <option value="">All Payments</option>
                    @foreach (['unpaid', 'submitted', 'paid', 'rejected'] as $p)
                        <option value="{{ $p }}" @selected(request('pay') === $p)>{{ $p }}</option>
                    @endforeach
                </select>

                <button class="btn btn-primary" type="submit">Filter</button>
                @if (request('status') || request('pay'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>

        <div class="card-body table-responsive">
            @php
                $statusBadge = [
                    'awaiting_payment' => 'secondary',
                    'processing' => 'info',
                    'delivered' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    'declined' => 'danger',
                ];
                $payBadge = [
                    'unpaid' => 'secondary',
                    'submitted' => 'warning',
                    'paid' => 'success',
                    'rejected' => 'danger',
                ];
            @endphp

            <table class="table table-bordered table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:120px">Code</th>
                        <th>Customer</th>
                        <th>Designer</th>
                        <th style="width:140px">Status</th>
                        <th style="width:140px">Payment</th>
                        <th class="text-end" style="width:140px">Total</th>
                        <th>Shipping</th>
                        <th style="width:90px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $o)
                        @php
                            $statusLabel = ucwords(str_replace('_', ' ', $o->status));
                            $payLabel = ucwords(str_replace('_', ' ', $o->payment_status));
                        @endphp
                        <tr>
                            <td class="text-monospace">{{ $o->code }}</td>
                            <td>{{ $o->customer->user->name ?? '-' }}</td>
                            <td>{{ $o->designer->user->name ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $statusBadge[$o->status] ?? 'secondary' }}">{{ $statusLabel }}</span>
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $payBadge[$o->payment_status] ?? 'secondary' }}">{{ $payLabel }}</span>
                            </td>
                            <td class="text-end">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                            <td>
                                @if ($o->shipping_method === 'ship')
                                    <span
                                        class="badge bg-light text-dark">{{ $o->shipping_status ?? 'pending' }}</span>
                                @else
                                    <span class="badge bg-secondary">digital</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.orders.show', $o) }}">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No orders.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">{{ $orders->links() }}</div>
        </div>
    </div>
</x-app-layouts>
