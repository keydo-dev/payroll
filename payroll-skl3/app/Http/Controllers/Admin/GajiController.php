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
    // Definisikan konstanta potongan per hari tidak hadir (tanpa keterangan)
    // Ini bisa juga disimpan di config atau database setting
    const POTONGAN_PER_HARI_TIDAK_HADIR = 50000; // Contoh Rp 50.000

    public function hitungGajiBulanan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'karyawan_id' => 'nullable|exists:karyawan,id', // Opsional, jika ingin hitung untuk 1 karyawan saja
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $karyawanQuery = Karyawan::query();
        if ($request->filled('karyawan_id')) {
            $karyawanQuery->where('id', $request->karyawan_id);
        }
        $listKaryawan = $karyawanQuery->where('tanggal_masuk', '<=', Carbon::create($tahun, $bulan)->endOfMonth())->get();

        if ($listKaryawan->isEmpty()) {
            return response()->json(['message' => 'Tidak ada karyawan yang memenuhi kriteria untuk dihitung gajinya.'], 404);
        }

        $hasilPerhitungan = [];
        DB::beginTransaction();
        try {
            foreach ($listKaryawan as $karyawan) {
                // Cek apakah gaji sudah pernah dihitung untuk bulan dan tahun ini
                $gajiExisting = Gaji::where('karyawan_id', $karyawan->id)
                                    ->where('bulan', $bulan)
                                    ->where('tahun', $tahun)
                                    ->first();
                if ($gajiExisting && !$request->force_recalculate) { // Tambah param force_recalculate jika mau hitung ulang
                     $hasilPerhitungan[] = ['karyawan' => $karyawan->user->name, 'status' => 'Gaji sudah pernah dihitung.', 'data' => $gajiExisting];
                     continue;
                }


                $absensi = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereMonth('tanggal', $bulan)
                                ->whereYear('tanggal', $tahun)
                                ->get();

                $totalHadir = $absensi->where('status', 'hadir')->count();
                $totalIzin = $absensi->where('status', 'izin')->count();
                $totalSakit = $absensi->where('status', 'sakit')->count();
                $totalTanpaKeterangan = $absensi->where('status', 'tanpa keterangan')->count();

                // Perhitungan potongan berdasarkan 'tanpa keterangan'
                // Anda bisa menyesuaikan kebijakan potongan di sini
                // Misal, sakit tanpa surat dokter juga dihitung sebagai 'tanpa keterangan' atau punya rate potongan sendiri
                $potongan = $totalTanpaKeterangan * self::POTONGAN_PER_HARI_TIDAK_HADIR;

                // Jika karyawan baru masuk di pertengahan bulan, gaji bisa dihitung prorata
                // Untuk kesederhanaan, contoh ini tidak menghitung prorata, tapi bisa ditambahkan
                // $gajiPokok = $karyawan->gaji_pokok;
                // if (Carbon::parse($karyawan->tanggal_masuk)->isSameMonth(Carbon::create($tahun, $bulan), true)) {
                //      // Hitung prorata
                // }

                $gajiBersih = $karyawan->gaji_pokok - $potongan;

                $dataGaji = [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'total_hadir' => $totalHadir,
                    'total_izin' => $totalIzin,
                    'total_sakit' => $totalSakit,
                    'total_tanpa_keterangan' => $totalTanpaKeterangan,
                    'gaji_pokok_saat_itu' => $karyawan->gaji_pokok,
                    'potongan' => $potongan,
                    'gaji_bersih' => $gajiBersih,
                    'keterangan_gaji' => 'Perhitungan gaji bulan ' . $bulan . ' tahun ' . $tahun,
                    'tanggal_pembayaran' => $request->tanggal_pembayaran ?? Carbon::create($tahun, $bulan)->endOfMonth(), // Bisa diset dari request
                ];

                if ($gajiExisting) {
                    $gajiExisting->update($dataGaji);
                    $gajiRecord = $gajiExisting;
                } else {
                    $gajiRecord = $karyawan->gaji()->create($dataGaji);
                }


                $hasilPerhitungan[] = ['karyawan' => $karyawan->user->name, 'status' => 'Gaji berhasil dihitung/diperbarui.', 'data' => $gajiRecord];
            }
            DB::commit();
            return response()->json(['message' => 'Perhitungan gaji selesai.', 'results' => $hasilPerhitungan]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menghitung gaji: ' . $e->getMessage()], 500);
        }
    }

    public function lihatGaji(Request $request)
    {
         $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000|max:' . (date('Y') + 5),
            'karyawan_id' => 'nullable|exists:karyawan,id'
        ]);

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
        return response()->json($gaji);
    }

    // Untuk cetak slip gaji, controller ini akan menyiapkan data.
    // Proses pembuatan PDF/HTML biasanya di handle oleh view atau service terpisah.
    public function slipGaji(Request $request, Gaji $gaji) // Menggunakan route model binding
    {
        // Pastikan Gaji $gaji sudah di-load dengan relasi karyawan dan user jika perlu
        $gaji->load('karyawan.user');
        // Data ini kemudian bisa dikirim ke view atau service PDF generator
        return response()->json(['message' => 'Data slip gaji siap', 'data' => $gaji]);
    }
}