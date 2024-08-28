<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Mitra; 

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

        $users = User::select('users.*', 'roles.role as role')
                     ->join('roles', 'users.role_id', '=', 'roles.id')
                     ->paginate($perPage);

        // Mengirim data survei ke view
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

        return view('usertable', compact('users'))->render();
    }

    public function show($id)
    {
        $survey = Survey::select('surveys.*', 'teams.name as team_name', 'teams.code as team_code', 'payment_types.payment_type as payment_type_name')
                    ->join('teams', 'surveys.team_id', '=', 'teams.id')
                    ->join('payment_types', 'surveys.payment_type_id', '=', 'payment_types.id') // Join payment_types
                    ->where('surveys.id', $id)
                    ->first();

        if (!$survey) {
            return redirect()->route('survei')->with('error', 'Survei tidak ditemukan');
        }

        return view('surveydetail', [
            'user' => $this->user,
            'survey' => $survey
        ]);
    }

    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->tanggal_mulai = Carbon::parse($survey->tanggal_mulai);
        $survey->tanggal_berakhir = Carbon::parse($survey->tanggal_berakhir);

        $teams = Team::all();
        $paymentTypes = PaymentType::all();

        return view('editsurvey', [
            'user' => $this->user,
            'survey' => $survey,
            'teams' => $teams,
            'paymentTypes' => $paymentTypes
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

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('user')->with('success', 'User berhasil dihapus.');
    }

}
