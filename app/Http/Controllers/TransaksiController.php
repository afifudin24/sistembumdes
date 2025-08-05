<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use App\Models\DetailTransaksi;
use App\Models\Usaha;
class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $role = session()->get('role');
       $user = session()->get('user');
       if($role == 'admin'){
        $usaha = Usaha::where('admin_id', $user->admin_id)->first();
       $transaksi = Transaksi::with([
    'usaha',
    'pelanggan',
    'detailTransaksi.produk' // relasi nested: produk di dalam detailTransaksi
])->where('usaha_id', $usaha->usaha_id)->paginate(10);

        return view('admin.transaksi.index', compact('transaksi'));
       }else if($role == 'karyawan'){
       
       $transaksi = Transaksi::with([
    'usaha',
    'pelanggan',
    'detailTransaksi.produk' // relasi nested: produk di dalam detailTransaksi
])->where('usaha_id', $user->usaha_id)->paginate(10);
 return view('karyawan.transaksi.index', compact('transaksi'));
       }
    }

    public function getKonfirmasiPembayaran()
{
       $role = session()->get('role');
       $user = session()->get('user');
       if($role == 'admin'){
        $usaha = Usaha::where('admin_id', $user->admin_id)->first();
       $transaksi = Transaksi::with([
    'usaha',
    'pelanggan',
    'detailTransaksi.produk' // relasi nested: produk di dalam detailTransaksi
])->where('usaha_id', $usaha->usaha_id)->where('metode_pembayaran', 'transfer')->where('status', 'menunggu konfirmasi')->paginate(10);

        return view('admin.konfirmasipembayaran.index', compact('transaksi'));
       } else if($role == 'karyawan'){
               $transaksi = Transaksi::with([
    'usaha',
    'pelanggan',
    'detailTransaksi.produk' // relasi nested: produk di dalam detailTransaksi
])->where('usaha_id', $user->usaha_id)->where('metode_pembayaran', 'transfer')->where('status', 'menunggu konfirmasi')->paginate(10);

        return view('karyawan.konfirmasipembayaran.index', compact('transaksi'));
       }else{
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah produk.');
       }
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
