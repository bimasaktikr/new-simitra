<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\Survey;
use App\Models\Nilai;
use App\Services\MitraService;
use Carbon\Carbon;

class MitraTeladanController extends Controller
{
    protected $user;
    protected $mitra;
    protected $mitraService;


    public function __construct(MitraService $mitraService)
    {
        $this->user = Auth::user();
        $this->mitraService = $mitraService;
    }

    public function index(Request $request)
    {
        // $perPage = $request->input('per_page', 10);
        $year = $request->input('year');
        $quarter = $request->input('quarter');

      
        switch ($quarter) {
            case '1':
                $mitras = $this->mitraService->getTopMitra($year, 1);
                break;
            case '2':
                $mitras = $this->mitraService->getTopMitra($year, 2);
                break;
            case '3':
                $mitras = $this->mitraService->getTopMitra($year, 3);
                break;
            case '4':
                $mitras = $this->mitraService->getTopMitra($year, 4);
                break;
            case 'all-time':
            default:
                $mitras = $this->mitraService->getTopMitra($year);
                break;
        }

   $mitras =  json_decode($mitras,  true);
//    return $mitras->toJson();
   return view('mitrateladan', compact('mitras', 'year', 'quarter'));

}

    public function liveSearch(Request $request)
    {
        $searchTerm = $request->input('search');
        $period = $request->input('period', 'all-time');

        switch ($period) {
            case 'q1':
                $this->mitraService->getAllMitra(2024, 1);
                break;
            case 'q2':
                $this->mitraService->getAllMitra(2024, 2);
                break;
            case 'q3':
                $this->mitraService->getAllMitra(2024, 3);
                
                break;
            case 'q4':
                $this->mitraService->getAllMitra(2024, 4);
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
