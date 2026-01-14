<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [DashboardController::class, 'admin'])->middleware(['auth', 'admin'])->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pengaturan-user', [UserController::class, 'index'])->name('admin.user');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pengaturan-departemen', [DepartemenController::class, 'index'])->name('admin.departemen');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pengaturan-departemen', [DepartemenController::class, 'index'])->name('admin.departemen');
    Route::post('/admin/pengaturan-departemen', [DepartemenController::class, 'store'])->name('departemen.store');
    Route::put('/admin/pengaturan-departemen/{departemen}', [DepartemenController::class, 'update'])->name('departemen.update');
    Route::delete('/admin/pengaturan-departemen/{departemen}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pengaturan-kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::post('/admin/pengaturan-kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/admin/pengaturan-kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/admin/pengaturan-kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/risk-register', [RiskRegisterController::class, 'index'])->name('admin.risk-register');
});