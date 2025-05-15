<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;

class KaryawanPageController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()->route('home')->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        $hasClockedInToday = $absensiHariIni && $absensiHariIni->jam_masuk;
        $hasClockedOutToday = $absensiHariIni && $absensiHariIni->jam_pulang;

        $riwayatAbsensi = Absensi::where('karyawan_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(5); // Ambil 5 terakhir untuk dashboard

        return view('karyawan.dashboard', compact('karyawan', 'riwayatAbsensi', 'absensiHariIni', 'hasClockedInToday', 'hasClockedOutToday'));
    }

    public function clockIn(Request $request) // Tambahkan Request $request
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absensiHariIni && $absensiHariIni->jam_masuk) {
            return back()->with('warning', 'Anda sudah melakukan presensi masuk hari ini.');
        }

        if (!$absensiHariIni) {
            Absensi::create([
                'karyawan_id' => $karyawan->id,
                'tanggal' => $today,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir',
            ]);
        } else { // Jika record ada tapi jam_masuk kosong (misal dari izin yg diinput admin)
            $absensiHariIni->update([
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir',
            ]);
        }
        return back()->with('success', 'Presensi masuk berhasil direkam.');
    }

    public function clockOut(Request $request) // Tambahkan Request $request
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensiHariIni || !$absensiHariIni->jam_masuk) {
            return back()->with('error', 'Anda belum melakukan presensi masuk hari ini.');
        }

        if ($absensiHariIni->jam_pulang) {
            return back()->with('warning', 'Anda sudah melakukan presensi pulang hari ini.');
        }

        $absensiHariIni->update(['jam_pulang' => Carbon::now()->format('H:i:s')]);
        return back()->with('success', 'Presensi pulang berhasil direkam.');
    }
}
