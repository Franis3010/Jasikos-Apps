<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        {{-- Logo Brand (optional) --}}
        {{-- <div class="sidebar-brand" style="margin-bottom:20px;">
            <a href="{{ route('designer.dashboard') }}">
                <img src="/assets/images/logo/logo rsd.png" alt="Logo" style="width:80px;height:80px" class="header-logo" />
            </a>
        </div> --}}
        <div class="sidebar-brand" style="margin-bottom:20px;">
            <a href="{{ route('designer.dashboard') }}" class="small">Jasikos Designer</a>
        </div>

        <ul class="sidebar-menu mt-3">
            <li class="menu-header">Main Navigation</li>

            <li class="{{ request()->routeIs('designer.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('designer.dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('designer.profile.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('designer.profile.edit') }}">
                    <i class="fas fa-user-edit"></i> <span>Profile</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('designer.designs.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('designer.designs.index') }}">
                    <i class="fas fa-images"></i> <span>Designs</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('designer.orders.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('designer.orders.index') }}">
                    <i class="fas fa-file-invoice"></i> <span>Orders</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('designer.custom-requests.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('designer.custom-requests.index') }}">
                    <i class="fas fa-pencil-ruler"></i> <span>Custom Requests</span>
                </a>
            </li>

            {{-- Logout (optional) --}}
            {{-- <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="nav-link btn btn-link text-start w-100">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </button>
                </form>
            </li> --}}
        </ul>
    </aside>
</div>
