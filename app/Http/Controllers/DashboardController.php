<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userData = session('user_data');
        return view('dashboard', compact('userData'));
    }

    public function bantuan()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang login
        return view('bantuan', compact('user')); // Mengirim data ke view
    }
}
