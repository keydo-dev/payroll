@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="container">
    <h1>Tambah Karyawan Baru</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.karyawan.store') }}" method="POST">
                @include('admin.karyawan._form')
            </form>
        </div>
    </div>
</div>
@endsection