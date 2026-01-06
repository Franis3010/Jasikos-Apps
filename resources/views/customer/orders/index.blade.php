<x-app-layouts title="My Orders">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Order List</h4>
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
                            <th>Designer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            <tr>
                                <td>{{ $o->code }}</td>
                                <td>{{ $o->designer->display_name ?? $o->designer->user->name }}</td>
                                <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                                <td><span
                                        class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $o->status)) }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $o->payment_status === 'paid' ? 'success' : ($o->payment_status === 'submitted' ? 'warning text-dark' : 'secondary') }}">
                                        {{ ucfirst($o->payment_status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('customer.orders.show', $o) }}"
                                        class="btn btn-sm btn-primary">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No orders yet.</td>
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
