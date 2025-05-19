@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-gray-800">Rekap Absensi Karyawan</h1>
        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#absensiModal">
            <i class="fas fa-plus me-2"></i> Tambah Absensi
        </button>
    </div>
    
    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-filter me-2 text-primary"></i>Filter Data
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.absensi.rekap') }}" method="GET" class="row g-3">
                <div class="col-md-3">
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
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($absensi->isEmpty())
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076445.png" alt="No Data" style="width: 100px; opacity: 0.5">
                    <p class="text-muted mt-3">Tidak ada data absensi yang sesuai dengan filter.</p>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#absensiModal">
                        <i class="fas fa-plus me-1"></i> Tambah Data Absensi
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensi as $index => $absen)
                            <tr>
                                <td class="ps-4">{{ $absensi->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3 bg-primary rounded-circle text-white">
                                            {{ strtoupper(substr($absen->karyawan->user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $absen->karyawan->user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    @if($absen->jam_masuk)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-sign-in-alt text-success me-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absen->jam_pulang)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-sign-out-alt text-danger me-2"></i>
                                            <span>{{ \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absen->status == 'hadir')
                                        <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i> Hadir
                                        </span>
                                    @elseif($absen->status == 'izin')
                                        <span class="badge bg-soft-info text-info px-3 py-2 rounded-pill">
                                            <i class="fas fa-info-circle me-1"></i> Izin
                                        </span>
                                    @elseif($absen->status == 'sakit')
                                        <span class="badge bg-soft-warning text-warning px-3 py-2 rounded-pill">
                                            <i class="fas fa-procedures me-1"></i> Sakit
                                        </span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger px-3 py-2 rounded-pill">
                                            <i class="fas fa-times-circle me-1"></i> Alpha
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($absen->keterangan)
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $absen->keterangan }}">
                                            {{ $absen->keterangan }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted small">
                        Menampilkan {{ $absensi->firstItem() }} sampai {{ $absensi->lastItem() }} dari {{ $absensi->total() }} data
                    </div>
                    <div>
                        {{ $absensi->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Absensi -->
<div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.absensi.manage') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="absensiModalLabel">
                        <i class="fas fa-clipboard-check me-2"></i>Tambah/Edit Data Absensi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="karyawan_id_modal" class="form-label fw-semibold">
                            Karyawan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user text-primary"></i>
                            </span>
                            <select name="karyawan_id" id="karyawan_id_modal" class="form-select border-start-0 ps-0" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}">{{ $karyawan->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold">
                            Tanggal <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="date" class="form-control border-start-0 ps-0" id="tanggal" name="tanggal" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jam_masuk" class="form-label fw-semibold">
                                Jam Masuk
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-clock text-primary"></i>
                                </span>
                                <input type="time" class="form-control border-start-0 ps-0" id="jam_masuk" name="jam_masuk">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="jam_pulang" class="form-label fw-semibold">
                                Jam Pulang
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-clock text-primary"></i>
                                </span>
                                <input type="time" class="form-control border-start-0 ps-0" id="jam_pulang" name="jam_pulang">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-tag text-primary"></i>
                            </span>
                            <select name="status" id="status" class="form-select border-start-0 ps-0" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="tanpa keterangan">Tanpa Keterangan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">
                            Keterangan
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-sticky-note text-primary"></i>
                            </span>
                            <textarea class="form-control border-start-0 ps-0" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan jika diperlukan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
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
        border-radius: 0.5rem;
    }
    .pagination {
        margin-bottom: 0;
    }
    .modal-content {
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>
@endsection