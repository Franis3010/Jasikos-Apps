<x-app-layouts title="Designer Dashboard">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Hello, {{ $designer->display_name ?? auth()->user()->name }}!</h4>
                <small class="text-muted">Welcome to the designer dashboard.</small>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </button>
            </form>
        </div>

        <div class="card-body">
            {{-- Profile completeness alert --}}
            @if (!$designer->bank_name || !$designer->bank_account_no || !$designer->bank_account_name || !$designer->qris_image)
                <div class="alert alert-warning d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Complete your payment profile.</strong>
                        <br>Bank/QRIS information is incomplete. Fill it in so customers can see the payment
                        instructions.
                    </div>
                    <a href="{{ route('designer.profile.edit') }}" class="btn btn-sm btn-outline-dark">
                        Complete Now
                    </a>
                </div>
            @endif

            {{-- Quick stats --}}
            <div class="row g-3 mb-3">
                <div class="col-md-3 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Total Designs</div>
                        <div class="display-6">{{ $stats['designs'] }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="border rounded p-3 text-center">
                        <div class="fw-semibold">Published</div>
                        <div class="display-6">{{ $stats['published'] }}</div>
                    </div>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('designer.profile.edit') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <a href="{{ route('designer.designs.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Design
                </a>
                <a href="{{ route('designer.designs.index') }}" class="btn btn-primary">
                    <i class="fas fa-images"></i> Manage Designs
                </a>
                <a href="{{ route('designer.orders.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-receipt"></i> Orders
                </a>
                <a href="{{ route('designer.custom-requests.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-pencil-ruler"></i> Custom Requests
                </a>
            </div>
        </div>
    </div>
</x-app-layouts>
