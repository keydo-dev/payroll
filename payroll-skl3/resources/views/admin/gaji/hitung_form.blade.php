@extends('layouts.app')

@section('title', 'Hitung Gaji Karyawan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold text-gray-800">Hitung Gaji Karyawan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gaji.index') }}">Manajemen Gaji</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hitung Gaji</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.gaji.index') }}" class="btn btn-outline-primary btn-sm px-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-calculator me-2 text-primary"></i>Form Perhitungan Gaji
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.gaji.hitung.submit') }}" method="POST">
                        @csrf
                        <div class="row g-4 mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="karyawan_id" class="form-label fw-semibold">
                                        Pilih Karyawan <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <select name="karyawan_id" id="karyawan_id" class="form-select border-start-0 ps-0" required>
                                            <option value="">-- Pilih Karyawan --</option>
                                            @foreach($karyawans as $karyawan)
                                                <option value="{{ $karyawan->id }}">
                                                    {{ $karyawan->user->name }} - {{ $karyawan->posisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bulan" class="form-label fw-semibold">
                                        Bulan <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                        </span>
                                        <select name="bulan" id="bulan" class="form-select border-start-0 ps-0" required>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ \Carbon\Carbon::now()->month == $i ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create(null, $i, 1)->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun" class="form-label fw-semibold">
                                        Tahun <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar-day text-primary"></i>
                                        </span>
                                        <select name="tahun" id="tahun" class="form-select border-start-0 ps-0" required>
                                            @for($i = \Carbon\Carbon::now()->year; $i >= \Carbon\Carbon::now()->year-2; $i--)
                                                <option value="{{ $i }}" {{ \Carbon\Carbon::now()->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keterangan_gaji" class="form-label fw-semibold">
                                        Keterangan <span class="badge bg-soft-secondary text-secondary ms-1">Opsional</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-sticky-note text-primary"></i>
                                        </span>
                                        <textarea class="form-control border-start-0 ps-0" id="keterangan_gaji" name="keterangan_gaji" rows="3" placeholder="Masukkan catatan atau keterangan tambahan terkait gaji bulanan ini..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-calculator me-2"></i> Hitung Gaji
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Informasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-soft-info border-0 mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x text-info"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading fw-bold mb-1">Catatan Penting</h6>
                                <p class="mb-0">Sistem akan menghitung gaji berdasarkan data absensi yang telah direkam pada bulan yang dipilih. Pastikan data absensi sudah lengkap dan benar sebelum menghitung gaji.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Komponen Perhitungan:</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent px-0 py-2 d-flex align-items-center border-dashed">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">1</span>
                                <span>Gaji Pokok</span>
                            </li>
                            <li class="list-group-item bg-transparent px-0 py-2 d-flex align-items-center border-dashed">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">2</span>
                                <span>Tunjangan (jika ada)</span>
                            </li>
                            <li class="list-group-item bg-transparent px-0 py-2 d-flex align-items-center border-dashed">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">3</span>
                                <span>Potongan Ketidakhadiran</span>
                            </li>
                            <li class="list-group-item bg-transparent px-0 py-2 d-flex align-items-center border-dashed">
                                <span class="badge rounded-pill bg-soft-primary text-primary me-2">4</span>
                                <span>Potongan Lainnya (jika ada)</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-outline-primary">
                            <i class="fas fa-calendar-check me-2"></i>Cek Rekap Absensi
                        </a>
                        <a href="{{ route('admin.gaji.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>Lihat Data Gaji
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your CSS or in a style tag -->
<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .bg-soft-secondary {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }
    .bg-soft-info {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
    .alert-soft-info {
        background-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }
    .border-dashed {
        border-style: dashed !important;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #86b7fe;
    }
    .input-group-text {
        color: #6c757d;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection