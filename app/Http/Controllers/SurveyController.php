<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Survey;
use App\Models\Team; 
use App\Models\Transaction;
use App\Models\Mitra; 
use App\Models\User; 
use App\Models\PaymentType;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SurveyController extends Controller
{
    protected $user;
    protected $survey;
    protected $team;
    protected $paymentType;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status = $request->input('status', 'semua');

        $today = Carbon::today();

        $surveys = Survey::select('surveys.*', 'teams.name as team_name', 'teams.code as team_code')
                    ->join('teams', 'surveys.team_id', '=', 'teams.id')
                    ->when($status === 'sedang berlangsung', function ($query) use ($today) {
                        $query->where('surveys.end_date', '>=', $today);
                    })
                    ->when($status === 'sudah berakhir', function ($query) use ($today) {
                        $query->where('surveys.end_date', '<', $today);
                    })
                    ->paginate($perPage);

        return view('survey', [
            'user' => $this->user,
            'surveys' => $surveys,
            'status' => $status
        ]);
    }


    // public function index(Request $request)
    // {
    //     $perPage = $request->input('per_page', 10);

    //     $surveys = Survey::select('surveys.*', 'teams.name as team_name', 'teams.code as team_code')
    //                  ->join('teams', 'surveys.team_id', '=', 'teams.id')
    //                  ->paginate($perPage);

    //     return view('survey', [
    //         'user' => $this->user,
    //         'surveys' => $surveys
    //     ]);
    // }

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
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'tim' => 'required|exists:teams,id',
            'tipe_pembayaran' => 'required|exists:payment_types,id', // Validasi payment_type_id
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
            'code' => $request->input('kode'),
            'start_date' => $request->input('tanggal_mulai'),
            'end_date' => $request->input('tanggal_berakhir'),
            'team_id' => $request->input('tim'),
            'payment_type_id' => $request->input('tipe_pembayaran'), // Simpan payment_type_id
            'payment' => $request->input('harga'),
            'file' => $filePath, // Simpan path file
            'is_sudah_dinilai' => 0,
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil ditambahkan.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        if ($query) {
            $surveys = Survey::select('surveys.*', 'teams.name as team_name')
                        ->join('teams', 'surveys.team_id', '=', 'teams.id')
                        ->where('surveys.name', 'LIKE', "%{$query}%")
                        ->orWhere('surveys.code', 'LIKE', "%{$query}%")
                        ->orWhere('teams.name', 'LIKE', "%{$query}%")
                        ->paginate($perPage);
        } else {
            $surveys = Survey::select('surveys.*', 'teams.name as team_name')
                        ->join('teams', 'surveys.team_id', '=', 'teams.id')
                        ->paginate($perPage);
        }

        return view('surveytable', compact('surveys'))->render();
    }

    public function show($id)
    {
        $survey = Survey::where('id', $id)->firstOrFail();

        $survey = Survey::select('surveys.*', 'teams.name as team_name', 'teams.code as team_code', 'payment_types.payment_type as payment_type_name')
                    ->join('teams', 'surveys.team_id', '=', 'teams.id')
                    ->join('payment_types', 'surveys.payment_type_id', '=', 'payment_types.id') 
                    ->where('surveys.id', $id)
                    ->first();

        $perPage = request()->get('per_page', 10);
        // $transactions = Transaction::select('transactions.*', 'mitras.name as mitra_name', 'mitras.id_sobat as mitra_id', DB::raw('IFNULL(transactions.nilai, "Belum dinilai") as nilai'))
        //             ->join('mitras', 'transactions.mitra_id', '=', 'mitras.id_sobat')
        //             ->where('transactions.survey_id', $survey->id)
        //             ->paginate($perPage);

                    $transactions = Transaction::select(
                        'transactions.*', 
                        'mitras.name as mitra_name', 
                        'mitras.id_sobat as mitra_id', 
                        DB::raw('IFNULL(nilai1.rerata, "Belum dinilai") as nilai')
                    )
                    ->join('mitras', 'transactions.mitra_id', '=', 'mitras.id_sobat')
                    ->leftJoin('nilai1', 'transactions.id', '=', 'nilai1.transaction_id') // Join ke tabel nilai1
                    ->where('transactions.survey_id', $survey->id)
                    ->paginate($perPage);

        if (!$survey) {
            return redirect()->route('survei')->with('error', 'Survei tidak ditemukan');
        }

        return view('surveydetail', [
            'user' => $this->user,
            'survey' => $survey,
            'transactions' => $transactions
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'tim' => 'required|exists:teams,id', // Validasi team_id
            'tipe_pembayaran' => 'required|exists:payment_types,id', // Validasi payment_type_id
            'file' => 'nullable|file|mimes:csv,xls,xlsx'
        ]);

        $survey = Survey::findOrFail($id);

        $survey->update([
            'name' => $request->input('nama'),
            'code' => $request->input('kode'),
            'start_date' => $request->input('tanggal_mulai'),
            'end_date' => $request->input('tanggal_berakhir'),
            'team_id' => $request->input('tim'),
            'payment_type_id' => $request->input('tipe_pembayaran'), // Update payment_type_id
            'file' => $filePath
        ]);

        return redirect()->route('survei')->with('success', 'Survei berhasil diperbarui.');
    }

    public function sync($id)
    {
        // Ambil survei berdasarkan ID
        $survey = Survey::findOrFail($id);

        // Cek apakah survei memiliki file
        if (!$survey->file) {
            return redirect()->route('surveidetail', ['id' => $id])->with('error', 'Tidak ada file yang diunggah untuk survei ini.');
        }

        // Baca file Excel
        $filePath = storage_path('app/public/' . $survey->file);
        $data = Excel::toArray([], $filePath);

        $sheetdata = $data[0];
        array_shift($sheetdata);

        // Memfilter baris yang kosong atau hanya berisi null
        $filterData = array_filter($sheetdata, function($row) {
            // Memastikan baris tidak semuanya null
            return array_filter($row);
        });

        // Iterasi setiap baris dalam file Excel
        foreach ($filterData as $row) {
            $id_mitra = $row[1];
            $name = $row[2];
            $jenis_kelamin = $row[3];
            $email = $row[4];
            $pendidikan = $row[5];
            $tanggal_lahir = $row[6];
            $target = isset($row[7]) ? $row[7] : 1;

            $user = User::firstOrCreate(['email' => $email],[
                'password' => bcrypt($id_mitra), 
                'role_id' => 3,
                'status' => 'Aktif',
            ]);

            $mitra = Mitra::firstOrCreate(['id_sobat' => $id_mitra], [
                'name' => $name,
                'email' => $email,
                'jenis_kelamin' => $jenis_kelamin, 
                'pendidikan' => $pendidikan,
                'tanggal_lahir' => $tanggal_lahir
            ]);

            // Tambahkan transaksi
            $total_payment = $survey->payment * $target;
            Transaction::create([
                'survey_id' => $survey->id,
                'mitra_id' => $mitra->id_sobat,
                'payment' => $survey->payment,
                'target' => $target ?? 1,
                'total_payment' => $total_payment,
            ]);
            
        }
        return redirect()->route('surveidetail', ['id' => $id])->with('success', 'Data berhasil disinkronisasi.');
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);

        $survey->delete();

        return redirect()->route('survei')->with('success', 'Survey berhasil dihapus.');
    }
}
