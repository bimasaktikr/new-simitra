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
use Illuminate\Support\Facades\Auth;

// Route Utama
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Route Dashboard dengan Middleware Otentikasi dan Verifikasi Email
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);

// Grouping Route dengan Middleware Auth
Route::middleware('auth')->group(function () {

    // Routing dari Breeze untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Bantuan
    Route::get('/bantuan', [DashboardController::class, 'bantuan'])->name('bantuan');

    // Route Survei
    Route::get('/survei', [SurveyController::class, 'index'])->name('survei');
    Route::get('/survei/add', [SurveyController::class, 'add'])->name('addsurvei');
    Route::post('/survei/add', [SurveyController::class, 'store'])->name('survei.store');
    Route::get('/survei/{id}', [SurveyController::class, 'show'])->name('surveidetail');
    Route::get('/survei/penilaian', [PenilaianController::class, 'index'])->name('penilaian');
    Route::get('/survei/{id}/edit', [SurveyController::class, 'edit'])->name('editsurvei');
    Route::put('/survei/{id}', [SurveyController::class, 'update'])->name('editsurvei.update');

    // Route Mitra
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra');
    Route::get('/mitra/add', [MitraController::class, 'add'])->name('addmitra');
    Route::post('/mitra/add', [MitraController::class, 'store'])->name('mitra.store');
    Route::get('/mitra/edit', [MitraController::class, 'edit'])->name('editmitra');
    Route::post('/mitra/edit', [MitraController::class, 'store'])->name('editmitra.store');
    Route::get('/mitra/{id}', [MitraController::class, 'show'])->name('mitradetail');

    // Route Pegawai
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/pegawai/add', [PegawaiController::class, 'add'])->name('addpegawai');
    Route::post('/pegawai/add', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/edit', [PegawaiController::class, 'edit'])->name('editpegawai');
    Route::post('/pegawai/edit', [PegawaiController::class, 'store'])->name('editpegawai.store');
    Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawaidetail');

    // Route Mitra Teladan
    Route::get('/mitrateladan', [MitraTeladanController::class, 'index'])->name('mitrateladan');

    // Route Logout
    Route::post('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');
});

// Route Otentikasi
require __DIR__.'/auth.php';
