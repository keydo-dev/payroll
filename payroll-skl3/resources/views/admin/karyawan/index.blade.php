@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Data Karyawan</h1>
        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Karyawan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($karyawans->isEmpty())
                <p class="text-center text-muted">Belum ada data karyawan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Posisi</th>
                                <th>Tgl Masuk</th>
                                <th>Gaji Pokok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($karyawans as $index => $karyawan)
                            <tr>
                                <td>{{ $karyawans->firstItem() + $index }}</td>
                                <td>{{ $karyawan->user->name }}</td>
                                <td>{{ $karyawan->user->email }}</td>
                                <td>{{ $karyawan->nik }}</td>
                                <td>{{ $karyawan->posisi }}</td>
                                <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->isoFormat('D MMM YYYY') }}</td>
                                <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="if(confirm('Apakah Anda yakin ingin menghapus karyawan {{ $karyawan->user->name }}?')) { document.getElementById('delete-form-{{ $karyawan->id }}').submit(); }">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $karyawan->id }}" action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 @if($karyawans->hasPages())
                    <div class="mt-3">
                        {{ $karyawans->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection