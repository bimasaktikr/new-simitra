<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use App\Models\User;
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

    public function show($id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        return view('mitradetail', [
            'user' => $this->user,
            'mitra' => $mitra
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_sobat' => 'required|string|max:255|unique:mitras',
            'jk' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'pendidikan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Buat user baru
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->id_sobat), 
                'role_id' => 4,
            ]);

            // Simpan data mitra
            $mitra = Mitra::create([
                'name' => $request->nama,
                'id_sobat' => $request->id_sobat,
                'jenis_kelamin' => $request->jk,
                'email' => $user->email,  // Pastikan email dimasukkan
                'pendidikan' => $request->pendidikan,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();
            return redirect()->route('mitra')->with('success', 'Mitra berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            \Log::error('Error saat menambahkan mitra: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan mitra. Silakan coba lagi.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        $mitras = Mitra::query();

        if ($query) {
            $mitras = $mitras->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('id_sobat', 'LIKE', "%{$query}%");
        }
        $mitras = $mitras->paginate($perPage);

        return view('mitratable', compact('mitras'))->render();
    }

    public function destroy($id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        $mitra->delete();

        return redirect()->route('mitra')->with('success', 'Mitra berhasil dihapus.');
    }
}

