<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PeristiwaRisikoController;
use App\Http\Controllers\PerlakuanRisikoKomentarController;
use App\Http\Controllers\TaksonomiController;
use App\Http\Controllers\UserRiskRegisterController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard/{departemenId?}', [DashboardController::class, 'admin'])->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('user/dashboard/{departemenId?}', [DashboardController::class, 'user'])->middleware(['auth'])->name('user.dashboard');

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

    Route::get('/get-risiko/{taksonomi}', [RiskRegisterController::class, 'getRisiko']);
    Route::get('/get-parameter/{risiko}', [RiskRegisterController::class, 'getParameter']);

    // Publish/Unpublish Sasaran
    Route::post('/admin/sasaran/{id}/publish', [RiskRegisterController::class, 'publish'])
        ->name('sasaran.publish');

    Route::post('/admin/sasaran/{id}/unpublish', [RiskRegisterController::class, 'unpublish'])
        ->name('sasaran.unpublish');

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

    Route::post('/risk/perlakuan-risiko/{id}/realisasi', [RiskRegisterController::class, 'updateRealisasi'])
        ->name('risk.perlakuan-risiko.realisasi');

    // Komentar Perlakuan Risiko
    Route::post('/admin/risk-register/komentar/{perlakuan_risiko}', [PerlakuanRisikoKomentarController::class, 'store'])
        ->name('risk.komentar.store');
    Route::delete('/admin/risk-register/komentar/{komentar}', [PerlakuanRisikoKomentarController::class, 'destroy'])
        ->name('risk.komentar.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Pilih periode
    Route::get('/risk-register', [UserRiskRegisterController::class, 'pilihPeriode'])
        ->name('user.pilih-periode');

    Route::post('/risk-register', [UserRiskRegisterController::class, 'submitPeriode'])
        ->name('user.submit-periode');

    // Sasaran / KPI
    Route::get('/risk-register/periode/{periode}', [UserRiskRegisterController::class, 'sasaran'])
        ->name('user.sasaran');
    Route::post('/risk-register/sasaran', [UserRiskRegisterController::class, 'createSasaran'])
        ->name('user.sasaran.store');
    Route::put('/risk-register/sasaran/{sasaran}', [UserRiskRegisterController::class, 'updateSasaran'])
        ->name('user.sasaran.update');
    Route::delete('/risk-register/sasaran/{sasaran}', [UserRiskRegisterController::class, 'deleteSasaran'])
        ->name('user.sasaran.destroy');
    

    Route::get('/risk-register/sasaran/{sasaran}', [UserRiskRegisterController::class, 'detail'])
        ->name('user.detail');
    Route::post('/risk-register/sebab-risiko/{sasaran}', [UserRiskRegisterController::class, 'createSebabRisiko'])
        ->name('user.detail.store');
    Route::put('/risk-register/sebab-risiko/{sasaran}', [UserRiskRegisterController::class, 'updateSebabRisiko'])
        ->name('user.detail.update');
    Route::delete('/risk-register/sebab-risiko/{sasaran}', [UserRiskRegisterController::class, 'deleteSebabRisiko'])
        ->name('user.detail.destroy');

    Route::post('/risk-register/perlakuan-risiko/{sebab_risiko}', [UserRiskRegisterController::class, 'createPerlakuanRisiko'])
        ->name('user.detail.perlakuan-risiko.store');
    Route::put('/risk-register/perlakuan-risiko/{sebab_risiko}', [UserRiskRegisterController::class, 'updatePerlakuanRisiko'])
        ->name('user.detail.perlakuan-risiko.update');
    Route::delete('/risk-register/perlakuan-risiko/{sebab_risiko}', [UserRiskRegisterController::class, 'deletePerlakuanRisiko'])
        ->name('user.perlakuan-risiko.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/periode', [PeriodeController::class, 'create'])->name('admin.periode');
    Route::post('/admin/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::put('/admin/periode/{periode}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/admin/periode/{periode}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
});

Route::get('/notification/read-single/{id}', function ($id) {
    $notif = auth()->user()
        ->unreadNotifications()
        ->find($id);

    if ($notif) {
        $notif->markAsRead();
    }

    return response()->noContent();
})->name('notif.readSingle');

Route::post('/pengumuman', [PengumumanController::class, 'store'])
    ->name('pengumuman.store');
Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])
    ->name('pengumuman.destroy');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/taksonomi', [TaksonomiController::class, 'index'])->name('admin.taksonomi');
    Route::post('/admin/taksonomi', [TaksonomiController::class, 'store'])->name('taksonomi.store');
    Route::put('/admin/taksonomi/{taksonomi}', [TaksonomiController::class, 'update'])->name('taksonomi.update');
    Route::delete('/admin/taksonomi/{taksonomi}', [TaksonomiController::class, 'destroy'])->name('taksonomi.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/peristiwa-risiko', [PeristiwaRisikoController::class, 'store'])->name('peristiwa-risiko.store');
    Route::put('/admin/peristiwa-risiko/{peristiwaRisiko}', [PeristiwaRisikoController::class, 'update'])->name('peristiwa-risiko.update');
    Route::delete('/admin/peristiwa-risiko/{peristiwaRisiko}', [PeristiwaRisikoController::class, 'destroy'])->name('peristiwa-risiko.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/parameter', [ParameterController::class, 'store'])->name('parameter.store');
    Route::put('/admin/parameter/{parameter}', [ParameterController::class, 'update'])->name('parameter.update');
    Route::delete('/admin/parameter/{parameter}', [ParameterController::class, 'destroy'])->name('parameter.destroy');
});