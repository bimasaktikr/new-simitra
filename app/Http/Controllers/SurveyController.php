<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\Team; 
use App\Models\PaymentType;
use Carbon\Carbon;

class SurveyController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $surveys = Survey::select('surveys.*', 'teams.name as team_name', 'teams.code as team_code')
                     ->join('teams', 'surveys.team_id', '=', 'teams.id')
                     ->paginate($perPage);

        // Mengirim data survei ke view
        return view('survey', [
            'user' => $this->user,
            'surveys' => $surveys
        ]);
    }

    public function add()
    {
        // Ambil semua tim dan tipe pembayaran untuk pilihan di formulir
        $teams = Team::all();
        $paymentTypes = PaymentType::all();

        return view('addsurvey', [
            'user' => $this->user,
            'teams' => $teams,
            'paymentTypes' => $paymentTypes // Kirim data tipe pembayaran ke view
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'ketua_tim' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'team_id' => 'required|exists:teams,id',
            'payment_type_id' => 'required|exists:payment_types,id', // Validasi payment_type_id
            'harga' => 'required|numeric',
            'file' => 'nullable|file|mimes:csv,xls,xlsx',
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); // Simpan file di folder 'public/uploads'
        } else {
            $filePath = null;
        }

        // Simpan survei baru
        Survey::create([
            'name' => $request->input('nama'),
            'kode' => $request->input('kode'),
            'ketua_tim' => $request->input('ketua_tim'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
            'team_id' => $request->input('team_id'),
            'payment_type_id' => $request->input('payment_type_id'), // Simpan payment_type_id
            'harga' => $request->input('harga'),
            'file' => $filePath, // Simpan path file
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil ditambahkan.');
    }

    public function show($id)
    {
        $survey = Survey::select('surveys.*', 'teams.name as team_name', 'teams.code as team_code', 'payment_types.payment_type as payment_type_name')
                    ->join('teams', 'surveys.team_id', '=', 'teams.id')
                    ->join('payment_types', 'surveys.payment_type_id', '=', 'payment_types.id') // Join payment_types
                    ->where('surveys.id', $id)
                    ->first();

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

        $teams = Team::all();
        $paymentTypes = PaymentType::all();

        return view('editsurvey', [
            'user' => $this->user,
            'survey' => $survey,
            'teams' => $teams,
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'team_id' => 'required|exists:teams,id', // Validasi team_id
            'payment_type_id' => 'required|exists:payment_types,id', // Validasi payment_type_id
        ]);

        $survey = Survey::findOrFail($id);

        // Memperbarui data survei
        $survey->update([
            'name' => $request->input('name'),
            'kode' => $request->input('kode'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'tanggal_berakhir' => $request->input('tanggal_berakhir'),
            'team_id' => $request->input('team_id'),
            'payment_type_id' => $request->input('payment_type_id'), // Update payment_type_id
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);

        $survey->delete();

        return redirect()->route('survei')->with('success', 'Survey berhasil dihapus.');
    }
}
