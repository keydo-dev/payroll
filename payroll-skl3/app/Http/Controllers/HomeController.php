<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->isKaryawan()) {
                return redirect()->route('karyawan.dashboard');
            }
        }
        return view('welcome'); // Atau redirect ke login: return redirect()->route('login.form');
    }
}