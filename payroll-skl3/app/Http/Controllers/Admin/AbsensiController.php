<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function rekapSemuaKaryawan(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000|max:' . (date('Y') + 5),
            'karyawan_id' => 'nullable|exists:karyawan,id'
        ]);

        $query = Absensi::with('karyawan.user:id,name'); // Hanya ambil id dan name dari user

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
        return response()->json($absensi);
    }

    // Opsional: Tambah/Edit Absensi Manual oleh Admin
    public function createOrUpdateAbsensi(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date_format:Y-m-d',
            'jam_masuk' => 'nullable|date_format:H:i:s',
            'jam_pulang' => 'nullable|date_format:H:i:s',
            'status' => 'required|in:hadir,izin,sakit,tanpa keterangan',
            'keterangan' => 'nullable|string',
        ]);

        if ($validated['status'] !== 'hadir') {
            $validated['jam_masuk'] = null;
            $validated['jam_pulang'] = null;
        } else {
            if (empty($validated['jam_masuk'])) {
                return response()->json(['message' => 'Jam masuk wajib diisi jika status hadir'], 422);
            }
        }


        $absensi = Absensi::updateOrCreate(
            [
                'karyawan_id' => $validated['karyawan_id'],
                'tanggal' => $validated['tanggal']
            ],
            $validated
        );

        return response()->json(['message' => 'Data absensi berhasil disimpan.', 'data' => $absensi], 200);
    }
}