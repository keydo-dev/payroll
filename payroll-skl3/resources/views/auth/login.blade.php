@extends('layouts.auth')

@section('content')
<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="icon-shape bg-primary text-white rounded-circle p-3 mx-auto mb-3" style="width: 70px; height: 70px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-lock fa-2x"></i>
            </div>
            <h1 class="h3 fw-bold text-gray-800">Selamat Datang</h1>
            <p class="text-muted">Silakan login untuk melanjutkan</p>
        </div>
        
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">Alamat Email</label>
                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                    <span class="input-group-text bg-light border-end-0 text-primary">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                        id="email" name="email" placeholder="Masukkan alamat email" 
                        value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <a href="#" class="text-decoration-none small text-primary">Lupa password?</a>
                </div>
                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                    <span class="input-group-text bg-light border-end-0 text-primary">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                        id="password" name="password" placeholder="Masukkan password" required>
                    <button class="btn btn-light border-start-0" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>
            
            <div class="d-grid">
                <button class="btn btn-primary py-2 fw-semibold rounded-3 shadow-sm" type="submit">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted mb-0">© {{ date('Y') }} {{ config('app.name', 'Laravel Payroll') }}</p>
            </div>
        </form>
    </div>
</div>

<style>
    /* Custom Styles */
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #4e73df;
    }
    
    .input-group-text {
        color: #4e73df;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    
    .text-primary {
        color: #4e73df !important;
    }
    
    a {
        color: #4e73df;
        transition: all 0.2s ease;
    }
    
    a:hover {
        color: #2e59d9;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection