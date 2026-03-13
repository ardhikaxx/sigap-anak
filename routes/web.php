<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakController;
use App\Http\Controllers\Admin\PemeriksaanController;
use App\Http\Controllers\Mobile\HomeController;
use App\Http\Controllers\Mobile\AnakController as MobileAnakController;
use App\Http\Controllers\Mobile\GrafikController;
use App\Http\Controllers\Mobile\KonsultasiController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::resource('anak', AnakController::class)->names('admin.anak');
        Route::get('pemeriksaan', [PemeriksaanController::class, 'index'])->name('admin.pemeriksaan.index');
        Route::get('pemeriksaan/create', [PemeriksaanController::class, 'create'])->name('admin.pemeriksaan.create');
        Route::post('pemeriksaan', [PemeriksaanController::class, 'store'])->name('admin.pemeriksaan.store');
        Route::get('pemeriksaan/{pemeriksaan}', [PemeriksaanController::class, 'show'])->name('admin.pemeriksaan.show');
        Route::delete('pemeriksaan/{pemeriksaan}', [PemeriksaanController::class, 'destroy'])->name('admin.pemeriksaan.destroy');
    });

    Route::prefix('mobile')->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('mobile.home');
        
        Route::get('anak', [MobileAnakController::class, 'index'])->name('mobile.anak.index');
        Route::get('anak/{anak}', [MobileAnakController::class, 'show'])->name('mobile.anak.show');
        
        Route::get('grafik', [GrafikController::class, 'index'])->name('mobile.grafik.index');
        
        Route::get('konsultasi', [KonsultasiController::class, 'index'])->name('mobile.konsultasi.index');
        Route::get('konsultasi/create', [KonsultasiController::class, 'create'])->name('mobile.konsultasi.create');
        Route::post('konsultasi', [KonsultasiController::class, 'store'])->name('mobile.konsultasi.store');
        Route::get('konsultasi/{konsultasi}', [KonsultasiController::class, 'show'])->name('mobile.konsultasi.show');
        Route::post('konsultasi/{konsultasi}/message', [KonsultasiController::class, 'sendMessage'])->name('mobile.konsultasi.message');
    });
});
