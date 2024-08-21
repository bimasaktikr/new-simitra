<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang login
        return view('dashboard', compact('user')); // Mengirim data ke view

        $user = Auth::user();

        return view('dashboard', compact('user'));
    }

    public function bantuan()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang login
        return view('bantuan', compact('user')); // Mengirim data ke view
    }
}
