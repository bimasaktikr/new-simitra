<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Survey;

class DashboardController extends Controller
{
    public function index()
    {
        $userData = session('user_data');

        // Ambil semua tim
        $teams = Team::all();

        // Hitung total survei dan survei yang sudah dinilai
        $totalSurveys = Survey::count();
        $totalSurveysReviewed = Survey::where('is_sudah_dinilai', 1)->count();

        // Hitung persentase survei yang sudah dinilai secara keseluruhan
        $overallPercentage = ($totalSurveys > 0) ? ($totalSurveysReviewed / $totalSurveys) * 100 : 0;

        // Data progress untuk setiap tim
        $progressData = [];

        foreach ($teams as $team) {
            // Hitung total survei yang sudah dinilai
            $totalSurveysTeam = Survey::where('team_id', $team->id)->count();
            $completedSurveysTeam = Survey::where('team_id', $team->id)
                                    ->where('is_sudah_dinilai', 1)
                                    ->count();

            // Hitung persentase
            $percentage = $totalSurveysTeam > 0 ? ($completedSurveysTeam / $totalSurveysTeam) * 100 : 0;

            // Simpan data ke dalam array
            $progressData[$team->id] = [
                'name' => $team->name,
                'percentage' => $percentage,
            ];
        }

        return view('dashboard', [
            'userData' => $userData,
            'overallPercentage' => $overallPercentage,
            'progressData' => $progressData,
        ]);
    }

    public function bantuan()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang login
        return view('bantuan', compact('user')); // Mengirim data ke view
    }
}
