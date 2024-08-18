<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use Carbon\Carbon;


class SurveyController extends Controller
{
    protected $user;
    protected $survey;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login

        // Data dummy untuk detail survei
        // $this->surveys = [
        //     [
        //         'name' => 'Survei Dummy',
        //         'kode' => '123',
        //         'ketua_tim' => 'Anna Dewanta',
        //         'tanggal_mulai' => '2024-01-01',
        //         'tanggal_berakhir' => '2024-01-31',
        //     ],
        //     [
        //         'name' => 'Survei Dummy 2',
        //         'kode' => '456',
        //         'ketua_tim' => 'Budi Santoso',
        //         'tanggal_mulai' => '2024-02-01',
        //         'tanggal_berakhir' => '2024-02-28',
        //     ]
        // ];
    }

    // public function index()
    // {
    //     return view('survey', [
    //         'user' => $this->user,
    //         'surveys' => $this->surveys
    //     ]); // Mengirim data ke view
    // }

    public function index()
    {
        // Mengambil semua data survei dari tabel
        $surveys = Survey::all();
        
        // Mengirim data survei ke view
        return view('survey', [
            'user' => $this->user,
            'surveys' => $surveys]);
    }

    public function add()
    {
        return view('addsurvey', ['user' => $this->user]); // Mengirim data ke view
    }

    // public function show($id)
    // {
    //     $survey = $this->surveys[$id - 1] ?? null;

    //     return view('surveydetail', [
    //         'user' => $this->user,
    //         'survey' => $survey
    //     ]);
    // }

    public function show($id)
    {
        $survey = Survey::find($id);
        if (!$survey) {
            return redirect()->route('survei')->with('error', 'Survei tidak ditemukan');
        }
        return view('surveydetail', [
            'user' => $this->user,
            'survey' => $survey
        ]);
    }

    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->tanggal_mulai = Carbon::parse($survey->tanggal_mulai);
        $survey->tanggal_berakhir = Carbon::parse($survey->tanggal_berakhir);

        return view('editsurvey', [
            'user' => $this->user,
            'survey' => $survey
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'ketua_tim' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
        ]);

        $survey = Survey::findOrFail($id);

        // Memperbarui data survei
        $survey->update([
            'name' => $request->input('name'),
            'kode' => $request->input('kode'),
            'ketua_tim' => $request->input('ketua_tim'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil diperbarui.');
    }
}
