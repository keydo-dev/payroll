<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel Payroll') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if(Auth::user()->isKaryawan())
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('karyawan.dashboard*') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}">Dashboard</a>
                        </li>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.karyawan.*') ? 'active' : '' }}" href="{{ route('admin.karyawan.index') }}">Kelola Karyawan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.absensi.*') ? 'active' : '' }}" href="{{ route('admin.absensi.rekap') }}">Rekap Absensi</a>
                        </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::is('admin.gaji.*') ? 'active' : '' }}" href="#" id="gajiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kelola Gaji
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="gajiDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.gaji.index') }}">Lihat Data Gaji</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.gaji.hitung.form') }}">Hitung Gaji Bulanan</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login.form'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.form') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>