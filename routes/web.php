<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import Semua Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN UTAMA (LANDING PAGE) ---
// Sekarang buka web langsung ke Landing Page, bukan redirect ke Login
Route::get('/', [LandingController::class, 'index'])->name('home');

// --- ROUTE GUEST (Hanya bisa diakses jika BELUM login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // ROUTE REGISTER BARU
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// --- ROUTE AUTH (Harus Login) ---
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- FITUR PROFIL (Bisa diakses Admin & Pelanggan) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- GROUP ROUTE ADMIN ---
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard Utama
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // CRUD LAYANAN
        Route::resource('layanan', LayananController::class);

        // Fitur Operasional (Detail, Status, Bayar, Struk, Label, Laporan)
        Route::get('/pesanan/{id}', [AdminController::class, 'show'])->name('pesanan.show');
        Route::patch('/pesanan/{id}/update', [AdminController::class, 'updateStatus'])->name('pesanan.update');
        Route::get('/pesanan/{id}/bayar', [AdminController::class, 'formBayar'])->name('pesanan.bayar');
        Route::post('/pesanan/{id}/bayar', [AdminController::class, 'processBayar'])->name('pesanan.bayar.process');
        Route::get('/pesanan/{id}/struk', [AdminController::class, 'cetakStruk'])->name('pesanan.struk');
        Route::get('/pesanan/{id}/label', [AdminController::class, 'cetakLabel'])->name('pesanan.label');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    });

    // --- GROUP ROUTE PELANGGAN ---
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/dashboard', [PemesananController::class, 'index'])->name('dashboard');
        Route::get('/pesan', [PemesananController::class, 'create'])->name('pesan');
        Route::post('/pesan', [PemesananController::class, 'store'])->name('pesan.store');
    });
});