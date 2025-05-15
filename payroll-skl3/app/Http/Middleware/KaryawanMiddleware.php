<?php

namespace App\Http\Middleware;

use Closure;
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
        return response()->json(['message' => 'Unauthorized. Karyawan access required.'], 403);
    }
}