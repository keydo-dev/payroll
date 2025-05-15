@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container">
    <h1>Edit Data Karyawan: {{ $karyawan->user->name }}</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
                @method('PUT')
                @include('admin.karyawan._form', ['karyawan' => $karyawan])
            </form>
        </div>
    </div>
</div>
@endsection