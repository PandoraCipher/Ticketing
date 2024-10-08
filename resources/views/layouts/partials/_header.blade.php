<header class="navbar bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <div class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white">
        <img src="/css/Airtel.png" alt=".ico" width="32" height="32">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">Ticket system</a>
    </div>

    <div class="navbar-nav flex-row">
        @auth
            <label class="text-white" for="">{{ Auth::user()->name }}</label>
        @endauth
        @guest
            <a href="{{ route('auth.login') }}">Se connecter</a>
        @endguest
    </div>
    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
        </li>
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="bi">
                    <use xlink:href="#list" />
                </svg>
            </button>
        </li>
    </ul>

    <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
    </div>
</header>
