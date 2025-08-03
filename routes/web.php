<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsahaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;

use App\Http\Middleware\CekLogin;

Route::get('/', [LandingPageController::class, 'index']);


// auth
Route::get('/login', function () {
    if (session('login') === true) {
        return redirect('/dashboard');
    }
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

// Super Admin
Route::middleware([CekLogin::class . ':superadmin'])->group(function () {


    // Kelola Data Super Admin
    Route::get('/datasuperadmin', [SuperAdminController::class, 'getSuperAdmin'])->name('datasuperadmin');
    Route::get('/aktifkansuperadmin/{id}' , [SuperAdminController::class, 'aktifkanSuperAdmin'])->name('aktifkansuperadmin');
    Route::post('/tambahsuperadmin' , [SuperAdminController::class, 'store'])->name('tambahsuperadmin');
    Route::put('/updatesuperadmin/{id}' , [SuperAdminController::class, 'update'])->name('updatesuperadmin');
    Route::delete('/hapussuperadmin/{id}' , [SuperAdminController::class, 'destroy'])->name('hapussuperadmin');
    // Kelola Data Admin
    Route::get('/dataadmin', [AdminController::class, 'getAdmin'])->name('dataadmin');
    Route::get('/aktifkanadmin/{id}' , [AdminController::class, 'aktifkanAdmin'])->name('aktifkanadmin');
    Route::post('/tambahadmin' , [AdminController::class, 'store'])->name('tambahadmin');
    Route::put('/updateadmin/{id}' , [AdminController::class, 'update'])->name('updateadmin');
    Route::delete('/hapusadmin/{id}' , [AdminController::class, 'destroy'])->name('hapusadmin');

    // Kelola Data Pelanggan
    Route::get('/datapelanggan', [PelangganController::class, 'getPelanggan'])->name('datapelanggan');
    Route::get('/aktifkanpelanggan/{id}' , [PelangganController::class, 'aktifkanPelanggan'])->name('aktifkanpelanggan');
    Route::post('/tambahpelanggan' , [PelangganController::class, 'store'])->name('tambahpelanggan');
    Route::put('/updatepelanggan/{id}' , [PelangganController::class, 'update'])->name('updatepelanggan');
    Route::delete('/hapuspelanggan/{id}' , [PelangganController::class, 'destroy'])->name('hapuspelanggan');

    // Kelola Data Karyawan
    Route::get('/datakaryawan', [KaryawanController::class, 'getKaryawan'])->name('datakaryawan');
    Route::get('/aktifkankaryawan/{id}' , [KaryawanController::class, 'aktifkanKaryawan'])->name('aktifkankaryawan');
    Route::post('/tambahkaryawan' , [KaryawanController::class, 'store'])->name('tambahKaryawan');
    Route::put('/updatekaryawan/{id}' , [KaryawanController::class, 'update'])->name('updateKaryawan');
    Route::delete('/hapuskaryawan/{id}' , [KaryawanController::class, 'destroy'])->name('hapusKaryawan');

    // Kelola Data Usaha
    Route::get('/datausaha', [UsahaController::class, 'index'])->name('datausaha');
    Route::post('/tambahusaha', [UsahaController::class, 'store'])->name('tambahusaha');
    Route::put('/updateusaha/{id}', [UsahaController::class, 'update'])->name('updateusaha');
    Route::delete('/hapususaha/{id}', [UsahaController::class, 'destroy'])->name('hapususaha');



});

Route::middleware([CekLogin::class . ':superadmin, admin'])->group(function () {
    // chart
    Route::get('/getChartData', [DashboardController::class, 'getChartData'])->name('getChartData');
    Route::get('/chart/monthly', [DashboardController::class, 'getMonthlyChartData']);

      // Kelola Data Produk
    Route::get('/dataproduk', [ProdukController::class, 'index'])->name('dataproduk');
    Route::post('/tambahproduk', [ProdukController::class, 'store'])->name('tambahproduk');
    Route::put('/updateproduk/{id}', [ProdukController::class, 'update'])->name('updateproduk');
    Route::delete('/hapusproduk/{id}', [ProdukController::class, 'destroy'])->name('hapusproduk');

    // Rekap Laporan Penjualan
    Route::get('rekaplaporanpenjualan', [LaporanController::class, 'index'])->name('rekaplaporanpenjualan');
    Route::get('eksporlaporanpenjualan', [LaporanController::class, 'exportToPDF'])->name('eksporlaporanpenjualan');

});
