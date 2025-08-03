<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Usaha;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
   public function index(){
    $produk = Produk::with('usaha')->paginate(10);
    $usaha = Usaha::all();
    return view('superadmin.produk.index', compact('produk', 'usaha'));
   }
       public function store(Request $request)
    {
        $validated = $request->validate([
            'usaha_id' => 'required|exists:usaha,usaha_id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $gambarPath;
        }

        Produk::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'usaha_id' => 'required|exists:usaha,usaha_id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $gambarPath = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $gambarPath;
        }

        $produk->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function getProdukByUsaha(){
        $admin = session()->get('user');
        $usaha_id = $admin->usaha_id;
        $produk = Produk::where('usaha_id', $usaha_id)->get();
        return response()->json($produk);
    }
}
