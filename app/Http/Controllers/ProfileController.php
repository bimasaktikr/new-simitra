<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $userData = session('user_data');
        $role_id = Auth::user()->role_id;
        return view('profile', compact('userData', 'role_id'));
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password berhasil diubah.');
    }
}
