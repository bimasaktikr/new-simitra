<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    protected $user;
    protected $mitra;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login

        // Data dummy untuk detail survei
        $this->mitras = [
            [
                'name' => 'Bagus Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bagus@gmail.com',
                'tanggal_lahir' => '1990-01-07',
            ],
            [
                'name' => 'Bagas Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bagas@gmail.com',
                'tanggal_lahir' => '1993-02-11',
            ],
            [
                'name' => 'Bugus Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bugus@gmail.com',
                'tanggal_lahir' => '1995-12-01',
            ],
            [
                'name' => 'Bigas Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Perempuan',
                'email' => 'bigas@gmail.com',
                'tanggal_lahir' => '2003-07-10',
            ],
            [
                'name' => 'Bogas Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bogas@gmail.com',
                'tanggal_lahir' => '2005-04-27',
            ],
        ];
    }

    public function index()
    {
        return view('mitra', [
            'user' => $this->user,
            'mitras' => $this->mitras
        ]); // Mengirim data ke view// Mengirim data ke view
    }

    public function add()
    {
        return view('addmitra', ['user' => $this->user]); // Mengirim data ke view
    }
    public function edit()
    {
        return view('editmitra', ['user' => $this->user]); // Mengirim data ke view
    }

    public function show($id)
    {
        $mitra = $this->mitras[$id - 1] ?? null;

        if (!$mitra) {
            return redirect()->route('mitra')->withErrors('Mitra tidak ditemukan.');
        }

        return view('mitradetail', [
            'user' => $this->user,
            'mitra' => $mitra
        ]);
    }

}

