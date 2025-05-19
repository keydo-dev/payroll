@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Employees Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Karyawan</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $totalKaryawan }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-primary text-primary">
                                    <i class="fas fa-arrow-up me-1"></i> 12% bulan ini
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-primary text-primary rounded-circle p-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-3">
                    <a href="{{ route('admin.karyawan.index') }}" class="d-flex align-items-center fw-semibold text-primary text-decoration-none">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Today's Attendance Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Absensi Hari Ini</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ $totalAbsensiToday }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-soft-success text-success">
                                    <i class="fas fa-check me-1"></i> {{ round(($totalAbsensiToday / $totalKaryawan) * 100) }}% hadir
                                </span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-success text-success rounded-circle p-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-3">
                    <a href="{{ route('admin.absensi.rekap') }}" class="d-flex align-items-center fw-semibold text-success text-decoration-none">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Salary Management Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Manajemen Gaji</h6>
                            <h2 class="display-5 fw-bold mb-0">
                                <i class="fas fa-money-bill-wave me-2 text-info"></i>
                            </h2>
                            <div class="mt-2">
                                <span class="text-muted">Kelola penggajian karyawan</span>
                            </div>
                        </div>
                        <div class="icon-shape bg-soft-info text-info rounded-circle p-3">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-3">
                    <a href="{{ route('admin.gaji.index') }}" class="d-flex align-items-center fw-semibold text-info text-decoration-none">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Employees Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-gray-800">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Karyawan Terbaru
                    </h5>
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-users me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($karyawanTerbaru->isEmpty())
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" alt="No Data" style="width: 100px; opacity: 0.5">
                            <p class="text-muted mt-3">Belum ada data karyawan.</p>
                            <a href="{{ route('admin.karyawan.create') }}" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-plus me-1"></i> Tambah Karyawan
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Posisi</th>
                                        <th class="border-0">Tanggal Masuk</th>
                                        <th class="border-0 text-center">Status</th>
                                        <th class="border-0 text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($karyawanTerbaru as $karyawan)
                                    <tr>
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
                                            <span class="badge bg-soft-secondary">{{ $karyawan->posisi }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('D MMM YYYY') }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill">
                                                <i class="fas fa-circle me-1 small"></i> Aktif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('admin.karyawan.show', $karyawan->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
    .bg-soft-success {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }
    .bg-soft-info {
        background-color: rgba(13, 202, 240, 0.1) !important;
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
</style>
@endsection