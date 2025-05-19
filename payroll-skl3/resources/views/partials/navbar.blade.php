<nav class="navbar navbar-expand-md fixed-top shadow-sm navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <div class="icon-shape bg-primary text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-building"></i>
            </div>
            <span class="fw-bold">{{ config('app.name', 'Laravel Payroll') }}</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if(Auth::user()->isKaryawan())
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ Route::is('karyawan.dashboard*') ? 'active fw-semibold text-primary' : '' }}" href="{{ route('karyawan.dashboard') }}">
                                <i class="fas fa-home me-1"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ Route::is('admin.dashboard*') ? 'active fw-semibold text-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ Route::is('admin.karyawan.*') ? 'active fw-semibold text-primary' : '' }}" href="{{ route('admin.karyawan.index') }}">
                                <i class="fas fa-users me-1"></i> Karyawan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 {{ Route::is('admin.absensi.*') ? 'active fw-semibold text-primary' : '' }}" href="{{ route('admin.absensi.rekap') }}">
                                <i class="fas fa-calendar-check me-1"></i> Absensi
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3 {{ Route::is('admin.gaji.*') ? 'active fw-semibold text-primary' : '' }}" href="#" id="gajiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-money-bill-wave me-1"></i> Gaji
                            </a>
                            <ul class="dropdown-menu border-0 shadow-sm rounded-3 py-2" aria-labelledby="gajiDropdown">
                                <li><a class="dropdown-item py-2 px-4" href="{{ route('admin.gaji.index') }}">
                                    <i class="fas fa-list-ul me-2 text-primary"></i> Data Gaji
                                </a></li>
                                <li><hr class="dropdown-divider mx-3 my-1"></li>
                                <li><a class="dropdown-item py-2 px-4" href="{{ route('admin.gaji.hitung.form') }}">
                                    <i class="fas fa-calculator me-2 text-primary"></i> Hitung Gaji
                                </a></li>
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
                            <a class="nav-link btn btn-outline-primary rounded-pill px-3 mx-2" href="{{ route('login.form') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> {{ __('Login') }}
                            </a>
                        </li>
                    @endif
                @else
                    <!-- Notification Bell -->
                    <li class="nav-item me-2">
                        <a class="nav-link position-relative p-2 rounded-circle bg-soft-primary" href="#" title="Notifikasi">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                2
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        </a>
                    </li>
                    
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="avatar avatar-sm bg-primary rounded-circle text-white me-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block">
                                <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                <div class="small text-muted">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 py-2" aria-labelledby="navbarDropdown">
                            <div class="px-4 py-2 text-center border-bottom mb-2">
                                <div class="avatar avatar-lg bg-primary rounded-circle text-white mb-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                            
                            <a class="dropdown-item py-2 px-4" href="#">
                                <i class="fas fa-user me-2 text-primary"></i> Profil Saya
                            </a>
                            
                            <a class="dropdown-item py-2 px-4" href="#">
                                <i class="fas fa-cog me-2 text-primary"></i> Pengaturan
                            </a>
                            
                            <hr class="dropdown-divider mx-3 my-1">
                            
                            <a class="dropdown-item py-2 px-4 text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
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

<!-- Add this to your CSS or in a style tag -->
<style>
    body {
        padding-top: 70px; /* Adjust based on your navbar height */
    }
    
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }
    
    .avatar-lg {
        width: 64px;
        height: 64px;
        font-size: 1.5rem;
    }
    
    .dropdown-item:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .navbar .nav-link {
        position: relative;
    }
    
    .navbar .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0.75rem;
        right: 0.75rem;
        height: 3px;
        background-color: var(--bs-primary);
        border-radius: 3px 3px 0 0;
    }
    
    @media (max-width: 767.98px) {
        .navbar .nav-link.active::after {
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            opacity: 0.1;
            border-radius: 0.25rem;
        }
    }
</style>