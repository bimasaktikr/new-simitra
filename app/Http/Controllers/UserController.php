<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Mitra; 
use App\Models\Employee; 

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $users = User::select('users.*', 'roles.role as role', DB::raw('
                    CASE
                        WHEN mitras.email IS NOT NULL THEN mitras.name
                        WHEN employees.email IS NOT NULL THEN employees.name
                        ELSE NULL
                    END as name
                '))
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->leftJoin('mitras', 'users.email', '=', 'mitras.email')
                ->leftJoin('employees', 'users.email', '=', 'employees.email')
                ->paginate($perPage);

        return view('user', [
            'user' => $this->user,
            'users' => $users
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        if ($query) {
            $users = User::select('users.*', 'roles.role as role')
                        ->join('roles', 'users.role_id', '=', 'roles.id')
                        ->where('users.email', 'LIKE', "%{$query}%")
                        ->orWhere('users.role', 'LIKE', "%{$query}%")
                        ->paginate($perPage);
        } else {
            $users = User::select('users.*', 'roles.role as role')
                     ->join('roles', 'users.role_id', '=', 'roles.id')
                     ->paginate($perPage);
        }

        return view('usertable', compact('users'));
    }

    public function edit($id)
    {
        // Mengambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Mengambil data roles untuk dropdown
        $roles = Role::all();

        // Mencari nama dari mitra atau employee berdasarkan email
        $nama = Mitra::where('email', $user->email)->value('name') 
                ?? Employee::where('email', $user->email)->value('name');

        // Mengirimkan data ke view
        return view('edituser', [
            'user' => $user,
            'roles' => $roles,
            'name' => $nama
        ]);
    }


    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'team_id' => 'required|exists:teams,id', // Validasi team_id
            'payment_type_id' => 'required|exists:payment_types,id', // Validasi payment_type_id
        ]);

        $survey = Survey::findOrFail($id);

        // Memperbarui data survei
        $survey->update([
            'name' => $request->input('name'),
            'kode' => $request->input('kode'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
            'team_id' => $request->input('team_id'),
            'payment_type_id' => $request->input('payment_type_id'), // Update payment_type_id
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil diperbarui.');
    }
}
