<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang login
        return view('penilaian', compact('user')); // Mengirim data ke view
    }

}