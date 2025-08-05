<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaksi;
use App\Models\Usaha;
use App\Models\Produk;
use Carbon\Carbon;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PesananController extends Controller
{
    public function index(){
        $user = session()->get('user');
        $transaksi = Transaksi::where('pelanggan_id', $user->pelanggan_id)->with('usaha')->with('pelanggan')->with('detailTransaksi.produk')->paginate(10);
        return view('pelanggan.pesanan.index', compact('transaksi'));
    }

 public function pesan(Request $request)
{
    $usaha = Usaha::all();

    if ($request->has('usaha_id') && $request->usaha_id != '') {
        $produk = Produk::where('usaha_id', $request->usaha_id)->paginate(10);
    } else {
        $produk = Produk::paginate(10);
    }

    return view('pelanggan.pesan.index', compact('produk', 'usaha'));
}

public function checkout(Request $request)
{
    $cart = $request->cart;
    $paymentMethod = $request->metode_pembayaran;
    $keterangan = $request->keterangan;

    if (empty($cart)) {
        return response()->json(['message' => 'Keranjang kosong'], 400);
    }

    $grouped = [];

    // Pisahkan berdasarkan usaha_id
    foreach ($cart as $item) {
        $produk = Produk::find($item['id']);
        if (!$produk) continue;

        $usahaId = $produk->usaha_id;

        if (!isset($grouped[$usahaId])) {
            $grouped[$usahaId] = [];
        }

        $grouped[$usahaId][] = [
            'produk' => $produk,
            'qty' => $item['qty'],
            'harga' => $produk->harga
        ];
    }

    DB::beginTransaction();
    try {
        foreach ($grouped as $usahaId => $items) {
            $total = 0;

            foreach ($items as $i) {
                $total += $i['qty'] * $i['harga'];
            }

            $transaksiId = now()->format('YmdHis') . rand(100, 999); // angka bigint unik

            $transaksi = Transaksi::create([
                'transaksi_id' => $transaksiId,
                'tanggal' => now(),
                'total_harga' => $total,
                'usaha_id' => $usahaId,
                'metode_pembayaran' => $paymentMethod,
                'pelanggan_id' => session()->get('user')->pelanggan_id, // pastikan user login
                'status' => $paymentMethod === 'Transfer' ? 'perlu bayar' : 'antrian',
                'keterangan' => $keterangan
            ]);

            foreach ($items as $i) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'produk_id' => $i['produk']->produk_id,
                    'kuantitas' => $i['qty'],
                    'harga_satuan' => $i['harga'],
                    'subtotal' => $i['harga'] * $i['qty'],
                ]);
            }
        }

        DB::commit();
        return response()->json(['message' => 'Checkout berhasil']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Checkout gagal', 'error' => $e->getMessage()], 500);
    }
}
}
