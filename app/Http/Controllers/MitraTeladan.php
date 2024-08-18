<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraTeladan extends Controller{ 

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
                'rating' => '5.0',
                'banyak_survey'=> '13'
            ],
            [
                'name' => 'Bagas Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bagas@gmail.com',
                'tanggal_lahir' => '1993-02-11',
                'rating' => '4.93',
                'banyak_survey'=> '14'
            ],
            [
                'name' => 'Bugus Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bugus@gmail.com',
                'tanggal_lahir' => '1995-12-01',
                'rating' => '4.86',
                'banyak_survey'=> '13'
            ],
            [
                'name' => 'Bigas Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Perempuan',
                'email' => 'bigas@gmail.com',
                'tanggal_lahir' => '2003-07-10',
                'rating' => '4.7',
                'banyak_survey'=> '13'
            ],
            [
                'name' => 'Bogas Sunandar',
                'id_sobat' => '35717272',
                'jk' => 'Laki-laki',
                'email' => 'bogas@gmail.com',
                'tanggal_lahir' => '2005-04-27',
                'rating' => '4.66',
                'banyak_survey'=> '12'
            ],
        ];
    }

    public function index()
    {
        return view('mitrateladan', [
            'user' => $this->user,
            'mitras' => $this->mitras
        ]); // Mengirim data ke view// Mengirim data ke view
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


    //mul
   
}
?>

