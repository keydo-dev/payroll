@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login.submit') }}"> <!-- PERBAIKAN DI SINI -->
    @csrf
    <img class="mb-4" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Silakan Login</h1>

    <div class="form-floating mb-3">
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
        <label for="email">Alamat Email</label>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-floating">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
        <label for="password">Password</label>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Login</button>
    <p class="mt-5 mb-3 text-muted">© {{ date('Y') }}</p>
</form>
@endsection