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

Route::get('/', [LoginController::class, 'login'])->name('login');
use App\Http\Controllers\MitraTeladan;
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/bantuan', [DashboardController::class, 'bantuan'])->name('bantuan')->middleware('auth');
Route::post('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('/survei', [SurveyController::class, 'index'])->name('survei')->middleware('auth');
Route::get('/survei/add', [SurveyController::class, 'add'])->name('addsurvei')->middleware('auth');
Route::post('/survei/add', [SurveyController::class, 'store'])->name('survei.store');
Route::get('/survei/{id}', [SurveyController::class, 'show'])->name('surveidetail')->middleware('auth');
Route::get('/survei/penilaian', [PenilaianController::class, 'index'])->name('penilaian')->middleware('auth');
Route::get('/survei/{id}/edit', [SurveyController::class, 'edit'])->name('editsurvei');
Route::put('/survei/{id}', [SurveyController::class, 'update'])->name('editsurvei.update');


Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');

Route::get('/mitra', [MitraController::class, 'index'])->name('mitra')->middleware('auth');
Route::get('/mitra/add', [MitraController::class, 'add'])->name('addmitra')->middleware('auth');
Route::post('/mitra/add', [MitraController::class, 'store'])->name('mitra.store');
Route::get('/mitra/edit', [MitraController::class, 'edit'])->name('editmitra')->middleware('auth');
Route::post('/mitra/edit', [MitraController::class, 'store'])->name('editmitra.store');
Route::get('/mitra/{id}', [MitraController::class, 'show'])->name('mitradetail')->middleware('auth');

Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai')->middleware('auth');
Route::get('/pegawai/add', [PegawaiController::class, 'add'])->name('addpegawai')->middleware('auth');
Route::post('/pegawai/add', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/edit', [PegawaiController::class, 'edit'])->name('editpegawai')->middleware('auth');
Route::post('/pegawai/edit', [PegawaiController::class, 'store'])->name('editpegawai.store');
Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawaidetail')->middleware('auth');

//Route::get('/mitrateladan', [MitraController::class, 'index'])->name('mitra')->middleware('auth');
Route::get('/mitrateladan', [MitraTeladan::class, 'index'])->name('mitrateladan')->middleware('auth');