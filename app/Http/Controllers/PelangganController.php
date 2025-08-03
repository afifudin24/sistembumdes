<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Carbon\Carbon;

class PelangganController extends Controller
{
          public function getPelanggan() {
        // ambil Admin paginate
        $pelanggan = Pelanggan::paginate( 10 );

        return view( 'superadmin.datauser.pelanggan', compact( 'pelanggan' ) );
    }
        public function aktifkanPelanggan($id){
        $karyawan = Pelanggan::find($id);
        $karyawan->status_akun = 'aktif';
        $karyawan->save();
        return redirect()->back()->with('success', 'Pelanggan berhasil diaktifkan');
    }
       public function store( Request $request ) {
       $validated = $request->validate([
        'nama' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:pelanggans,username',

        'status_akun' => 'required|in:aktif,nonaktif',
        'nohp' => 'required|string|max:20',
        'password' => 'required|string|min:6',
        'alamat' => 'required|string',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'status_akun.required' => 'Status wajib dipilih.',
        'status_akun.in' => 'Status harus bernilai "aktif" atau "nonaktif".',
        'nohp.required' => 'Nomor HP wajib diisi.',
        'nohp.max' => 'Nomor HP tidak boleh lebih dari 20 karakter.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'alamat.required' => 'Alamat wajib diisi.',
    ]);

    // data baru
    $pelanggan = new Pelanggan();
    $pelanggan->nama = $validated['nama'];
    $pelanggan->username = $validated['username'];
    $pelanggan->status_akun = $validated['status_akun'];
    $pelanggan->password = bcrypt($validated['password']);
    $pelanggan->no_hp = $validated['nohp'];
    $pelanggan->alamat = $validated['alamat'];
    $pelanggan->tanggal_daftar =  Carbon::now();
    $pelanggan->save();

    return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan.');
    }

      public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
     'username' => 'required|string|max:255|unique:pelanggans,username,' . $id . ',pelanggan_id',
        'status_akun' => 'required|in:aktif,nonaktif',
        'nohp' => 'required|string|max:20',

        'alamat' => 'required|string',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'status_akun.required' => 'Status wajib dipilih.',
        'status_akun.in' => 'Status harus bernilai "aktif" atau "nonaktif".',
        'nohp.required' => 'Nomor HP wajib diisi.',
        'nohp.max' => 'Nomor HP tidak boleh lebih dari 20 karakter.',
        'alamat.required' => 'Alamat wajib diisi.',
    ]);

    // Temukan dan update data
    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->nama = $validated['nama'];
    $pelanggan->username = $validated['username'];
    $pelanggan->status_akun = $validated['status_akun'];
    $pelanggan->no_hp = $validated['nohp'];
    $pelanggan->alamat = $validated['alamat'];
    $pelanggan->save();

    return redirect()->back()->with('success', 'Karyawan berhasil diperbarui.');
}

public function destroy($id){
    $pelanggan = Pelanggan::find($id);
    if(!$pelanggan){
        return redirect()->back()->with('error', 'Pelanggan tidak ditemukan');
    }
    $pelanggan->delete();
    return redirect()->back()->with('success', 'Pelanggan berhasil dihapus');
}

}
