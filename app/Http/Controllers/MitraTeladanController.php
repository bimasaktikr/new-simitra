<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use Carbon\Carbon;

class MitraTeladanController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

//     public function index(Request $request)
// {
//     $perPage = $request->input('per_page', 10);
//     $period = $request->input('period', 'all-time');

//     switch ($period) {
//         case 'q1':
//             $start = Carbon::createFromDate(now()->year, 1, 1)->startOfDay();
//             $end = Carbon::createFromDate(now()->year, 3, 31)->endOfDay();
//             break;
//         case 'q2':
//             $start = Carbon::createFromDate(now()->year, 4, 1)->startOfDay();
//             $end = Carbon::createFromDate(now()->year, 6, 30)->endOfDay();
//             break;
//         case 'q3':
//             $start = Carbon::createFromDate(now()->year, 7, 1)->startOfDay();
//             $end = Carbon::createFromDate(now()->year, 9, 30)->endOfDay();
//             break;
//         case 'q4':
//             $start = Carbon::createFromDate(now()->year, 10, 1)->startOfDay();
//             $end = Carbon::createFromDate(now()->year, 12, 31)->endOfDay();
//             break;
//         case 'all-time':
//         default:
//             $start = Carbon::createFromDate(now()->year, 1, 1)->startOfDay();
//             $end = Carbon::createFromDate(now()->year, 12, 31)->endOfDay();
//             break;
//     }

//     $mitras = Mitra::with(['transactions.survey' => function ($query) use ($start, $end) {
//             $query->whereBetween('start_date', [$start, $end])
//                 ->whereBetween('end_date', [$start, $end]);
//         }])
//         ->withCount(['transactions' => function ($query) use ($start, $end) {
//             $query->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
//                 ->whereBetween('surveys.start_date', [$start, $end])
//                 ->whereBetween('surveys.end_date', [$start, $end]);
//         }])
//         ->get();

//     $leaderboards = $mitras->map(function ($mitra) use ($start, $end) {
//         $transactionIds = $mitra->transactions->pluck('id');

//         $averageRating = DB::table('nilai1')
//             ->join('transactions', 'nilai1.transaction_id', '=', 'transactions.id')
//             ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
//             ->whereIn('transactions.id', $transactionIds)
//             ->whereBetween('surveys.start_date', [$start, $end])
//             ->whereBetween('surveys.end_date', [$start, $end])
//             ->avg('nilai1.rerata');

//         $rating = $averageRating !== null ? round($averageRating, 2) : '-';

//         return [
//             'name' => $mitra->name,
//             'id_sobat' => $mitra->id_sobat,
//             'rating' => $rating,
//             'banyak_survey' => $mitra->transactions_count,
//         ];
//     })->sortByDesc('rating')->values();

//     $paginatedLeaderboards = $leaderboards->slice(($request->input('page', 1) - 1) * $perPage, $perPage)->values();

//     $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
//         $paginatedLeaderboards,
//         $leaderboards->count(),
//         $perPage,
//         $request->input('page', 1),
//         ['path' => $request->url(), 'query' => $request->query()]
//     );

//     return view('mitrateladan.index', [
//         'leaderboards' => $pagination,
//         'period' => $period,
//     ]);
// }

