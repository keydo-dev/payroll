<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function rekapSemuaKaryawanView(Request $request)
    {
        $query = Absensi::with('karyawan.user:id,name');

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->orderBy('karyawan_id')->paginate(20);
        $karyawans = Karyawan::all(); // For dropdown filter

        return view('admin.absensi.rekap', compact('absensi', 'karyawans'));
    }
}
