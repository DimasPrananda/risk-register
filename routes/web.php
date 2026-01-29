<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeriodeController;
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
    Route::post('/admin/pengaturan-user', [UserController::class, 'store'])->name('user.store');
    Route::put('/admin/pengaturan-user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/admin/pengaturan-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
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
    // Pilih periode
    Route::get('/admin/risk-register', [RiskRegisterController::class, 'pilihPeriode'])
        ->name('risk.pilih-periode');

    Route::post('/admin/risk-register', [RiskRegisterController::class, 'submitPeriode'])
        ->name('risk.submit-periode');

    // Sasaran / KPI
    Route::get('/admin/risk-register/periode/{periode}', [RiskRegisterController::class, 'sasaran'])
        ->name('risk.sasaran');
    Route::post('/admin/risk-register/sasaran', [RiskRegisterController::class, 'createSasaran'])
        ->name('risk.sasaran.store');
    Route::put('/admin/risk-register/sasaran/{sasaran}', [RiskRegisterController::class, 'updateSasaran'])
        ->name('risk.sasaran.update');
    Route::delete('/admin/risk-register/sasaran/{sasaran}', [RiskRegisterController::class, 'deleteSasaran'])
        ->name('risk.sasaran.destroy');

    // Detail Risiko
    Route::get('/admin/risk-register/sasaran/{sasaran}', [RiskRegisterController::class, 'detail'])
        ->name('risk.detail');
    Route::post('/admin/risk-register/sebab-risiko/{sasaran}', [RiskRegisterController::class, 'createSebabRisiko'])
        ->name('risk.detail.store');
    Route::put('/admin/risk-register/sebab-risiko/{sasaran}', [RiskRegisterController::class, 'updateSebabRisiko'])
        ->name('risk.detail.update');
    Route::delete('/admin/risk-register/sebab-risiko/{sasaran}', [RiskRegisterController::class, 'deleteSebabRisiko'])
        ->name('risk.detail.destroy');

    // Perlakuan Risiko
    Route::post('/admin/risk-register/perlakuan-risiko/{sebab_risiko}', [RiskRegisterController::class, 'createPerlakuanRisiko'])
        ->name('risk.perlakuan-risiko.store');
    Route::put('/admin/risk-register/perlakuan-risiko/{sebab_risiko}', [RiskRegisterController::class, 'updatePerlakuanRisiko'])
        ->name('risk.perlakuan-risiko.update');
    Route::delete('/admin/risk-register/perlakuan-risiko/{sebab_risiko}', [RiskRegisterController::class, 'deletePerlakuanRisiko'])
        ->name('risk.perlakuan-risiko.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/periode', [PeriodeController::class, 'create'])->name('admin.periode');
    Route::post('/admin/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::put('/admin/periode/{periode}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/admin/periode/{periode}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
});