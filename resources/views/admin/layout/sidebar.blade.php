<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header  bg-dark text-white">
            <img class="me-2" src="{{URL::asset('logo/logo-sm.png')}}" alt="Canteen Connect" style="height: 30px;">
            Canteen Connect
            <button type="button" class="btn-close btn-sm bg-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="/dashboard">
                        <svg class="bi">
                            <use xlink:href="#house-fill" />
                        </svg>
                        Beranda
                    </a>
                </li>
                @if(auth()->user()->id_type_user === "mbr" || auth()->user()->id_type_user === "adm")
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('profil') }}">
                        <svg class="bi">
                            <use xlink:href="#people" />
                        </svg>
                        Profil
                    </a>
                </li>
                @endif
                @if(auth()->user()->id_type_user === "tnt")
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tenant.edit',auth()->user()->id_user) }}">
                        <svg class="bi">
                            <use xlink:href="#people" />
                        </svg>
                        Profil
                    </a>
                </li>
                @endif
                @if(auth()->user()->id_type_user === "adm")
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('jenis-menu') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark" />
                        </svg>
                        Jenis Menu
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('user')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('tipe-user')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Tipe Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('member') }}">
                        <svg class="bi">
                            <use xlink:href="#people" />
                        </svg>
                        Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('kelas') }}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Kelas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tenant') }}">
                        <svg class="bi">
                            <use xlink:href="#people" />
                        </svg>
                        Tenant
                    </a>
                </li>
                @endif



                @if(auth()->user()->id_type_user === "adm" || auth()->user()->id_type_user === "tnt")
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('menu')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        Menu
                    </a>
                </li>
                @endif

            </ul>



            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                @if(auth()->user()->id_type_user === "adm" || auth()->user()->id_type_user === "mbr")
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('pesanan')}}">
                        <svg class="bi">
                            <use xlink:href="#cart" />
                        </svg>
                        Pesanan
                    </a>
                </li>
                @endif
                @if(auth()->user()->id_type_user === "adm" || auth()->user()->id_type_user === "tnt" || auth()->user()->id_type_user === "mbr")

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('pesanan.bayar')}}">
                        <svg class="bi">
                            <use xlink:href="#file-earmark-text" />
                        </svg>
                        @if(auth()->user()->id_type_user === "mbr")
                        Riwayat Pesanan
                        @else
                        Transaksi
                        @endif

                    </a>
                </li>
                <li class="nav-item">
                    @csrf
                    <a class="nav-link d-flex align-items-center gap-2" href="{{route('logout')}}">
                        <svg class="bi">
                            <use xlink:href="#door-closed" />
                        </svg>
                        Keluar
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
