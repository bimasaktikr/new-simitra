<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mitra;

class MitraController extends Controller
{
    protected $user;
    protected $mitra;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $mitras = Mitra::paginate($perPage);
        
        // Mengirim data survei ke view
        return view('mitra', [
            'user' => $this->user,
            'mitras' => $mitras]);
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

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);

        $mitra->delete();

        return redirect()->route('mitra')->with('success', 'Mitra berhasil dihapus.');
    }

}

