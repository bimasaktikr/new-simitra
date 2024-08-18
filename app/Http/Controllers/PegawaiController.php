<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    protected $user;
    protected $employee;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login

        // Data dummy untuk detail survei
        $this->employees = [
            [
                'name' => 'Putri Lestari',
                'nip' => '123123123',
                'jk' => 'Perempuan',
                'email' => 'putriles@gmail.com',
                'tanggal_lahir' => '2000-01-11',
                'fungsi' => 'produksi',
                'peran' => 'anggota',
            ],
            [
                'name' => 'Rissa Erviana',
                'nip' => '123123124',
                'jk' => 'Perempuan',
                'email' => 'rissaer@gmail.com',
                'tanggal_lahir' => '1998-02-25',
                'fungsi' => 'ipds',
                'peran' => 'anggota',
            ],
            [
                'name' => 'Elvina Gamayanti',
                'nip' => '123123125',
                'jk' => 'Perempuan',
                'email' => 'pina@gmail.com',
                'tanggal_lahir' => '2004-07-22',
                'fungsi' => 'sosial',
                'peran' => 'anggota',
            ],
            [
                'name' => 'Nur Zaman',
                'nip' => '123123126',
                'jk' => 'Perempuan',
                'email' => 'nurzmn@gmail.com',
                'tanggal_lahir' => '1967-01-17',
                'fungsi' => 'nerwilis',
                'peran' => 'ketua',
            ],
            [
                'name' => 'Bintang Purnama',
                'nip' => '123123127',
                'jk' => 'Perempuan',
                'email' => 'bintgpur@gmail.com',
                'tanggal_lahir' => '1977-11-04',
                'fungsi' => 'distribusi',
                'peran' => 'anggota',
            ]
        ];
    }
    public function index()
    {
        return view('pegawai', [
            'user' => $this->user,
            'employees' => $this->employees
        ]); // Mengirim data ke view// Mengirim data ke view
    }

    public function add()
    {
        return view('addpegawai', ['user' => $this->user]); // Mengirim data ke view
    }

    public function edit()
    {
        return view('editpegawai', ['user' => $this->user]); // Mengirim data ke view
    }

    public function show($id)
    {
        $employee = $this->employees[$id - 1] ?? null;

        return view('pegawaidetail', [
            'user' => $this->user,
            'employee' => $employee
        ]);
    }
}

