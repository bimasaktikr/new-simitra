<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Session;
use Illuminate\Support\Facades\Session;
// use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }else{
            return view('login');
        }
    }

    public function actionlogin(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $mitra = DB::table('mitras')->where('email', $user->email)->first();
            $employee = Employee::where('user_id', $user->id)->first();

            // dd($employee);

            // Simpan data ke dalam session berdasarkan role
            if ($user->role_id == '4' && $mitra) {
                Session::put('user_data', $mitra);
            } elseif ($user->role_id != '4' && $employee) {
                Session::put('user_data', $employee);
            } else {
                Session::put('user_data', $employee);
                // Ambil team name berdasarkan team_id dari tabel employees
                // $team = DB::table('teams')->where('id', $employee->team_id)->first();

                // // Convert $employee (object) menjadi array
                // $employeeData = (array) $employee;

                // // Tambahkan team_name ke dalam array
                // $employeeData['team_name'] = $team ? $team->name : null;

                // // Simpan data ke dalam session
                // Session::put('user_data', (object)$employeeData);
            }

            return redirect('/dashboard');
        } else {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}