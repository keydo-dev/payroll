<?php
// app/Http/Middleware/KaryawanMiddleware.php
namespace App\Http\Middleware;

use Closure;
use App\Http\Models\Karyawan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class KaryawanMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isKaryawan()) {
            return $next($request);
        }
        return redirect()->route('login.form')->with('error', 'Akses tidak diizinkan. Anda harus login sebagai Karyawan.');
    }

    public function index(Request $request)
    {
        $karyawans = Karyawan::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function show(Karyawan $karyawan)
    {
        return redirect()->route('admin.karyawan.edit', $karyawan->id);
    }
}
