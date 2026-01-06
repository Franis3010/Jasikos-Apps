<x-app-layouts title="Customer Dashboard">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Hello, {{ auth()->user()->name }}!</h4>
                <small class="text-muted">Welcome to the customer dashboard.</small>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        <div class="card-body">
            {{-- Alert kelengkapan profil --}}
            @if ($profileIncomplete)
                <div class="alert alert-warning d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Complete your address profile.</strong>
                        <br>Address/City/Province are incomplete. This will help during checkout.
                    </div>
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-sm btn-outline-dark">Complete
                        Profile</a>
                </div>
            @endif

            {{-- Quick stats --}}
            <div class="row g-3 mb-3">
                <div class="col-md-2 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Total Orders</div>
                        <div class="display-6">{{ $stats['total'] }}</div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Awaiting Payment</div>
                        <div class="display-6">{{ $stats['awaiting_payment'] }}</div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Payment Submitted</div>
                        <div class="display-6">{{ $stats['payment_submitted'] }}</div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Processing/Shipped</div>
                        <div class="display-6">{{ $stats['processing'] }}</div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Completed</div>
                        <div class="display-6">{{ $stats['completed'] }}</div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Cart</div>
                        <div class="display-6">{{ $cartCount }}</div>
                    </div>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('customer.browse-designs') }}" class="btn btn-outline-primary">
                    <i class="fas fa-grid-2"></i> View Catalog
                </a>
                <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-shopping-cart"></i> Cart
                </a>
                <a href="{{ route('customer.orders.index') }}" class="btn btn-primary">
                    <i class="fas fa-receipt"></i> My Orders
                </a>
                <a href="{{ route('customer.custom-requests.create') }}" class="btn btn-outline-dark">
                    <i class="fas fa-pencil-ruler"></i> Create Custom Request
                </a>
                <a href="{{ route('customer.profile.edit') }}" class="btn btn-outline-info">
                    <i class="fas fa-user"></i> Edit Profile
                </a>
            </div>

            {{-- Menunggu pembayaran --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Action Needed: Awaiting Payment</h5>
                </div>
                <div class="card-body">
                    @if ($payables->isEmpty())
                        <p class="text-muted mb-0">No orders awaiting payment.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Designer</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payables as $o)
                                        <tr>
                                            <td>{{ $o->code }}</td>
                                            <td>{{ $o->designer->display_name ?? $o->designer->user->name }}</td>
                                            <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $o->payment_status === 'submitted' ? 'warning text-dark' : 'secondary' }}">
                                                    {{ ucfirst($o->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.orders.show', $o) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Continue Payment
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Orders terbaru --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Latest Orders</h5>
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-secondary">View
                        All</a>
                </div>
                <div class="card-body">
                    @if ($latestOrders->isEmpty())
                        <p class="text-muted mb-0">No orders yet.</p>
                    @else
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
                                    @foreach ($latestOrders as $o)
                                        <tr>
                                            <td>{{ $o->code }}</td>
                                            <td>{{ $o->designer->display_name ?? $o->designer->user->name }}</td>
                                            <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $o->status)) }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $o->payment_status === 'paid' ? 'success' : ($o->payment_status === 'submitted' ? 'warning text-dark' : 'secondary') }}">
                                                    {{ ucfirst($o->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.orders.show', $o) }}"
                                                    class="btn btn-sm btn-outline-primary">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layouts>
