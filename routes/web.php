<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\CekLogin;

Route::get('/', [LandingPageController::class, 'index']);


// auth
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Perlu Login
Route::middleware([CekLogin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route::get('/profil', [UserController::class, 'profil'])->name('profil');
});

// super admin
Route::middleware([CekLogin::class . ':superadmin, admin'])->group(function () {
    Route::get('/getChartData', [DashboardController::class, 'getChartData'])->name('getChartData');
    Route::get('/chart/monthly', [DashboardController::class, 'getMonthlyChartData']);

    // Kelola Data Admin
    Route::get('/datasuperadmin', [SuperAdminController::class, 'getSuperAdmin'])->name('datasuperadmin');

    // Kelola Data Admin
    Route::get('/dataadmin', [AdminController::class, 'getAdmin'])->name('dataadmin');

    // Kelola Data Pelanggan
    Route::get('/datapelanggan', [PelangganController::class, 'getPelanggan'])->name('datapelanggan');

    // Kelola Data Karyawan
    Route::get('/datakaryawan', [KaryawanController::class, 'getKaryawan'])->name('datakaryawan');

});