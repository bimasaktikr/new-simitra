<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use App\Models\User;
use App\Models\Mitra;
use App\Models\Survey;
use App\Models\Transaction;
use App\Services\MitraService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MitraController extends Controller
{
    protected $user;
    protected $mitra;
    protected $survey;
    protected $transaction;
    protected $mitraService;

    public function __construct(MitraService $mitraService)
    {
        $this->user = Auth::user();
        $this->mitraService = $mitraService;
        // $this->nilai1Service = $nilai1Service; // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $mitras = Mitra::select('mitras.*', 'users.status as status')
                    ->join('users', 'users.email', '=', 'mitras.email')
                    ->where('users.status', '=', 'Aktif')
                    ->paginate($perPage);
        
        return view('mitra.index', [
            'user' => $this->user,
            'mitras' => $mitras]);
    }

    public function add()
    {
        return view('mitra.add', ['user' => $this->user]);  
    }
    
    public function edit($id_sobat)
    {
        $mitra = Mitra::findOrFail($id_sobat);
        $mitra->tanggal_lahir = Carbon::parse($mitra->tanggal_lahir);

        return view('mitra.edit', [
            'user' => $this->user,
            'mitra' => $mitra
        ]);
    }

    public function update(Request $request, $id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'id_sobat' => 'required|string|max:255|unique:mitras,id_sobat,' . $mitra->id_sobat . ',id_sobat',
            'jk' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $mitra->email . ',email',
            'pendidikan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        $mitra->update([
            'name' => $request->input('nama'),
            'id_sobat' => $request->input('id_sobat'),
            'jenis_kelamin' => $request->input('jk'),
            'email' => $request->input('email'),
            'pendidikan' => $request->input('pendidikan'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
        ]);
        
        return redirect()->route('mitra')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function show($id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        $perPage = request()->get('per_page', 10);

        $transactions = Transaction::select(
            'transactions.*', 
            'surveys.name as survey_name', 
            'surveys.id as survey_id', 
            'surveys.code as survey_code',
            DB::raw('IFNULL(nilai1.rerata, "Belum dinilai") as nilai')
        )
        ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
        ->leftJoin('nilai1', 'transactions.id', '=', 'nilai1.transaction_id') 
        ->where('transactions.mitra_id', $mitra->id_sobat)
        ->paginate($perPage);

        return view('mitra.detail', [
            'user' => $this->user,
            'mitra' => $mitra,
            'transactions' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_sobat' => 'required|string|max:255|unique:mitras',
            'jk' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'pendidikan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->id_sobat), 
                'role_id' => 4,
                'status' => 'Aktif',
            ]);

            $mitra = Mitra::create([
                'name' => $request->nama,
                'id_sobat' => $request->id_sobat,
                'jenis_kelamin' => $request->jk,
                'email' => $user->email, 
                'pendidikan' => $request->pendidikan,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            DB::commit();
            return redirect()->route('mitra')->with('success', 'Mitra berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error
            \Log::error('Error saat menambahkan mitra: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan mitra. Silakan coba lagi.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('per_page', 10);

        $mitras = Mitra::query();

        if ($query) {
            $mitras->where('name', 'LIKE', "%{$query}%")
                ->orWhere('id_sobat', 'LIKE', "%{$query}%");
        }

        $mitras = $mitras->paginate($perPage);

        return view('mitra.table', compact('mitras'));
    }

    public function destroy($id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        $mitra->delete();

        return redirect()->route('mitra')->with('success', 'Mitra berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $filePath = 'public/template/template_mitra.xlsx'; 

        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->download($filePath, 'template_mitra.xlsx');
        }
    
        abort(404, 'Template file not found.');
    }

    public function uploadMitra(Request $request, $surveyId)
    {   
        // dd($request->file);
        
        // Ambil survei berdasarkan ID
        $survey = Survey::findOrFail($surveyId);

       if ($request->hasFile('file')) {
            // This is for a new file upload (first time)
            // dd($request->file);
            $originalName = $request->file('file')->getClientOriginalName();
            $extension = $request->file('file')->getClientOriginalExtension();
            
            $month = Carbon::parse($survey->start_date)->format('Ym');
            
            // Create a unique filename using the month, university name, and the original filename
            $filename = $month. '_' . Str::slug($survey->name) . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            
            // Store the file in the 'profile_files' directory in the 'public' disk
            $path = $request->file('file')->storeAs('mitra', $filename, 'public');
            
            // Assign the path to the intern's file attribute
            $survey->file = $path;
            $survey->save();

            $filePath = storage_path('app/public/' . $survey->file);
            $data = Excel::toArray([], $filePath);
            // dd($data);
           

            if($this->mitraService->importMitra($data, $survey))
            {
                return redirect()->route('surveidetail', ['id' => $surveyId])
                ->with('success', 'File uploaded successfully!');
            } else {
            // Redirect back to the view with error message
            return redirect()->route('surveidetail', ['id' => $surveyId])
                        ->with('error', 'No file uploaded.');
            }
        }
    }
}

