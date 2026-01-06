<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                    <i data-feather="align-justify"></i>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                    <i data-feather="maximize"></i>
                </a>
            </li>
        </ul>
    </div>

    <ul class="navbar-nav navbar-right">
        <li class="nav-item">
            <a href="#" class="nav-link nav-link-lg">
                <i data-feather="user"></i>
                <span class="ml-1 text-dark">{{ Auth::user()->email ?? Auth::user()->name }}</span>
            </a>
        </li>
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link nav-link-lg btn btn-link text-danger m-0 p-0" style="border: none;">
                    <i data-feather="log-out"></i>
                </button>
            </form>
        </li>
    </ul>
</nav>
