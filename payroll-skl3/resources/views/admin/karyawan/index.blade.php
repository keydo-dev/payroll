@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold text-gray-800">Data Karyawan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary px-4">
            <i class="fas fa-user-plus me-2"></i> Tambah Karyawan
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Karyawan</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $karyawans->total() }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-primary text-primary">
                                    <i class="fas fa-users me-1"></i> Aktif
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-primary text-primary rounded-circle p-3">
                            <i class="fas fa-users fa-2x"></i>
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
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Karyawan Baru</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $karyawanBaru ?? 0 }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-success text-success">
                                    <i class="fas fa-calendar-alt me-1"></i> Bulan Ini
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-success text-success rounded-circle p-3">
                            <i class="fas fa-user-plus fa-2x"></i>
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
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Gaji</h6>
                            <h2 class="display-5 fw-bold mb-0">Rp {{ number_format($totalGaji ?? 0, 0, ',', '.') }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-info text-info">
                                    <i class="fas fa-money-bill-wave me-1"></i> Per Bulan
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-info text-info rounded-circle p-3">
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
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Rata-rata Masa Kerja</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $rataRataMasaKerja ?? 0 }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-warning text-warning">
                                    <i class="fas fa-business-time me-1"></i> Tahun
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-warning text-warning rounded-circle p-3">
                            <i class="fas fa-business-time fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-search me-2 text-primary"></i>Cari Karyawan
            </h5>
            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse" aria-expanded="false" aria-controls="searchCollapse">
                <i class="fas fa-sliders-h me-1"></i> Filter
            </button>
        </div>
        <div class="collapse show" id="searchCollapse">
            <div class="card-body p-4">
                <form action="{{ route('admin.karyawan.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search" class="form-label fw-semibold">Nama / Email / NIK</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" placeholder="Cari karyawan..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="posisi" class="form-label fw-semibold">Posisi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user-tie text-primary"></i>
                                </span>
                                <select name="posisi" id="posisi" class="form-select border-start-0 ps-0">
                                    <option value="">Semua Posisi</option>
                                    <option value="Manager" {{ request('posisi') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="Staff" {{ request('posisi') == 'Staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="Admin" {{ request('posisi') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sort" class="form-label fw-semibold">Urutkan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-sort text-primary"></i>
                                </span>
                                <select name="sort" id="sort" class="form-select border-start-0 ps-0">
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Tanggal Masuk (Lama-Baru)</option>
                                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Tanggal Masuk (Baru-Lama)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary">
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
                <i class="fas fa-list me-2 text-primary"></i>Daftar Karyawan
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
            @if($karyawans->isEmpty())
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" alt="No Data" style="width: 100px; opacity: 0.5">
                    <p class="text-muted mt-3">Belum ada data karyawan.</p>
                    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Tambah Karyawan
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Posisi</th>
                                <th>Tgl Masuk</th>
                                <th>Gaji Pokok</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawans as $index => $karyawan)
                            <tr>
                                <td class="ps-4">{{ $karyawans->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3 bg-primary rounded-circle text-white">
                                            {{ strtoupper(substr($karyawan->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $karyawan->user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $karyawan->user->email }}</td>
                                <td>
                                    <span class="badge bg-soft-secondary px-3 py-2">
                                        {{ $karyawan->nik }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary px-3 py-2">
                                        {{ $karyawan->posisi }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-info me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="actionDropdown{{ $karyawan->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="actionDropdown{{ $karyawan->id }}">
                                            <li>
                                                <a class="dropdown-item py-2" href="#">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2" href="{{ route('admin.karyawan.edit', $karyawan->id) }}">
                                                    <i class="fas fa-edit me-2 text-warning"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item py-2 text-danger" href="#" onclick="if(confirm('Apakah Anda yakin ingin menghapus karyawan {{ $karyawan->user->name }}?')) { document.getElementById('delete-form-{{ $karyawan->id }}').submit(); }">
                                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                                </a>
                                                <form id="delete-form-{{ $karyawan->id }}" action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </li>
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
                        Menampilkan {{ $karyawans->firstItem() }} sampai {{ $karyawans->lastItem() }} dari {{ $karyawans->total() }} karyawan
                    </div>
                    <div>
                        {{ $karyawans->links() }}
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