<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\DataKategoriController;

// ==============================
// Landing Page
// ==============================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==============================
// Auth Routes
// ==============================

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// ==============================
// Dashboard (Hanya setelah login)
// ==============================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// ==============================
// Profile (Update hanya jika login)
// ==============================
Route::put('/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

// ==============================
// Kategori & Konten
// ==============================

// Tampilkan halaman kategori & konten
Route::get('/kategori', [KategoriController::class, 'index'])
    ->middleware('auth')
    ->name('kategori');

// Simpan kategori baru
Route::post('/kategori', [KategoriController::class, 'store'])
    ->middleware('auth')
    ->name('kategori.store');

// Simpan konten baru
Route::post('/konten', [KontenController::class, 'store'])
    ->middleware('auth')
    ->name('konten.store');

// Tampilkan data kategori (misal untuk admin view)


Route::get('/data-kategori', [DataKategoriController::class, 'index'])->name('data.kategori');


// ==============================
// Konten Edit, Update, Delete
// ==============================

// Tampilkan form edit konten
Route::get('/konten/{id}/edit', [KontenController::class, 'edit'])
    ->middleware('auth')
    ->name('konten.edit');

// Update konten
Route::put('/konten/{id}', [KontenController::class, 'update'])
    ->middleware('auth')
    ->name('konten.update');

// Hapus konten
Route::delete('/konten/{id}', [KontenController::class, 'destroy'])
    ->middleware('auth')
    ->name('konten.destroy');
