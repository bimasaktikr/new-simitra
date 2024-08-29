<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Team;

class TeamController extends Controller
{
    protected $user;
    protected $employee;
    protected $team;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $teams = Team::select('teams.*', 'employees.name as emp_name')
                            ->leftJoin('employees', function($join) {
                                $join->on('employees.team_id', '=', 'teams.id')
                                    ->where('employees.peran', 'Ketua tim');
                            })
                            ->paginate($perPage);
        
        return view('team.index', [
            'user' => $this->user,
            'teams' => $teams]);
    }

    public function show($id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        return view('mitradetail', [
            'user' => $this->user,
            'mitra' => $mitra
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        if ($query) {
            $teams = Team::select('teams.*', 'employees.name as emp_name')
                        ->join('employees', 'employees.team_id', '=', 'teams.id')
                        ->where('teams.name', 'LIKE', "%{$query}%")
                        ->orWhere('employees.name', 'LIKE', "%{$query}%")
                        ->paginate($perPage);
        } else {
            $teams = Team::select('teams.*', 'employees.name as emp_name')
                        ->join('employees', 'employees.team_id', '=', 'teams.id')
                        ->paginate($perPage);
        }

        return view('team.table', compact('teams'));
    }
}
