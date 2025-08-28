<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\DataKategoriController;
use App\Http\Controllers\DataKontenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// ==============================
// Landing Page
// ==============================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==============================
// Auth Routes
// ==============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// ==============================
// Dashboard
// ==============================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// ==============================
// Profile
// ==============================
Route::put('/profile/update', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

// ==============================
// Admin & User Dashboard
// ==============================
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard'); // ✅ diganti jadi dashboard.blade.php
    })->name('user.dashboard');
});

// ==============================
// Resource Routes
// ==============================
Route::resource('users', UserController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('konten', KontenController::class);

// ==============================
// Data Kategori & Data Konten
// ==============================
Route::get('/data-kategori', [DataKategoriController::class, 'index'])->name('data.kategori');
Route::get('/data-konten', [DataKontenController::class, 'index'])->name('data.konten');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::get('/data-konten', [DataKontenController::class, 'index'])->name('data.konten');


// Route untuk kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');


Route::get('/konten', [KontenController::class, 'index'])->name('konten.index');
Route::get('/konten/{id}', [KontenController::class, 'show'])->name('konten.show');
Route::get('/konten/{id}/edit', [KontenController::class, 'edit'])->name('konten.edit');
Route::put('/konten/{id}', [KontenController::class, 'update'])->name('konten.update');
Route::delete('/konten/{id}', [KontenController::class, 'destroy'])->name('konten.destroy');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('data-konten', [App\Http\Controllers\Admin\KontenController::class, 'index'])->name('data-konten');
});


Route::post('/konten/{konten}/toggle-publish', [KontenController::class, 'togglePublish'])->name('konten.toggle-publish');
Route::get('/konten', [KontenController::class, 'index'])->name('konten.index');
Route::get('/konten/create', [KontenController::class, 'create'])->name('konten.create');
Route::post('/konten', [KontenController::class, 'store'])->name('konten.store');

Route::resource('konten', KontenController::class);
Route::resource('kategoris', KategoriController::class);
