<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Survey;
use App\Models\Mitra;

class TransactionController extends Controller
{
    protected $user;
    protected $transaction;
    protected $mitra;
    protected $survey;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        // $transactions = Transaction::select('transactions.*', 'mitras.name as mitra_name', 'surveys.name as survey_name', 'surveys.code as survey_code')
        //                     ->join('mitras', 'transactions.mitra_id', '=', 'mitras.id_sobat')
        //                     ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
        //                     ->paginate($perPage);

        /**
         * Eager Loading
         */

         $transactions = Transaction::with('mitra')
                                        ->with('survey')
                                        ->with('nilai1')
                                        ->paginate($perPage);
        
        return view('transaction.index', [
            'user' => $this->user,
            'transactions' => $transactions]);
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
            $transactions = Transaction::select('transactions.*', 'mitras.name as mitra_name', 'surveys.name as survey_name', 'surveys.code as survey_code')
                        ->join('mitras', 'transactions.mitra_id', '=', 'mitras.id_sobat')
                        ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
                        ->where('mitras.name', 'LIKE', "%{$query}%")
                        ->orWhere('surveys.name', 'LIKE', "%{$query}%")
                        ->orWhere('surveys.code', 'LIKE', "%{$query}%")
                        ->paginate($perPage);
        } else {
            $transactions = Transaction::select('transactions.*', 'mitras.name as mitra_name', 'surveys.name as survey_name', 'surveys.code as survey_code')
                        ->join('mitras', 'transactions.mitra_id', '=', 'mitras.id_sobat')
                        ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
                        ->paginate($perPage);
        }

        return view('transaction.table', compact('transactions'));
    }
}
