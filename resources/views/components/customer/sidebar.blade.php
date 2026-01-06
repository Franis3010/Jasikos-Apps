<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        {{-- Logo Brand (optional) --}}
        {{-- <div class="sidebar-brand" style="margin-bottom:20px;">
            <a href="{{ route('customer.dashboard') }}">
                <img src="/assets/images/logo/logo rsd.png" alt="Logo" style="width:80px;height:80px" class="header-logo" />
            </a>
        </div> --}}
        <div class="sidebar-brand" style="margin-bottom:20px;">
            <a href="{{ route('customer.dashboard') }}" class="small">Jasikos Customer</a>
        </div>

        <ul class="sidebar-menu mt-3">
            <li class="menu-header">Main Navigation</li>

            <li class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                <a href="{{ route('customer.dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i><span>Dashboard</span>
                </a>
            </li>

            {{-- Catalog (public) --}}
            <li class="{{ request()->routeIs('designs.*') ? 'active' : '' }}">
                <a href="{{ route('designs.index') }}" class="nav-link">
                    <i class="fas fa-th-large"></i><span>Catalog</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('customer.cart.*') ? 'active' : '' }}">
                <a href="{{ route('customer.cart.index') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i><span>Cart</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">
                <a href="{{ route('customer.orders.index') }}" class="nav-link">
                    <i class="fas fa-file-invoice"></i><span>Orders</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('customer.custom-requests.create') ? 'active' : '' }}">
                <a href="{{ route('customer.custom-requests.create') }}" class="nav-link">
                    <i class="fas fa-plus-circle"></i><span>Create Custom Request</span>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('customer.custom-requests.index', 'customer.custom-requests.show') ? 'active' : '' }}">
                <a href="{{ route('customer.custom-requests.index') }}" class="nav-link">
                    <i class="fas fa-pencil-ruler"></i><span>Custom Requests</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
                <a href="{{ route('customer.profile.edit') }}" class="nav-link">
                    <i class="fas fa-user"></i><span>Profile</span>
                </a>
            </li>

            {{-- Logout (optional) --}}
            {{-- <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="nav-link btn btn-link text-start w-100">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </button>
                </form>
            </li> --}}
        </ul>
    </aside>
</div>
