@extends('layouts.app')

@section('title', 'Data Gaji Karyawan')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold text-gray-800">Data Gaji Karyawan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Gaji</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.gaji.hitung.form') }}" class="btn btn-primary px-4">
            <i class="fas fa-calculator me-2"></i> Hitung Gaji Baru
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Penggajian</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $gaji->total() }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-primary text-primary">
                                    <i class="fas fa-file-invoice-dollar me-1"></i> Slip Gaji
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-primary text-primary rounded-circle p-3">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Bulan Ini</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $bulanIni ?? 0 }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-success text-success">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::now()->isoFormat('MMMM Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-success text-success rounded-circle p-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Karyawan</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ count($karyawans) }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-info text-info">
                                    <i class="fas fa-users me-1"></i> Aktif
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-info text-info rounded-circle p-3">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Pengeluaran</h6>
                            <h2 class="display-5 fw-bold mb-0">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-warning text-warning">
                                    <i class="fas fa-chart-line me-1"></i> Tahun {{ \Carbon\Carbon::now()->year }}
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-warning text-warning rounded-circle p-3">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-filter me-2 text-primary"></i>Filter Data
            </h5>
            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                <i class="fas fa-sliders-h me-1"></i> Tampilkan Filter
            </button>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body p-4">
                <form action="{{ route('admin.gaji.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="karyawan_id" class="form-label fw-semibold">Karyawan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <select name="karyawan_id" id="karyawan_id" class="form-select border-start-0 ps-0">
                                    <option value="">-- Semua Karyawan --</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id }}" {{ request('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                            {{ $karyawan->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bulan" class="form-label fw-semibold">Bulan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </span>
                                <select name="bulan" id="bulan" class="form-select border-start-0 ps-0">
                                    <option value="">-- Semua Bulan --</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create(null, $i, 1)->isoFormat('MMMM') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tahun" class="form-label fw-semibold">Tahun</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-calendar-day text-primary"></i>
                                </span>
                                <select name="tahun" id="tahun" class="form-select border-start-0 ps-0">
                                    <option value="">-- Semua Tahun --</option>
                                    @for($i = \Carbon\Carbon::now()->year; $i >= \Carbon\Carbon::now()->year-5; $i--)
                                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.gaji.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-primary"></i>Daftar Gaji
            </h5>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-1"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="exportDropdown">
                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-file-excel me-2 text-success"></i>Excel</a></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF</a></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="fas fa-print me-2 text-primary"></i>Print</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
            @if($gaji->isEmpty())
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No Data" style="width: 100px; opacity: 0.5">
                    <p class="text-muted mt-3">Tidak ada data gaji yang sesuai dengan filter.</p>
                    <a href="{{ route('admin.gaji.hitung.form') }}" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Hitung Gaji Baru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Karyawan</th>
                                <th>Periode</th>
                                <th>Gaji Pokok</th>
                                <th>Potongan</th>
                                <th>Gaji Bersih</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gaji as $index => $g)
                            <tr>
                                <td class="ps-4">{{ $gaji->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3 bg-primary rounded-circle text-white">
                                            {{ strtoupper(substr($g->karyawan->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $g->karyawan->user->name }}</h6>
                                            <small class="text-muted">{{ $g->karyawan->posisi }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-info text-info px-3 py-2 rounded-pill">
                                        {{ \Carbon\Carbon::create(null, $g->bulan, 1)->isoFormat('MMMM') }} {{ $g->tahun }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold">Rp {{ number_format($g->gaji_pokok_saat_itu, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <div class="text-danger">- Rp {{ number_format($g->potongan, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">Rp {{ number_format($g->gaji_bersih, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    @if($g->tanggal_pembayaran)
                                        <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i> Dibayar
                                        </span>
                                    @else
                                        <span class="badge bg-soft-warning text-warning px-3 py-2 rounded-pill">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="actionDropdown{{ $g->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="actionDropdown{{ $g->id }}">
                                            <li>
                                                <a class="dropdown-item py-2" href="{{ route('admin.gaji.slip', $g->id) }}">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Lihat Slip
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2" href="#">
                                                    <i class="fas fa-print me-2 text-info"></i>Cetak Slip
                                                </a>
                                            </li>
                                            @if(!$g->tanggal_pembayaran)
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item py-2" href="#">
                                                        <i class="fas fa-check-circle me-2 text-success"></i>Tandai Dibayar
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted small">
                        Menampilkan {{ $gaji->firstItem() }} sampai {{ $gaji->lastItem() }} dari {{ $gaji->total() }} data
                    </div>
                    <div>
                        {{ $gaji->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add this to your CSS or in a style tag -->
<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .bg-soft-success {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }
    .bg-soft-info {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
    .bg-soft-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    .bg-soft-danger {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    .bg-soft-secondary {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }
    .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        vertical-align: middle;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .avatar {
        width: 36px;
        height: 36px;
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
    .pagination {
        margin-bottom: 0;
    }
    .dropdown-item:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }
    .table > :not(:first-child) {
        border-top: none;
    }
</style>
@endsection