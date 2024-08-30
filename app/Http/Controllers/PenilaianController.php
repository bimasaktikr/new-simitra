<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\Survey;
use App\Models\Nilai;
use App\Models\Transaction;

class PenilaianController extends Controller
{
    public function create($transaction_id)
    {

        $transaction = Transaction::findOrFail($transaction_id);

        $mitra = Mitra::where('id_sobat', $transaction->mitra_id)->first();

        $survey = Survey::where('id', $transaction->survey_id)->first();

        return view('penilaian.create', compact('transaction_id', 'mitra', 'survey'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'survey_id' => 'required|exists:surveys,id',
            'kualitas_data' => 'required|integer|min:1|max:5',
            'ketepatan_waktu' => 'required|integer|min:1|max:5',
            'pemahaman_pengetahuan_kerja' => 'required|integer|min:1|max:5',
        ]);

        try {
            DB::beginTransaction();

            $nilai = Nilai::create([
                'transaction_id' => $request->transaction_id,
                'aspek1' => $request->kualitas_data,
                'aspek2' => $request->ketepatan_waktu,
                'aspek3' => $request->pemahaman_pengetahuan_kerja,
            ]);

            DB::commit();
            return redirect()->route('survey.detail', ['id' => $request->survey_id])->with('success', 'Penilaian berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            \Log::error('Error saat melakukan penilaian: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat melakukan penilaian. Silakan coba lagi.');
        }
    }
}

