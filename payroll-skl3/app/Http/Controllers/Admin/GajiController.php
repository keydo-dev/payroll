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

    public function hitungGajiBulanan(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:2100',
        ]);

        DB::beginTransaction();
        try {
            $karyawan = Karyawan::findOrFail($request->karyawan_id);
            
            // Periksa apakah data gaji sudah ada untuk bulan/tahun ini
            $existingGaji = Gaji::where('karyawan_id', $karyawan->id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->first();
                
            if ($existingGaji) {
                return back()->with('warning', 'Gaji untuk karyawan ini pada bulan dan tahun tersebut sudah dihitung.');
            }
            
            // Hitung statistik kehadiran untuk bulan tersebut
            $startDate = Carbon::createFromDate($request->tahun, $request->bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($request->tahun, $request->bulan, 1)->endOfMonth();
            
            $absensiData = Absensi::where('karyawan_id', $karyawan->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get();
                
            $totalHadir = $absensiData->where('status', 'hadir')->count();
            $totalIzin = $absensiData->where('status', 'izin')->count();
            $totalSakit = $absensiData->where('status', 'sakit')->count();
            $totalTanpaKeterangan = $absensiData->where('status', 'tanpa keterangan')->count();
            
            // Hitung potongan berdasarkan ketidakhadiran
            $potongan = $totalTanpaKeterangan * ($karyawan->gaji_pokok / 22); // Asumsi 22 hari kerja
            
            // Hitung gaji bersih
            $gajiBersih = $karyawan->gaji_pokok - $potongan;
            
            // Buat catatan gaji
            $gaji = Gaji::create([
                'karyawan_id' => $karyawan->id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'total_hadir' => $totalHadir,
                'total_izin' => $totalIzin,
                'total_sakit' => $totalSakit,
                'total_tanpa_keterangan' => $totalTanpaKeterangan,
                'gaji_pokok_saat_itu' => $karyawan->gaji_pokok,
                'potongan' => $potongan,
                'gaji_bersih' => $gajiBersih,
                'keterangan_gaji' => $request->keterangan_gaji,
                'tanggal_pembayaran' => now(),
            ]);
            
            DB::commit();
            return redirect()->route('admin.gaji.slip', $gaji->id)->with('success', 'Gaji berhasil dihitung.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghitung gaji: ' . $e->getMessage());
        }
    }
}
