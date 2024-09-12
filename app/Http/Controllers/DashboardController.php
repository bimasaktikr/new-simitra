<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use App\Models\Survey;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userData = session('user_data');

        $period = $request->input('period', 'all-time');

        switch ($period) {
            case 'q1':
                $start = Carbon::createFromDate(now()->year, 1, 1);
                $end = Carbon::createFromDate(now()->year, 3, 31);
                break;
            case 'q2':
                $start = Carbon::createFromDate(now()->year, 4, 1);
                $end = Carbon::createFromDate(now()->year, 6, 30);
                break;
            case 'q3':
                $start = Carbon::createFromDate(now()->year, 7, 1);
                $end = Carbon::createFromDate(now()->year, 9, 30);
                break;
            case 'q4':
                $start = Carbon::createFromDate(now()->year, 10, 1);
                $end = Carbon::createFromDate(now()->year, 12, 31);
                break;
            case 'all-time':
            default:
                $start = Carbon::createFromDate(now()->year, 1, 1);
                $end = Carbon::createFromDate(now()->year, 12, 31);
                break;
        }

        // Ambil semua tim
        $teams = Team::all();

        $totalSurveys = Survey::select(function($query) use ($start, $end){
            $query->whereBetween('start_date', [$start, $end])
                  ->whereBetween('end_date', [$start, $end]);
            })->count();
        $totalSurveysReviewed = Survey::select(function($query) use ($start, $end){
            $query->whereBetween('start_date', [$start, $end])
                  ->whereBetween('end_date', [$start, $end]);
            })
            ->where('is_sudah_dinilai', 1)
            ->count();

        // Hitung persentase survei yang sudah dinilai secara keseluruhan
        $overallPercentage = ($totalSurveys > 0) ? ($totalSurveysReviewed / $totalSurveys) * 100 : 0;

        //Hitung jumlah user, mitra, dan pegawai
        $totalUsers = User::where('status', 'Aktif')->count();
        $totalMitra = User::where('role_id', 3)->where('status', 'Aktif')->count();
        $totalPegawai = User::where('role_id', 2)->where('status', 'Aktif')->count();

        // Data progress untuk setiap tim
        $progressData = [];

        foreach ($teams as $team) {
            // Hitung total survei yang sudah dinilai
            $totalSurveysTeam = Survey::select(function($query) use ($start, $end){
                $query->whereBetween('start_date', [$start, $end])
                      ->whereBetween('end_date', [$start, $end]);
                })
                ->where('team_id', $team->id)
                ->count();
            $completedSurveysTeam = Survey::select(function($query) use ($start, $end){
                $query->whereBetween('start_date', [$start, $end])
                      ->whereBetween('end_date', [$start, $end]);
                })
                ->where('team_id', $team->id)
                ->where('is_sudah_dinilai', 1)
                ->count();

            // Hitung persentase
            $percentage = $totalSurveysTeam > 0 ? ($completedSurveysTeam / $totalSurveysTeam) * 100 : 0;

            // Simpan data ke dalam array
            $progressData[$team->id] = [
                'name' => $team->name,
                'percentage' => $percentage,
                'totalSurveysTeam' => $totalSurveysTeam
            ];
        }

        return view('dashboard', [
            'userData' => $userData,
            'overallPercentage' => $overallPercentage,
            'progressData' => $progressData,
            'period' => $period,
            'totalSurveys' => $totalSurveys,
            'totalUsers' => $totalUsers,
            'totalMitra' => $totalMitra,
            'totalPegawai' => $totalPegawai
        ]);
    }

    public function bantuan()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang login
        return view('bantuan', compact('user')); // Mengirim data ke view
    }
}
