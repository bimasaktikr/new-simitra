<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentType;

class PaymentTypeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user(); // Mendapatkan data pengguna yang login
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $paymentTypes = PaymentType::paginate($perPage);

        return view('payment_type.index', [
            'user' => $this->user,
            'paymentTypes' => $paymentTypes
        ]);
    }

    public function add()
    {
        $paymentType = PaymentType::all();

        return view('payment_type.add', [
            'user' => $this->user,
            'paymentType' => $paymentType
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        PaymentType::create([
            'payment_type' => $request->input('type'),
        ]);

        return redirect()->route('paymenttype')->with('success', 'Tipe pembayaran berhasil ditambahkan.');
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

    public function edit($id)
    {
        $paymentType = PaymentType::findOrFail($id);

        return view('payment_type.edit', [
            'user' => $this->user,
            'paymentType' => $paymentType
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $paymentType = PaymentType::findOrFail($id);

        $paymentType->update([
            'payment_type' => $request->input('type'),
        ]);

        return redirect()->route('payment_type.index')->with('success', 'Tipe pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paymentType = PaymentType::findOrFail($id);

        $paymentType->delete();

        return redirect()->route('paymenttype')->with('success', 'Tipe pembayaran berhasil dihapus.');
    }
}
