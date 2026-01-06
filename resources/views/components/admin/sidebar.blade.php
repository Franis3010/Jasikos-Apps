<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="margin-bottom:20px;">
            <a href="{{ route('admin.dashboard') }}">Jasikos Admin</a>
        </div>

        <ul class="sidebar-menu mt-3">
            <li class="menu-header">Main Navigation</li>

            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i><span>Users</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-tags"></i><span>Categories</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.designs.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.designs.index') }}">
                    <i class="fas fa-image"></i><span>Designs</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-file-invoice"></i><span>Orders</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.settings.content') }}">
                    <i class="fas fa-feather"></i><span>Site Content</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
