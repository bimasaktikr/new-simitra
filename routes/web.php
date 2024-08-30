<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\MitraTeladanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TransactionController;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/bantuan', [DashboardController::class, 'bantuan'])->name('bantuan')->middleware('auth');
Route::post('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('/survei', [SurveyController::class, 'index'])->name('survei')->middleware('auth');
Route::get('/survei/add', [SurveyController::class, 'add'])->name('addsurvei')->middleware('auth');
Route::post('/survei/store', [SurveyController::class, 'store'])->name('survei.store');
Route::get('/survei/{id}', [SurveyController::class, 'show'])->name('surveidetail')->middleware('auth');
Route::get('/survei/{id}/edit', [SurveyController::class, 'edit'])->name('editsurvei');
Route::put('/survei/{id}', [SurveyController::class, 'update'])->name('editsurvei.update');
Route::post('/survei/{id}/sync', [SurveyController::class, 'sync'])->name('survei.sync')->middleware('auth');
Route::delete('/surveys/{id}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
Route::get('/surveys/search', [SurveyController::class, 'search'])->name('surveys.search');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');

Route::get('/mitra', [MitraController::class, 'index'])->name('mitra')->middleware('auth');
Route::get('/mitra/add', [MitraController::class, 'add'])->name('addmitra')->middleware('auth');
Route::post('/mitra/add', [MitraController::class, 'store'])->name('mitra.store');
Route::get('/mitra/edit/{id_sobat}', [MitraController::class, 'edit'])->name('editmitra')->middleware('auth');
Route::put('/mitra/edit/{id_sobat}', [MitraController::class, 'update'])->name('editmitra.update');
Route::get('/mitra/{id_sobat}', [MitraController::class, 'show'])->name('mitradetail')->middleware('auth');
Route::delete('/mitra/{id_sobat}', [MitraController::class, 'destroy'])->name('mitra.destroy');
Route::get('/mitras/search', [MitraController::class, 'search'])->name('mitra.search');

Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai')->middleware('auth');
Route::get('/pegawai/add', [PegawaiController::class, 'add'])->name('addpegawai')->middleware('auth');
Route::post('/pegawai/add', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('editpegawai')->middleware('auth');
Route::put('/pegawai/edit/{id}', [PegawaiController::class, 'update'])->name('editpegawai.update');
Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawaidetail')->middleware('auth');
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
Route::get('/employee/search', [PegawaiController::class, 'search'])->name('pegawai.search');

Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('auth');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('edituser');
Route::put('/user/{id}', [UserController::class, 'update'])->name('edituser.update');
Route::delete('/user/{email}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

Route::get('/team', [TeamController::class, 'index'])->name('team')->middleware('auth');
// Route::get('/mitra/{id_sobat}', [MitraController::class, 'show'])->name('mitradetail')->middleware('auth');
Route::get('/teams/search', [TeamController::class, 'search'])->name('team.search');

Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction')->middleware('auth');
// Route::get('/mitra/{id_sobat}', [MitraController::class, 'show'])->name('mitradetail')->middleware('auth');
Route::get('/transactions/search', [TransactionController::class, 'search'])->name('transaction.search');

Route::get('/penilaian/{transaction_id}/create', [PenilaianController::class, 'create'])->name('penilaian.create')->middleware('auth');
Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store')->middleware('auth');

Route::get('/mitrateladan', [MitraTeladanController::class, 'index'])->name('mitrateladan')->middleware('auth');