<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class KaryawanController extends Controller
{
    // app/Http/Controllers/Admin/KaryawanController.php
    // ...
    public function dashboardAdmin() // Method baru untuk admin dashboard
    {
        // Tambahkan data yang relevan untuk dashboard admin jika ada
        $totalKaryawan = \App\Models\Karyawan::count();
        return view('admin.dashboard', compact('totalKaryawan'));
    }

    public function index()
    {
        $karyawans = Karyawan::with('user')->latest()->paginate(10);
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request) // Logika Store tetap, tapi redirect dengan pesan
    {
        // ... (validasi dan logika store yang sudah ada) ...
        DB::beginTransaction();
        try {
            // ... (pembuatan user dan karyawan) ...
            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage());
        }
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('user'); // Pastikan data user ter-load
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan) // Logika Update tetap, tapi redirect dengan pesan
    {
        // ... (validasi dan logika update yang sudah ada) ...
        DB::beginTransaction();
        try {
            // ... (update user dan karyawan) ...
            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui karyawan: ' . $e->getMessage());
        }
    }

    public function destroy(Karyawan $karyawan) // Logika Destroy tetap, tapi redirect dengan pesan
    {
        DB::beginTransaction();
        try {
            // ... (logika hapus) ...
            DB::commit();
            return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus karyawan: ' . $e->getMessage());
        }
    }
}
