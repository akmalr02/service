<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ Auth::check() && Auth::user()->role === 'admin' 
                ? route('homeAdmin') 
                : (Auth::user()->role === 'teknisi' ? route('progres.index') 
                : (Auth::user()->role === 'user' ? route('homeAuth') : route('login'))) }}">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="250" height="70" class="d-inline-block align-text-top">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{url('user') }}">Pengelola User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{url('tugas') }}">Pengelola Tiket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('absensi') ? 'active' : '' }}" href="{{url('absensi') }}">Absen Teknisi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('tickets') ? 'active' : '' }}" href="{{url('tickets') }}">Status Pembayaran</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Request::is('laporan*') ? 'active' : '' }}" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">Laporan</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ Request::is('laporan') ? 'active' : '' }}" href="{{url('laporan') }}">Semua Laporan</a></li>
                                <li>
                                    <a class="dropdown-item {{ Request::is('laporan/selesai') ? 'active' : '' }}" 
                                       href="{{ url('laporan/selesai') }}">
                                       Selesai
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ Request::is('laporan/penambahan') ? 'active' : '' }}" href="{{url('laporan/penambahan') }}">Penambahan</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->role === 'teknisi')
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ Request::is('tasks') ? 'active' : '' }}" href="{{url('progres') }}">Tugas Saya</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('/laporan/byTeknisi') ? 'active' : '' }}" href="{{url('/laporan/byTeknisi') }}">laporan saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('/absensi/create') ? 'active' : '' }}" href="{{url('/absensi/create') }}">absen</a>
                        </li>
                    @elseif(Auth::user()->role === 'user')
                        {{-- Tambahkan menu jika diperlukan --}}
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{url('login') }}">Login</a>
                    </li>
                @endauth
            </ul>

            <!-- Right-Aligned Menu -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ url('logout') }}">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Request::is('login') ? 'active' : '' }}" href="{{ url('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
