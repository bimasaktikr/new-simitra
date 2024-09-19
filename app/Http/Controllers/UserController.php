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
        $status = $request->input('status', 'semua'); // Default ke 'semua'

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
                    ->when($status !== 'semua', function ($query) use ($status) {
                        if ($status === 'aktif') {
                            $query->where('users.status', 'Aktif');
                        } elseif ($status === 'tidak aktif') {
                            $query->where('users.status', 'Tidak Aktif');
                        }
                    })
                    ->paginate($perPage);

        return view('user.index', [
            'user' => $this->user,
            'users' => $users,
            'status' => $status
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        $users = User::select('users.*')
                    ->leftJoin('mitras', 'users.email', '=', 'mitras.email')
                    ->leftJoin('employees', 'users.email', '=', 'employees.email')
                    ->when($query, function($q) use ($query) {
                        $q->where('users.email', 'LIKE', "%{$query}%")
                        ->orWhere('mitras.name', 'LIKE', "%{$query}%")
                        ->orWhere('employees.name', 'LIKE', "%{$query}%");
                    })
                    ->paginate($perPage);

        return view('user.table', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();

        $nama = Mitra::where('email', $user->email)->value('name') 
                ?? Employee::where('email', $user->email)->value('name');

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'name' => $nama
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|exists:roles,id',
            'status' => 'required|string|max:255', 
        ]);
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);

            $user->update([
                'role_id' => $request->input('role'),
                'status' => $request->input('status'),
            ]);

            $mitra = Mitra::where('email', $user->email)->first();
            $employee = Employee::where('email', $user->email)->first();

            if ($mitra) {
                $mitra->update([
                    'name' => $request->input('nama'),
                ]);
            } elseif ($employee) {
                $employee->update([
                    'name' => $request->input('nama'),
                ]);
            }

            DB::commit();

            return redirect()->route('user')->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui pengguna: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pengguna. Silakan coba lagi.');
        }
    }
}