public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $period = $request->input('period', 'all-time');
        $start = Carbon::createFromDate(now()->year, 1, 1)->startOfDay();
        $end = Carbon::createFromDate(now()->year, 12, 31)->endOfDay();

        // Adjust period dates based on request
        switch ($period) {
            case 'q1':
                $start = Carbon::createFromDate(now()->year, 1, 1)->startOfDay();
                $end = Carbon::createFromDate(now()->year, 3, 31)->endOfDay();
                break;
            case 'q2':
                $start = Carbon::createFromDate(now()->year, 4, 1)->startOfDay();
                $end = Carbon::createFromDate(now()->year, 6, 30)->endOfDay();
                break;
            case 'q3':
                $start = Carbon::createFromDate(now()->year, 7, 1)->startOfDay();
                $end = Carbon::createFromDate(now()->year, 9, 30)->endOfDay();
                break;
            case 'q4':
                $start = Carbon::createFromDate(now()->year, 10, 1)->startOfDay();
                $end = Carbon::createFromDate(now()->year, 12, 31)->endOfDay();
                break;
        }

        // Fetch mitras individually ranked
        $mitras = Mitra::with(['transactions.survey' => function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                      ->whereBetween('end_date', [$start, $end]);
            }])
            ->withCount(['transactions' => function ($query) use ($start, $end) {
                $query->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
                      ->whereBetween('surveys.start_date', [$start, $end])
                      ->whereBetween('surveys.end_date', [$start, $end]);
            }])
            ->get();

        // Individual rankings
        $individualLeaderboards = $mitras->map(function ($mitra) use ($start, $end) {
            $transactionIds = $mitra->transactions->pluck('id');

            $averageRating = DB::table('nilai1')
                ->join('transactions', 'nilai1.transaction_id', '=', 'transactions.id')
                ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
                ->whereIn('transactions.id', $transactionIds)
                ->whereBetween('surveys.start_date', [$start, $end])
                ->whereBetween('surveys.end_date', [$start, $end])
                ->avg('nilai1.rerata');

            $rating = $averageRating !== null ? round($averageRating, 2) : '-';

            return [
                'name' => $mitra->name,
                'id_sobat' => $mitra->id_sobat,
                'rating' => $rating,
                'banyak_survey' => $mitra->transactions_count,
            ];
        })->sortByDesc('rating')->values();

        // Top mitra per team for stage 2 evaluation
        $topMitraPerTeam = DB::table('mitras')
            ->join('transactions', 'mitras.id_sobat', '=', 'transactions.mitra_id')
            ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
            ->join('nilai1', 'nilai1.transaction_id', '=', 'transactions.id')
            ->join('teams', 'surveys.team_id', '=', 'teams.id')
            ->select('mitras.name', 'mitras.id_sobat', DB::raw('AVG(nilai1.rerata) as average_rating'), 'surveys.team_id', 'teams.name as team')
            ->whereBetween('surveys.start_date', [$start, $end])
            ->whereBetween('surveys.end_date', [$start, $end])
            ->groupBy('mitras.id_sobat', 'surveys.team_id')
            ->orderBy('average_rating', 'desc')
            ->get()
            ->groupBy('team_id')
            ->map(function ($group) {
                return $group->first();
            })
            ->take(5);

        // Pagination
        $paginatedLeaderboards = $individualLeaderboards->slice(($request->input('page', 1) - 1) * $perPage, $perPage)->values();

        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedLeaderboards,
            $individualLeaderboards->count(),
            $perPage,
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('mitrateladan.index', [
            'individualLeaderboards' => $pagination,
            'topMitraPerTeam' => $topMitraPerTeam,
            'period' => $period,
        ]);
    }

    public function liveSearch(Request $request)
    {
        $searchTerm = $request->input('search');
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

        $mitras = Mitra::with(['transactions.survey' => function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->whereBetween('end_date', [$start, $end]);
            }])
            ->withCount(['transactions' => function ($query) use ($start, $end) {
                $query->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
                    ->whereBetween('surveys.start_date', [$start, $end])
                    ->whereBetween('surveys.end_date', [$start, $end]);
            }])
            ->where('name', 'like', '%' . $searchTerm . '%')
            ->get();

        $leaderboards = $mitras->map(function ($mitra) {
            $transactionIds = $mitra->transactions->pluck('id');

            $averageRating = DB::table('nilai1')
                ->whereIn('transaction_id', $transactionIds)
                ->avg('rerata');

            $rating = $averageRating !== null ? round($averageRating, 2) : '-';

            return [
                'name' => $mitra->name,
                'id_sobat' => $mitra->id_sobat,
                'rating' => $rating,
                'banyak_survey' => $mitra->transactions_count,
            ];
        })->sortByDesc('rating')->values();

        return response()->json($leaderboards);
    }
}
