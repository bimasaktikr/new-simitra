<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use App\Models\Team;
use App\Models\User;
use App\Models\Employee;

class PegawaiController extends Controller
{
    protected $user;
    protected $employee;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $employees = Employee::paginate($perPage);
        
        // Mengirim data survei ke view
        return view('pegawai', [
            'user' => $this->user,
            'employees' => $employees]);
    }

    public function add()
    {
        $teams = Team::all();

        return view('addpegawai', [
            'user' => $this->user,
            'teams' => $teams
        ]);
    }

    public function edit()
    {
        return view('editpegawai', ['user' => $this->user]); // Mengirim data ke view
    }

    public function show($id)
    {
        $employee = Employee::select('employees.*', 'teams.name as team_name', 'teams.code as team_code')
                    ->join('teams', 'employees.team_id', '=', 'teams.id')
                    ->where('employees.id', $id)
                    ->first();

        if (!$employee) {
            return redirect()->route('pegawai')->with('error', 'Pegawai tidak ditemukan');
        }

        return view('pegawaidetail', [
            'user' => $this->user,
            'employee' => $employee
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:employees',
            'jk' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'tanggal_lahir' => 'required|date',
            'fungsi' => 'required|exists:teams,id',
            'peran' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $role_id = $request->peran === 'Ketua tim' ? 2 : 3;

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->nip), 
                'role_id' => $role_id,
            ]);

            $employee = Employee::create([
                'name' => $request->nama,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jk,
                'email' => $user->email, 
                'tanggal_lahir' => $request->tanggal_lahir,
                'team_id' => $request->fungsi,
                'peran' => $request->peran,
            ]);

            DB::commit();
            return redirect()->route('pegawai')->with('success', 'Pegawai berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            \Log::error('Error saat menambahkan pegawai: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan pegawai. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()->route('pegawai')->with('success', 'Pegawai berhasil dihapus.');
    }
}

