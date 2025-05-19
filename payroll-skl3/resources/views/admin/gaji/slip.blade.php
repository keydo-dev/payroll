@extends('layouts.app')

@section('title', 'Slip Gaji Karyawan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold text-gray-800">Slip Gaji Karyawan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gaji.index') }}">Data Gaji</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Slip Gaji</li>
                </ol>
            </nav>
        </div>
        <div class="d-print-none">
            <a href="{{ route('admin.gaji.index') }}" class="btn btn-outline-secondary px-3">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary px-3 ms-2">
                <i class="fas fa-print me-2"></i> Cetak
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <h4 class="fw-bold mb-0">{{ config('app.name', 'Laravel Payroll') }}</h4>
                    </div>
                    <div class="ps-2 border-start border-3 border-primary">
                        <p class="mb-1 text-muted"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Jl. Contoh No. 123</p>
                        <p class="mb-1 text-muted"><i class="fas fa-city me-2 text-primary"></i>Jakarta, Indonesia</p>
                        <p class="mb-1 text-muted"><i class="fas fa-envelope me-2 text-primary"></i>contact@example.com</p>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="bg-soft-primary p-3 rounded-3 text-end">
                        <h4 class="fw-bold text-primary mb-2">SLIP GAJI</h4>
                        <p class="mb-1"><span class="text-muted">Periode:</span> <strong>{{ \Carbon\Carbon::create(null, $gaji->bulan, 1)->isoFormat('MMMM') }} {{ $gaji->tahun }}</strong></p>
                        <p class="mb-1"><span class="text-muted">ID Slip:</span> <strong>#{{ $gaji->id }}</strong></p>
                        <p class="mb-0"><span class="text-muted">Tanggal Pembayaran:</span> <strong>{{ \Carbon\Carbon::parse($gaji->tanggal_pembayaran)->isoFormat('D MMMM YYYY') }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Employee Information -->
                <div class="col-md-6">
                    <div class="card border-0 bg-soft-info h-100">
                        <div class="card-body p-3">
                            <h5 class="fw-bold text-info mb-3">
                                <i class="fas fa-user-tie me-2"></i>Informasi Karyawan
                            </h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-info rounded-circle text-white me-3">
                                    {{ strtoupper(substr($gaji->karyawan->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">{{ $gaji->karyawan->user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $gaji->karyawan->posisi }}</p>
                                </div>
                            </div>
                            <div class="ps-2 border-start border-2 border-info">
                                <p class="mb-2"><span class="text-muted">NIK:</span> <strong>{{ $gaji->karyawan->nik }}</strong></p>
                                <p class="mb-0"><span class="text-muted">Tanggal Masuk:</span> <strong>{{ \Carbon\Carbon::parse($gaji->karyawan->tanggal_masuk)->isoFormat('D MMMM YYYY') }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Attendance Summary -->
                <div class="col-md-6">
                    <div class="card border-0 bg-soft-success h-100">
                        <div class="card-body p-3">
                            <h5 class="fw-bold text-success mb-3">
                                <i class="fas fa-calendar-check me-2"></i>Rekap Kehadiran
                            </h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-success text-white rounded-circle p-2 me-2">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 small">Hadir</p>
                                            <h5 class="fw-bold mb-0">{{ $gaji->total_hadir }} hari</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-info text-white rounded-circle p-2 me-2">
                                            <i class="fas fa-file-medical"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 small">Izin</p>
                                            <h5 class="fw-bold mb-0">{{ $gaji->total_izin }} hari</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-warning text-white rounded-circle p-2 me-2">
                                            <i class="fas fa-procedures"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 small">Sakit</p>
                                            <h5 class="fw-bold mb-0">{{ $gaji->total_sakit }} hari</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-danger text-white rounded-circle p-2 me-2">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 small">Alpha</p>
                                            <h5 class="fw-bold mb-0">{{ $gaji->total_tanpa_keterangan }} hari</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-money-bill-wave me-2 text-primary"></i>Rincian Gaji
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Deskripsi</th>
                                    <th class="text-end pe-4">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape bg-soft-primary text-primary rounded-circle p-2 me-3">
                                                <i class="fas fa-money-bill"></i>
                                            </div>
                                            <span>Gaji Pokok</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 fw-semibold">Rp {{ number_format($gaji->gaji_pokok_saat_itu, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape bg-soft-danger text-danger rounded-circle p-2 me-3">
                                                <i class="fas fa-minus-circle"></i>
                                            </div>
                                            <span>Potongan ({{ $gaji->total_tanpa_keterangan }} hari tanpa keterangan)</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 fw-semibold text-danger">- Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="bg-soft-primary">
                                    <td class="ps-4 fw-bold">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape bg-primary text-white rounded-circle p-2 me-3">
                                                <i class="fas fa-coins"></i>
                                            </div>
                                            <span>Total Gaji Bersih</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 fw-bold fs-5 text-primary">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($gaji->keterangan_gaji)
                <div class="card border-0 bg-soft-secondary mb-4">
                    <div class="card-body p-3">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-sticky-note me-2 text-secondary"></i>Keterangan
                        </h5>
                        <p class="mb-0">{{ $gaji->keterangan_gaji }}</p>
                    </div>
                </div>
            @endif

            <!-- Signatures -->
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-3 text-center">
                            <p class="text-muted mb-3">Diterima oleh,</p>
                            <div class="border-bottom border-dashed my-4" style="height: 40px;"></div>
                            <p class="fw-bold mb-0">{{ $gaji->karyawan->user->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-3 text-center">
                            <p class="text-muted mb-3">Disetujui oleh,</p>
                            <div class="border-bottom border-dashed my-4" style="height: 40px;"></div>
                            <p class="fw-bold mb-0">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 text-muted small d-print-none">
                <p class="mb-0">Slip gaji ini dihasilkan secara digital oleh {{ config('app.name', 'Laravel Payroll') }}</p>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .avatar-lg {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }
    .border-dashed {
        border-style: dashed !important;
    }
    
    @media print {
        @page {
            size: auto;
            margin: 10mm;
        }
        body {
            margin: 0;
            padding: 0;
        }
        .d-print-none {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .bg-soft-primary, .bg-soft-success, .bg-soft-info, 
        .bg-soft-warning, .bg-soft-danger, .bg-soft-secondary, .bg-light {
            background-color: transparent !important;
            border: 1px solid #dee2e6 !important;
        }
        .table {
            border-color: #dee2e6 !important;
        }
    }
</style>
@endsection