<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\Survey;
use App\Models\Nilai;
use Carbon\Carbon;

class MitraTeladanController extends Controller{ 

    protected $user;
    protected $mitra;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    // public function index(Request $request)
    // {
    //     $perPage = $request->input('per_page', 10);

    //     $currentQuarterStart = Carbon::now()->firstOfQuarter();
    //     $currentQuarterEnd = Carbon::now()->lastOfQuarter();

    //     // Ambil data mitra dengan nilai rata-rata survei tertinggi per tim pada triwulan berjalan
    //     $mitraLeaderboards = Survey::where(function($query) use ($currentQuarterStart, $currentQuarterEnd) {
    //             // Filter survei yang aktif dalam triwulan berjalan
    //             $query->whereBetween('start_date', [$currentQuarterStart, $currentQuarterEnd])
    //                 ->orWhereBetween('end_date', [$currentQuarterStart, $currentQuarterEnd]);
    //         })
    //         ->with(['mitra', 'team', 'nilai']) // Load relasi yang dibutuhkan
    //         ->get()
    //         ->groupBy('team_id') // Kelompokkan survei berdasarkan tim
    //         ->map(function ($surveysPerTeam) {
    //             return $surveysPerTeam->groupBy('mitra_id')->map(function ($surveysPerMitra) {
    //                 // Hitung rata-rata nilai untuk setiap mitra di tim tersebut
    //                 $avgScore = $surveysPerMitra->flatMap(function ($survey) {
    //                     return $survey->nilai; // Ambil semua nilai terkait survei
    //                 })->avg('rata_rata'); // Hitung rata-rata nilai

    //                 return [
    //                     'mitra' => $surveysPerMitra->first()->mitra,
    //                     'avgScore' => $avgScore,
    //                     'surveyCount' => $surveysPerMitra->count(),
    //                 ];
    //             })
    //             ->sort(function ($a, $b) {
    //                 // Urutkan berdasarkan nilai rata-rata tertinggi, jika sama, berdasarkan jumlah survei terbanyak
    //                 return $b['avgScore'] <=> $a['avgScore'] ?: $b['surveyCount'] <=> $a['surveyCount'];
    //             })
    //             ->first(); // Pilih mitra dengan skor tertinggi untuk tim tersebut
    //         })
    //         ->values(); // Reset indeks

    //     // Ambil data mitra dan jumlah survei pada triwulan berjalan
    //     $mitras = Mitra::withCount(['surveys' => function($query) use ($currentQuarterStart, $currentQuarterEnd) {
    //         $query->where(function($query) use ($currentQuarterStart, $currentQuarterEnd) {
    //             $query->whereBetween('start_date', [$currentQuarterStart, $currentQuarterEnd])
    //                 ->orWhereBetween('end_date', [$currentQuarterStart, $currentQuarterEnd]);
    //         });
    //     }])
    //     ->with(['surveys' => function($query) use ($currentQuarterStart, $currentQuarterEnd) {
    //         $query->where(function($query) use ($currentQuarterStart, $currentQuarterEnd) {
    //             $query->whereBetween('start_date', [$currentQuarterStart, $currentQuarterEnd])
    //                 ->orWhereBetween('end_date', [$currentQuarterStart, $currentQuarterEnd]);
    //         });
    //     }])
    //     ->paginate($perPage);

    //     return view('mitrateladan', [
    //         'user' => $this->user,
    //         'mitras' => $mitras,
    //         'leaderboards' => $mitraLeaderboards
    //     ]);
    // }
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);

    $currentYear = date('Y'); 
    $currentPeriodStart = "{$currentYear}-01-01"; 
    $currentPeriodEnd = "{$currentYear}-12-31";   

    $mitras = Mitra::with(['transactions.survey' => function ($query) use ($currentPeriodStart, $currentPeriodEnd) {
            $query->whereBetween('start_date', [$currentPeriodStart, $currentPeriodEnd])
                  ->whereBetween('end_date', [$currentPeriodStart, $currentPeriodEnd]);
        }])
        ->withCount(['transactions' => function ($query) use ($currentPeriodStart, $currentPeriodEnd) {
            $query->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
                  ->whereBetween('surveys.start_date', [$currentPeriodStart, $currentPeriodEnd])
                  ->whereBetween('surveys.end_date', [$currentPeriodStart, $currentPeriodEnd]);
        }])
        ->paginate($perPage);

        $leaderboards = $mitras->map(function ($mitra) {
            $transactionIds = $mitra->transactions->pluck('id');
        
            $averageRating = DB::table('nilai1')
                ->whereIn('transaction_id', $transactionIds)
                ->avg('rerata');
        
            $rating = $averageRating !== null ? round($averageRating, 2) : null;
        
            return [
                'name' => $mitra->name,
                'id_sobat' => $mitra->id_sobat,
                'rating' => $rating,
                'banyak_survey' => $mitra->transactions_count,
            ];
        });
        
        $leaderboards = $leaderboards->sortByDesc('rating')->values();
        
        $leaderboards = $leaderboards->map(function ($item, $index) {
            $item['ranking'] = $index + 1; 
            $item['rating'] = $item['rating'] === null ? '-' : $item['rating']; 
            return $item;
        });

    // dd($leaderboards->toArray());

    return view('mitrateladan', [
        'mitras' => $mitras,
        'leaderboards' => $leaderboards,
    ]);
}


}

