<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Payroll') }} - @yield('title')</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Font Awesome (opsional, untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom App CSS (jika ada) -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        body { padding-top: 56px; /* Tinggi navbar fixed-top */ }
        .table-responsive-sm { overflow-x: auto; } /* Perbaikan untuk tabel di mobile */
    </style>
</head>
<body>
    <div id="app">
        @include('partials.navbar')

        <main class="py-4 container">
            @include('partials._alerts')
            @yield('content')
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright © {{ config('app.name', 'Laravel Payroll') }} {{ date('Y') }}</div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap Bundle JS (Popper.js and Bootstrap JS) CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Custom App JS (jika ada) -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    @stack('scripts')
</body>
</html>