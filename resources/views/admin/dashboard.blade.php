<x-app-layouts title="Admin Dashboard">
    {{-- ===== Top stats ===== --}}
    <div class="row g-3">
        <div class="col-md-3 col-6">
            <div class="card stat-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="stat-icon"><i class="fas fa-users"></i></span>
                        <div class="fw-semibold">Users</div>
                    </div>
                    <div class="stat-value">{{ number_format($counts['users']['total']) }}</div>
                </div>
                <div class="d-flex flex-wrap gap-1">
                    <span class="badge rounded-pill bg-light text-dark">Admin: {{ $counts['users']['admin'] }}</span>
                    <span class="badge rounded-pill bg-light text-dark">Designer:
                        {{ $counts['users']['designer'] }}</span>
                    <span class="badge rounded-pill bg-light text-dark">Customer:
                        {{ $counts['users']['customer'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card stat-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="stat-icon"><i class="fas fa-image"></i></span>
                        <div class="fw-semibold">Designs</div>
                    </div>
                    <div class="stat-value">{{ number_format($counts['designs']['total']) }}</div>
                </div>
                <div class="d-flex flex-wrap gap-1">
                    <span class="badge rounded-pill bg-light text-dark">Published:
                        {{ $counts['designs']['published'] }}</span>
                    <span class="badge rounded-pill bg-light text-dark">Draft: {{ $counts['designs']['draft'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card stat-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="stat-icon"><i class="fas fa-file-invoice"></i></span>
                        <div class="fw-semibold">Orders</div>
                    </div>
                    <div class="stat-value">{{ number_format($counts['orders']['total']) }}</div>
                </div>
                <div class="d-flex flex-wrap gap-1">
                    <span class="badge rounded-pill bg-light text-dark">Awaiting:
                        {{ $counts['orders']['awaiting'] }}</span>
                    <span class="badge rounded-pill bg-light text-dark">Processing:
                        {{ $counts['orders']['processing'] }}</span>
                    <span class="badge rounded-pill bg-light text-dark">Completed:
                        {{ $counts['orders']['completed'] }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card stat-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="stat-icon"><i class="fas fa-credit-card"></i></span>
                        <div class="fw-semibold">Payments</div>
                    </div>
                    <div class="stat-value">{{ number_format($counts['payments']['submitted']) }}</div>
                </div>
                <div class="text-muted small">Submitted</div>
            </div>
        </div>
    </div>

    {{-- ===== Recent orders ===== --}}
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">Recent Orders</h5>
        </div>
        <div class="card-body table-responsive">
            @php
                $statusColor = ['awaiting' => 'warning', 'processing' => 'primary', 'completed' => 'success'];
                $paymentColor = [
                    'submitted' => 'warning',
                    'paid' => 'success',
                    'failed' => 'danger',
                    'pending' => 'secondary',
                ];
            @endphp
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Customer</th>
                        <th>Designer</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $o)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $o) }}"
                                    class="text-decoration-none fw-semibold">{{ $o->code }}</a></td>
                            <td>{{ $o->customer->user->name ?? '-' }}</td>
                            <td>{{ $o->designer->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $statusColor[$o->status] ?? 'secondary' }}">
                                    {{ ucfirst($o->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $paymentColor[$o->payment_status] ?? 'secondary' }}">
                                    {{ ucfirst($o->payment_status) }}
                                </span>
                            </td>
                            <td class="text-end">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layouts>

@push('styles')
    <style>
        .stat-card {
            border: 1px solid #e5e7eb;
            /* lebih ringan */
            border-radius: 1rem;
            padding: 1.25rem !important;
            /* lebih lega dari p-3 */
            box-shadow: 0 .6rem 1.2rem rgba(0, 0, 0, .05);
            transition: .18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .9rem 1.6rem rgba(0, 0, 0, .07);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
        }

        .stat-icon i {
            font-size: 1.05rem;
        }

        .stat-value {
            font-weight: 800;
            font-size: 1.5rem;
            /* sedikit lebih besar */
            line-height: 1.1;
        }

        /* beri nafas di dalam card */
        .stat-card .mb-2 {
            margin-bottom: .75rem !important;
        }

        .stat-card .d-flex.flex-wrap.gap-1 {
            gap: .5rem !important;
        }

        .stat-card .badge {
            padding: .45rem .6rem;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
        }

        /* opsional: kalau mau table card lebih lega */
        /* tambahkan class 'table-card' di card recent orders kalau mau rule ini aktif */
        .card.table-card .card-body {
            padding: 1.25rem 1.25rem;
        }

        @media (min-width: 768px) {
            .stat-card {
                padding: 1.5rem !important;
            }
        }
    </style>
@endpush
