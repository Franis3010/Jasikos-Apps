<x-app-layouts title="Incoming Orders">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Orders</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            <tr>
                                <td>{{ $o->code }}</td>
                                <td>{{ $o->customer->user->name ?? 'Customer' }}</td>
                                <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $o->status)) }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $o->payment_status === 'paid' ? 'success' : ($o->payment_status === 'submitted' ? 'warning text-dark' : 'secondary') }}">
                                        {{ ucfirst($o->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $o->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('designer.orders.show', $o) }}"
                                        class="btn btn-sm btn-primary">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layouts>
