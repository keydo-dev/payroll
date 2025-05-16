<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Gaji;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    public function indexGajiView(Request $request)
    {
        $query = Gaji::with('karyawan.user:id,name');

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        $gaji = $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->orderBy('karyawan_id')->paginate(20);
        $karyawans = Karyawan::all(); // For dropdown filter

        return view('admin.gaji.index', compact('gaji', 'karyawans'));
    }

    public function showHitungForm()
    {
        $karyawans = Karyawan::with('user:id,name')->get();
        return view('admin.gaji.hitung_form', compact('karyawans'));
    }

    public function showSlipGajiView(Gaji $gaji)
    {
        $gaji->load('karyawan.user');
        return view('admin.gaji.slip', compact('gaji'));
    }
}
