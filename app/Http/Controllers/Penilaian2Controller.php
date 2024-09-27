<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\MitraTeladan;
use App\Models\Survey;
use App\Models\Nilai1;
use App\Models\Nilai2;
use App\Models\Transaction;
use App\Models\VariabelPenilaian;
use App\Services\Nilai2Service;
use Illuminate\Support\Facades\Log;

class Penilaian2Controller extends Controller
{   
    protected $nilai2Service;

    /**
     * Constructor injection of the Nilai2Service
     */
    public function __construct(Nilai2Service $nilai2Service)
    {
        $this->nilai2Service = $nilai2Service;
    }

    public function create($id)
    {

        $mitra_teladan = MitraTeladan::where('id', $id)->first();
        $penilaian2 = VariabelPenilaian::where('tahap', '2')->get();

        session(['previous_url' => url()->previous()]);

        return view('penilaian2.create', compact('mitra_teladan', 'penilaian2'));
    }


    public function store(Request $request)
    {   
        // Log incoming request data
        Log::info('Store method called', ['request_data' => $request->all()]);

        $request->validate([
            'mitra_teladan_id' => 'required|exists:mitra_teladans,id',
            'aspek1' => 'required|integer|min:1|max:5',
            'aspek2' => 'required|integer|min:1|max:5',
            'aspek3' => 'required|integer|min:1|max:5',
            'aspek4' => 'required|integer|min:1|max:5',
            'aspek5' => 'required|integer|min:1|max:5',
            'aspek6' => 'required|integer|min:1|max:5',
            'aspek7' => 'required|integer|min:1|max:5',
            'aspek8' => 'required|integer|min:1|max:5',
            'aspek9' => 'required|integer|min:1|max:5',
            'aspek10' => 'required|integer|min:1|max:5',
        ]);

        // dd($validated);
        // Log after validation
        Log::info('Validation passed');

        // Add 'team_penilai_id' from the logged-in user's team_id
        $temployeeId = Auth::user()->employee->id;
        // dd($teamPenilaiId);
        // Calculate 'rerata' (average) for aspek1 to aspek10
        $rerata = collect([
            $request->input('aspek1'),
            $request->input('aspek2'),
            $request->input('aspek3'),
            $request->input('aspek4'),
            $request->input('aspek5'),
            $request->input('aspek6'),
            $request->input('aspek7'),
            $request->input('aspek8'),
            $request->input('aspek9'),
            $request->input('aspek10'),
            $request->input('is_final'),
        ])->avg();

        $data = [
            'mitra_teladan_id' => $request->input('mitra_teladan_id'),
            'employee_id' => $temployeeId,
            'rerata' => $rerata,
            'aspek1' => $request->input('aspek1'),
            'aspek2' => $request->input('aspek2'),
            'aspek3' => $request->input('aspek3'),
            'aspek4' => $request->input('aspek4'),
            'aspek5' => $request->input('aspek5'),
            'aspek6' => $request->input('aspek6'),
            'aspek7' => $request->input('aspek7'),
            'aspek8' => $request->input('aspek8'),
            'aspek9' => $request->input('aspek9'),
            'aspek10' => $request->input('aspek10'),
            'is_final' => $request->input('is_final'),
        ];


        Nilai2::create($data);

        return redirect(route('mitrateladan.index'))->with('success', 'Data saved successfully!');
    }

    public function edit($mitra_teladan_id)
    {   
        $mitra_teladan = MitraTeladan::where('id', $mitra_teladan_id)->first();

        $nilai_2 = Nilai2::where('mitra_teladan_id', $mitra_teladan_id)
                            ->where('team_penilai_id', Auth::user()->employee->team_id)
                            ->first();

        $penilaian2 = VariabelPenilaian::where('tahap', '2')->get();
        session(['previous_url' => url()->previous()]);

        return view('penilaian2.edit', compact('nilai_2', 'penilaian2', 'mitra_teladan'));
    }

    public function update(Request $request)
    {   
        // dd($request);

        $request->validate([
            'aspek1' => 'required|integer|min:1|max:5',
            'aspek2' => 'required|integer|min:1|max:5',
            'aspek3' => 'required|integer|min:1|max:5',
            'aspek4' => 'required|integer|min:1|max:5',
            'aspek5' => 'required|integer|min:1|max:5',
            'aspek6' => 'required|integer|min:1|max:5',
            'aspek7' => 'required|integer|min:1|max:5',
            'aspek8' => 'required|integer|min:1|max:5',
            'aspek9' => 'required|integer|min:1|max:5',
            'aspek10' => 'required|integer|min:1|max:5',
            'is_final' => 'required',
        ]);

        Log::info('Validation passed');

        
        $rerata = collect([
            $request->input('aspek1'),
            $request->input('aspek2'),
            $request->input('aspek3'),
            $request->input('aspek4'),
            $request->input('aspek5'),
            $request->input('aspek6'),
            $request->input('aspek7'),
            $request->input('aspek8'),
            $request->input('aspek9'),
            $request->input('aspek10'),
        ])->avg();

        $data = [
            'rerata' => $rerata,
            'aspek1' => $request->input('aspek1'),
            'aspek2' => $request->input('aspek2'),
            'aspek3' => $request->input('aspek3'),
            'aspek4' => $request->input('aspek4'),
            'aspek5' => $request->input('aspek5'),
            'aspek6' => $request->input('aspek6'),
            'aspek7' => $request->input('aspek7'),
            'aspek8' => $request->input('aspek8'),
            'aspek9' => $request->input('aspek9'),
            'aspek10' => $request->input('aspek10'),
            'is_final' => $request->input('is_final'),
        ];

         // Find the transaction by ID and update it
        $transaction = Nilai2::find($request->input('nilai_2_id'));
        // dd($transaction);

        if ($transaction) {
            $transaction->update($data);
            Log::info("Transaction updated successfully.", ['transaction_id' => $transaction->id]);
    
            return redirect(route('mitrateladan.index'))->with('success', 'Data saved successfully!');
        } else {
            return redirect(route('mitrateladan.index'))->with('error', 'Transaction not found.');
        }
    }
}

