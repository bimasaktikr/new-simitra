<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Survey;

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

        $teams = Team::select('teams.*', 'employees.name as ketua_tim')
                            ->leftJoin('employees', function($join) {
                                $join->on('employees.team_id', '=', 'teams.id')
                                    ->where('employees.peran', 'Ketua-tim');
                            })
                            ->paginate($perPage);
        
        return view('team.index', [
            'user' => $this->user,
            'teams' => $teams]);
    }

    public function show($id)
    {
        $teams = Team::where('id', $id)->firstOrFail();

        $perPage = request()->get('per_page', 10);

        $employee = Employee::select('employees.*')
                            ->where('employees.peran', 'Ketua-tim')
                            ->where('employees.team_id', $id)
                            ->first();

        $surveys = Survey::select('surveys.*')
            ->where('surveys.team_id', $id)
            ->paginate($perPage);

        return view('team.detail', [
            'user' => $this->user,
            'teams' => $teams,
            'employee' => $employee,
            'surveys' => $surveys
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
