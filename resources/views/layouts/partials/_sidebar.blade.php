<div class="container-fluid">
    <div class="row">
        <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
            <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
                aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarMenuLabel">Afrotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page"
                                href="{{ route('dashboard') }}">
                                <svg class="bi">
                                    <use xlink:href="#house-fill" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tickets.list') }}">
                                <svg class="bi">
                                    <use xlink:href="#list" />
                                </svg>
                                Tickets List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tickets.create') }}">
                                <svg class="bi">
                                    <use xlink:href="#plus-circle" />
                                </svg>
                                New ticket
                            </a>
                        </li>
                        @if (Auth::user()->role == 'Admin')
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2"
                                    href="{{ route('users.userlist') }}">
                                    <svg class="bi">
                                        <use xlink:href="#people" />
                                    </svg>
                                    Users list
                                </a>
                            </li>
                        @endif
                    </ul>

                    <hr class="my-3">

                    <ul class="nav flex-column mb-auto">
                      @if (Auth::user()->role == 'Admin')
                      <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="#">
                            <svg class="bi">
                                <use xlink:href="#gear-wide-connected" />
                            </svg>
                            Settings
                        </a>
                      </li>
                      @endif
                        
                        <li class="nav-item">
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                @method('delete') <!-- Utiliser la méthode DELETE -->
                                <button type="submit" class="nav-link d-flex align-items-center gap-2">
                                    <svg class="bi">
                                        <use xlink:href="#door-closed" />
                                    </svg>
                                    Log out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
