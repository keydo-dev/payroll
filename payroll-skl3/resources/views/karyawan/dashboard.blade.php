@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Dashboard Karyawan</h4>
                </div>
                <div class="card-body">
                    <h5>Selamat datang, {{ Auth::user()->name }}!</h5>
                    <p>Ini adalah halaman dashboard Anda.</p>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Presensi Masuk</h5>
                                    <p class="card-text">Catat kehadiran Anda hari ini.</p>
                                    <form action="{{ route('karyawan.clock.in') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success" {{ $hasClockedInToday ? 'disabled' : '' }}>
                                            <i class="fas fa-sign-in-alt"></i> Clock In
                                        </button>
                                    </form>
                                    @if($hasClockedInToday && $absensiHariIni)
                                        <p class="mt-2 text-muted small">Sudah clock in pada: {{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Presensi Pulang</h5>
                                    <p class="card-text">Catat waktu pulang Anda.</p>
                                    <form action="{{ route('karyawan.clock.out') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" {{ !$hasClockedInToday || $hasClockedOutToday ? 'disabled' : '' }}>
                                            <i class="fas fa-sign-out-alt"></i> Clock Out
                                        </button>
                                    </form>
                                     @if($hasClockedOutToday && $absensiHariIni)
                                        <p class="mt-2 text-muted small">Sudah clock out pada: {{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Riwayat Absensi Pribadi (5 Terakhir)</h5>
                </div>
                <div class="card-body">
                    @if($riwayatAbsensi->isEmpty())
                        <p class="text-center text-muted">Belum ada riwayat absensi.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatAbsensi as $absen)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</td>
                                        <td>{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '-' }}</td>
                                        <td>{{ $absen->jam_pulang ? \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') : '-' }}</td>
                                        <td><span class="badge bg-{{ $absen->status == 'hadir' ? 'success' : ($absen->status == 'izin' || $absen->status == 'sakit' ? 'warning' : 'danger') }}">{{ ucfirst($absen->status) }}</span></td>
                                        <td>{{ $absen->keterangan ?: '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($riwayatAbsensi->hasPages())
                            <div class="mt-3">
                                {{ $riwayatAbsensi->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection