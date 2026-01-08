<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController; // <-- Jangan lupa panggil ini
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// GROUP DASHBOARD (Bisa diakses Admin & Petugas)
Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    
    // --- AREA BEBAS (ADMIN & PETUGAS) ---
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Absensi (Baca & Input & Edit boleh semua)
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/input', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/simpan', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    
    // Siswa (Baca & Tambah & Edit boleh semua)
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/simpan', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- AREA KHUSUS ADMIN (Hanya Role 'admin') ---
    Route::middleware(['role:admin'])->group(function () {
        
        // 1. Menu Pengguna (Full Akses Admin Only)
        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/tambah', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('/pengguna/simpan', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna/{id}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
        Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

        // 2. Hapus Data (Admin Only)
        // Petugas tidak boleh menghapus data siswa/absensi
        Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

    });

});
require __DIR__.'/auth.php';