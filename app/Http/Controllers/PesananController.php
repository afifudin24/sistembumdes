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
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
class PesananController extends Controller
{
    /**
     * Display a list of transactions for the current user.
     *
     * Retrieves the logged-in user's transactions, including related data
     * such as the associated business, customer, and detailed transaction
     * products. The transactions are paginated for display in the view.
     *
     * @return \Illuminate\View\View
     */
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
             $transaksiId = now()->format('ymd') . rand(10, 99); // Contoh:
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
        $details = DetailTransaksi::with('produk')
    ->where('transaksi_id', $transaksi->transaksi_id)
    ->get();

$pdf = Pdf::loadView('pelanggan.pesan.invoice', [
    'transaksi' => $transaksi,
    'details' => $details
]);

$filename = 'transaksi_' . $transaksi->transaksi_id . '.pdf';
Storage::put('invoices/' . $filename, $pdf->output());
    DB::commit();
        return response()->json(['message' => 'Checkout berhasil']);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Checkout gagal', 'error' => $e->getMessage()], 500);
    }
}
public function uploadBuktiBayar(Request $request, $id)
{
    $transaksi = Transaksi::find($id);
    // Cek apakah transaksi milik pelanggan yang sedang login
    if (!$transaksi || $transaksi->pelanggan_id !== session()->get('user')->pelanggan_id) {
        return redirect()->route('datapesanan')->with('error', 'Transaksi tidak ditemukan');
    }
    // Validasi bukti bayar
    $request->validate([
        'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
        'bukti_bayar.required' => 'Bukti bayar wajib diunggah.',
        'bukti_bayar.image'    => 'File yang diunggah harus berupa gambar.',
        'bukti_bayar.mimes'    => 'Bukti bayar harus berupa file dengan format jpeg, png, jpg, atau gif.',
        'bukti_bayar.max'      => 'Ukuran bukti bayar maksimal 2MB.',
    ]);
    // Hapus foto sebelumnya jika ada
    if ($transaksi->bukti_bayar && Storage::disk('public')->exists($transaksi->bukti_bayar)) {
        Storage::disk('public')->delete($transaksi->bukti_bayar);
    }
    // Simpan foto baru
    $buktiBaru = $request->file('bukti_bayar');
    $buktiBaruPath = $buktiBaru->store('bukti_bayar', 'public');
    // Update data transaksi
    $transaksi->bukti_bayar = $buktiBaruPath;
    $transaksi->status = 'menunggu konfirmasi';
    $transaksi->save();
    return redirect()->back()->with('success', 'Bukti bayar berhasil diunggah.');
}
    public function pesananDiterima($id){
        $transaksi = Transaksi::find($id);
        if($transaksi->pelanggan_id !== session()->get('user')->pelanggan_id){
            // tidak memiliki akses
            return redirect()->route('datapesanan')->with('error', 'Anda tidak memiliki akses untuk menambah produk.');
        }else{
            $transaksi->status = 'diterima';
            $transaksi->save();
            return redirect()->route('datapesanan')->with('success', 'Pesanan diterima');
        }
    }
    public function batalkanPesanan($id){
        $transaksi = Transaksi::find($id);
        if($transaksi->pelanggan_id !== session()->get('user')->pelanggan_id){
            // tidak memiliki akses
            return redirect()->route('datapesanan')->with('error', 'Anda tidak memiliki akses untuk menambah produk.');
        }else{
            $transaksi->status = 'dibatalkan';
            $transaksi->save();
            return redirect()->route('datapesanan')->with('success', 'Pesanan dibatalkan');
        }
    }
}