<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsahaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PesananController;
use App\Http\Middleware\CekLogin;
Route::get('/', [LandingPageController::class, 'index']);
Route::get('/listproduk', [LandingPageController::class, 'listproduk'])->name('listproduk');
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
     // chart
    Route::get('/getChartData', [DashboardController::class, 'getChartData'])->name('getChartData');
    Route::get('/chart/monthly', [DashboardController::class, 'getMonthlyChartData']);
});
// Super Admin
Route::middleware([CekLogin::class . ':superadmin'])->group(function () {
    // Kelola Data Super Admin
    Route::get('/datasuperadmin', [SuperadminController::class, 'getSuperAdmin'])->name('datasuperadmin');
    Route::get('/aktifkansuperadmin/{id}' , [SuperadminController::class, 'aktifkanSuperAdmin'])->name('aktifkansuperadmin');
    Route::post('/tambahsuperadmin' , [SuperadminController::class, 'store'])->name('tambahsuperadmin');
    Route::put('/updatesuperadmin/{id}' , [SuperadminController::class, 'update'])->name('updatesuperadmin');
    Route::delete('/hapussuperadmin/{id}' , [SuperadminController::class, 'destroy'])->name('hapussuperadmin');
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
    // Kelola Data Usaha
    Route::get('/datausaha', [UsahaController::class, 'index'])->name('datausaha');
    Route::post('/tambahusaha', [UsahaController::class, 'store'])->name('tambahusaha');
    Route::put('/updateusaha/{id}', [UsahaController::class, 'update'])->name('updateusaha');
    Route::delete('/hapususaha/{id}', [UsahaController::class, 'destroy'])->name('hapususaha');
});
Route::middleware([CekLogin::class . ':superadmin,admin'])->group(function () {
      // Kelola Data Produk
    Route::post('/tambahproduk', [ProdukController::class, 'store'])->name('tambahproduk');
    Route::put('/updateproduk/{id}', [ProdukController::class, 'update'])->name('updateproduk');
    Route::delete('/hapusproduk/{id}', [ProdukController::class, 'destroy'])->name('hapusproduk');
     // Kelola Data Karyawan
    Route::get('/datakaryawan', [KaryawanController::class, 'getKaryawan'])->name('datakaryawan');
    Route::get('/aktifkankaryawan/{id}' , [KaryawanController::class, 'aktifkanKaryawan'])->name('aktifkankaryawan');
    Route::post('/tambahkaryawan' , [KaryawanController::class, 'store'])->name('tambahKaryawan');
    Route::put('/updatekaryawan/{id}' , [KaryawanController::class, 'update'])->name('updateKaryawan');
    Route::delete('/hapuskaryawan/{id}' , [KaryawanController::class, 'destroy'])->name('hapusKaryawan');
});
Route::middleware([CekLogin::class . ':admin,karyawan'])->group(function () {
    // Kelola data transaksi
    Route::get('/datatransaksi', [TransaksiController::class, 'index'])->name('datatransaksi');
    // Route::get('/detailtransaksi/{id}', [TransaksiController::class, 'show'])->name('detailtransaksi');
    // Route::get('/tambahtransaksi', [TransaksiController::class, 'create'])->name('tambahtransaksi');
    // Route::post('/simpantransaksi', [TransaksiController::class, 'store'])->name('simpantransaksi');
    // Route::get('/edittransaksi/{id}', [TransaksiController::class, 'edit'])->name('edittransaksi');
    Route::put('/updatetransaksi/{id}', [TransaksiController::class, 'update'])->name('updatetransaksi');
    Route::delete('/hapustransaksi/{id}', [TransaksiController::class, 'destroy'])->name('hapustransaksi');
    // Konfirmasi Pembayaran
    Route::get('/datakonfirmasipembayaran', [TransaksiController::class, 'getKonfirmasiPembayaran'])->name('datakonfirmasipembayaran');
   

    // Konfirmasi pembayaran
    Route::post('/konfirmasipembayaran/{id}', [TransaksiController::class, 'konfirmasiPembayaran'])->name('konfirmasipembayaran');
    Route::post('/prosespesanan/{id}', [TransaksiController::class, 'prosesPesanan'])->name('prosespesanan');
    Route::post('/kirimpesanan/{id}', [TransaksiController::class, 'kirimPesanan'])->name('kirimpesanan');

});
Route::middleware([CekLogin::class .':pelanggan'])->group(function () {
    Route::get('/datapesanan', [PesananController::class, 'index'])->name('datapesanan');
    Route::get('/pesan', [PesananController::class, 'pesan'])->name('pesan');
    Route::post('checkout', [PesananController::class, 'checkout'])->name('checkout');
    // upload bukti bayar
    Route::post('/uploadbuktibayar/{id}', [PesananController::class, 'uploadBuktiBayar'])->name('uploadBuktiBayar');
    // Pesananditerima
     Route::post('/pesananditerima/{id}', [PesananController::class, 'pesananDiterima'])->name('pesananditerima');
    //  batalkan pesanan
     Route::get('/batalkanpesanan/{id}', [PesananController::class, 'batalkanPesanan'])->name('batalkanpesanan');  
    //  Rekap riwayat pembelian
    Route::get('rekapriwayatpembelian', [LaporanController::class, 'index'])->name('rekapriwayatpembelian');
      Route::get('eksporriwayatpembelian', [LaporanController::class, 'exportToPDF'])->name('eksporriwayatpembelian');
});
Route::middleware([CekLogin::class . ':superadmin,admin,karyawan'])->group(function () {
    // data produk
     // Data produk
    Route::get('/dataproduk', [ProdukController::class, 'index'])->name('dataproduk');

    // update status transaksi
    // Rekap Laporan Penjualan
    Route::get('rekaplaporanpenjualan', [LaporanController::class, 'index'])->name('rekaplaporanpenjualan');
    Route::get('eksporlaporanpenjualan', [LaporanController::class, 'exportToPDF'])->name('eksporlaporanpenjualan');
   
});