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
    $role = session()->get('role');
    $user = session()->get('user');

    if($role == 'superadmin'){
        $produk = Produk::with('usaha')->paginate(10);
        $usaha = Usaha::all();
        return view('superadmin.produk.index', compact('produk', 'usaha'));
    }else if($role == 'admin'){
         $usaha = Usaha::where('admin_id', $user->admin_id)->first();
        $produk = Produk::with('usaha')->where('usaha_id', $usaha->usaha_id)->paginate(10);
        return view('admin.produk.index', compact('produk', 'usaha'));
    }
   }
       public function store(Request $request)
    {
          $role = session()->get('role');
    $user = session()->get('user');
    if($role == 'superadmin'){
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
    }else if($role == 'admin'){
        $usaha = Usaha::where('admin_id', $user->admin_id)->first();
        $validated = $request->validate([
            // 'usaha_id' => 'required|exists:usaha,usaha_id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $validated['usaha_id'] = $usaha->usaha_id;

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $gambarPath;
        }

        Produk::create($validated);
    }
    else{
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah produk.');
    }


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
