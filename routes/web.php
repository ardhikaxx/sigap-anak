<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakController;
use App\Http\Controllers\Admin\PemeriksaanController;
use App\Http\Controllers\Admin\PosyanduController;
use App\Http\Controllers\Admin\KonsultasiController as AdminKonsultasiController;
use App\Http\Controllers\Admin\EdukasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\FaskesController;
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

        Route::get('posyandu', [PosyanduController::class, 'index'])->name('admin.posyandu.index');
        Route::get('posyandu/create', [PosyanduController::class, 'create'])->name('admin.posyandu.create');
        Route::post('posyandu', [PosyanduController::class, 'store'])->name('admin.posyandu.store');
        Route::get('posyandu/{jadwal}', [PosyanduController::class, 'show'])->name('admin.posyandu.show');
        Route::get('posyandu/{jadwal}/absensi', [PosyanduController::class, 'absensi'])->name('admin.posyandu.absensi');
        Route::post('posyandu/{jadwal}/absensi', [PosyanduController::class, 'updateAbsensi'])->name('admin.posyandu.updateAbsensi');
        Route::post('posyandu/{jadwal}/status', [PosyanduController::class, 'updateStatus'])->name('admin.posyandu.updateStatus');
        Route::delete('posyandu/{jadwal}', [PosyanduController::class, 'destroy'])->name('admin.posyandu.destroy');

        Route::get('konsultasi', [AdminKonsultasiController::class, 'index'])->name('admin.konsultasi.index');
        Route::get('konsultasi/{konsultasi}', [AdminKonsultasiController::class, 'show'])->name('admin.konsultasi.show');
        Route::put('konsultasi/{konsultasi}/status', [AdminKonsultasiController::class, 'updateStatus'])->name('admin.konsultasi.updateStatus');

        Route::resource('edukasi', EdukasiController::class)->names('admin.edukasi');
        Route::get('laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('laporan/export', [LaporanController::class, 'export'])->name('admin.laporan.export');

        Route::get('manajemen/users', [UserController::class, 'index'])->name('admin.manajemen.users');
        Route::get('manajemen/users/create', [UserController::class, 'create'])->name('admin.manajemen.users.create');
        Route::post('manajemen/users', [UserController::class, 'store'])->name('admin.manajemen.users.store');
        Route::get('manajemen/users/{user}', [UserController::class, 'show'])->name('admin.manajemen.users.show');
        Route::get('manajemen/users/{user}/edit', [UserController::class, 'edit'])->name('admin.manajemen.users.edit');
        Route::put('manajemen/users/{user}', [UserController::class, 'update'])->name('admin.manajemen.users.update');
        Route::delete('manajemen/users/{user}', [UserController::class, 'destroy'])->name('admin.manajemen.users.destroy');
        Route::post('manajemen/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('admin.manajemen.users.toggle');

        Route::get('manajemen/wilayah', [WilayahController::class, 'index'])->name('admin.manajemen.wilayah');
        Route::get('manajemen/wilayah/create', [WilayahController::class, 'create'])->name('admin.manajemen.wilayah.create');
        Route::post('manajemen/wilayah', [WilayahController::class, 'store'])->name('admin.manajemen.wilayah.store');
        Route::get('manajemen/wilayah/{wilayah}/edit', [WilayahController::class, 'edit'])->name('admin.manajemen.wilayah.edit');
        Route::put('manajemen/wilayah/{wilayah}', [WilayahController::class, 'update'])->name('admin.manajemen.wilayah.update');
        Route::delete('manajemen/wilayah/{wilayah}', [WilayahController::class, 'destroy'])->name('admin.manajemen.wilayah.destroy');

        Route::get('manajemen/faskes', [FaskesController::class, 'index'])->name('admin.manajemen.faskes');
        Route::get('manajemen/faskes/create', [FaskesController::class, 'create'])->name('admin.manajemen.faskes.create');
        Route::post('manajemen/faskes', [FaskesController::class, 'store'])->name('admin.manajemen.faskes.store');
        Route::get('manajemen/faskes/{faskes}', [FaskesController::class, 'show'])->name('admin.manajemen.faskes.show');
        Route::get('manajemen/faskes/{faskes}/edit', [FaskesController::class, 'edit'])->name('admin.manajemen.faskes.edit');
        Route::put('manajemen/faskes/{faskes}', [FaskesController::class, 'update'])->name('admin.manajemen.faskes.update');
        Route::delete('manajemen/faskes/{faskes}', [FaskesController::class, 'destroy'])->name('admin.manajemen.faskes.destroy');
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
