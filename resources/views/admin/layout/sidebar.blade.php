<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Canteen Connect</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="/dashboard">
                        <svg class="bi">
                            <use xlink:href="#house-fill" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('jenis-menu') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark" />
                        </svg>
                        Jenis Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('member') }}">
                        <svg class="bi">
                            <use xlink:href="#cart" />
                        </svg>
                        Member
                    </a>
                </li>

            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                <span>Saved reports</span>
                <a class="link-secondary" href="#" aria-label="Add a new report">
                    <svg class="bi">
                        <use xlink:href="#plus-circle" />
                    </svg>
                </a>
            </h6>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tenant') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Tenant
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('menu')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('user')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('tipe-user')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Tipe User
                    </a>
                </li>
            </ul>

            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('pesanan')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Pesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi">
                            <use xlink:href="#gear-wide-connected" />
                        </svg>
                        Transaksi
                    </a>
                </li>
                <li class="nav-item">
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="nav-link d-flex align-items-center gap-2">
                            <svg class="bi">
                                <use xlink:href="#door-closed" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
