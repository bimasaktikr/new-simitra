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

class MitraTeladanController extends Controller{ 

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
        /**
         *  Filter Years -> Quarter
         *  1. Return Mitra dengan Transaksi.
         *  2. Group by Team
         *  3. Jumlah Survey Distinct
         *  4. 
         */
        $perPage = $request->input('per_page', 10);

        $mitras = $this->mitraService->getAllMitra(2024, 3);

        return json_encode($mitras);
        // Hitung rating rata-rata untuk setiap mitra
        // $leaderboards = $mitras->map(function ($mitra) {
        //     $transactionIds = $mitra->transactions->pluck('id');
        
        //     $averageRating = DB::table('nilai1')
        //         ->whereIn('transaction_id', $transactionIds)
        //         ->avg('rerata');
        
        //     $rating = $averageRating !== null ? round($averageRating, 2) : null;
        
        //     return [
        //         'name' => $mitra->name,
        //         'id_sobat' => $mitra->id_sobat,
        //         'rating' => $rating,
        //         'banyak_survey' => $mitra->transactions_count,
        //     ];
        // });

        // Urutkan berdasarkan rating secara global (desc)
        $leaderboards = $leaderboards->sortByDesc('rating')->values();

        // Hitung ranking global
        $leaderboards = $leaderboards->map(function ($item, $index) {
            $item['ranking'] = $index + 1; // Ranking global
            $item['rating'] = $item['rating'] === null ? '-' : $item['rating']; 
            return $item;
        });

        // Setelah diurutkan dan diranking, lakukan pagination pada hasil yang sudah diranking
        $paginatedLeaderboards = $leaderboards->slice(($request->input('page', 1) - 1) * $perPage, $perPage)->values();

        // Lakukan pagination manual
        $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedLeaderboards, // Data yang dipaginate
            $leaderboards->count(), // Total item
            $perPage, // Item per halaman
            $request->input('page', 1), // Halaman saat ini
            ['path' => $request->url(), 'query' => $request->query()] // URL dan query string
        );

        return view('mitrateladan', [
            'mitras' => $mitras, // Passing hasil paginated
            'leaderboards' => $pagination, // Leaderboards terpaginated
        ]);
    }

}