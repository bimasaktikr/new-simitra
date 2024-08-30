<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use App\Models\User;
use App\Models\Mitra;
use App\Models\Transaction;
use Carbon\Carbon;

class MitraController extends Controller
{
    protected $user;
    protected $mitra;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $mitras = Mitra::paginate($perPage);
        
        return view('mitra', [
            'user' => $this->user,
            'mitras' => $mitras]);
    }

    public function add()
    {
        return view('addmitra', ['user' => $this->user]);  
    }
    
    public function edit($id_sobat)
    {
        $mitra = Mitra::findOrFail($id_sobat);
        $mitra->tanggal_lahir = Carbon::parse($mitra->tanggal_lahir);

        return view('editmitra', [
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
        $transactions = Transaction::select('transactions.*', 'surveys.name as survey_name', 'surveys.code as survey_code', 'transactions.payment', DB::raw('IFNULL(transactions.nilai, "Belum dinilai") as nilai'))
            ->join('surveys', 'transactions.survey_id', '=', 'surveys.id')
            ->where('transactions.mitra_id', $mitra->id_sobat)
            ->paginate($perPage);

        return view('mitradetail', [
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

        return view('mitratable', compact('mitras'));
    }

    public function destroy($id_sobat)
    {
        $mitra = Mitra::where('id_sobat', $id_sobat)->firstOrFail();

        $mitra->delete();

        return redirect()->route('mitra')->with('success', 'Mitra berhasil dihapus.');
    }
}

