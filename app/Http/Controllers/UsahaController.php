<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usaha;
use App\Models\Admin;
class UsahaController extends Controller
{
    public function index(){
        $usaha = Usaha::with('admin')->paginate(10);
        $admin = Admin::all();
        return view('superadmin.usaha.index', compact('usaha', 'admin'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_usaha'   => 'required|string|max:255',
        'email'        => 'required|email|max:255|unique:usaha,email',
        'admin_id'     => 'required|exists:admins,admin_id',
        'rekening'     => 'required|in:BRI,BCA,Mandiri,BSI',
        'no_rek'       => 'required|string|max:50',
        'no_telepon'   => 'required|string|max:20',
        'keterangan'   => 'required|string',
        'alamat'       => 'required|string',
    ], [
        'nama_usaha.required'   => 'Nama usaha wajib diisi.',
        'nama_usaha.max'        => 'Nama usaha maksimal 255 karakter.',

        'email.required'        => 'Email wajib diisi.',
        'email.email'           => 'Format email tidak valid.',
        'email.max'             => 'Email maksimal 255 karakter.',
        'email.unique'          => 'Email sudah terdaftar.',

        'admin_id.required'     => 'Admin wajib dipilih.',
        'admin_id.exists'       => 'Admin yang dipilih tidak ditemukan.',

        'rekening.required'     => 'Rekening wajib dipilih.',
        'rekening.in'           => 'Rekening harus salah satu dari: BRI, BCA, Mandiri, BSI.',

        'no_rek.required'       => 'Nomor rekening wajib diisi.',
        'no_rek.max'            => 'Nomor rekening maksimal 50 karakter.',

        'no_telepon.required'   => 'Nomor telepon wajib diisi.',
        'no_telepon.max'        => 'Nomor telepon maksimal 20 karakter.',

        'keterangan.required'   => 'Keterangan wajib diisi.',
        'alamat.required'       => 'Alamat wajib diisi.',
    ]);

    // Simpan data ke tabel `usahas` (pastikan nama model dan table sesuai)
    Usaha::create($validated);

    return redirect()->back()->with('success', 'Data usaha berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $usaha = Usaha::findOrFail($id);

    $validated = $request->validate([
        'nama_usaha'   => 'required|string|max:255',
        'email'        => 'required|email|max:255|unique:usaha,email,' . $id . ',usaha_id',
        'admin_id'     => 'required|exists:admins,admin_id',
        'rekening'     => 'required|in:BRI,BCA,Mandiri,BSI',
        'no_rek'       => 'required|string|max:50',
        'no_telepon'   => 'required|string|max:20',
        'keterangan'   => 'required|string',
        'alamat'       => 'required|string',
    ], [
        'nama_usaha.required'   => 'Nama usaha wajib diisi.',
        'nama_usaha.max'        => 'Nama usaha maksimal 255 karakter.',

        'email.required'        => 'Email wajib diisi.',
        'email.email'           => 'Format email tidak valid.',
        'email.max'             => 'Email maksimal 255 karakter.',
        'email.unique'          => 'Email sudah terdaftar.',

        'admin_id.required'     => 'Admin wajib dipilih.',
        'admin_id.exists'       => 'Admin yang dipilih tidak ditemukan.',

        'rekening.required'     => 'Rekening wajib dipilih.',
        'rekening.in'           => 'Rekening harus salah satu dari: BRI, BCA, Mandiri, BSI.',

        'no_rek.required'       => 'Nomor rekening wajib diisi.',
        'no_rek.max'            => 'Nomor rekening maksimal 50 karakter.',

        'no_telepon.required'   => 'Nomor telepon wajib diisi.',
        'no_telepon.max'        => 'Nomor telepon maksimal 20 karakter.',

        'keterangan.required'   => 'Keterangan wajib diisi.',
        'alamat.required'       => 'Alamat wajib diisi.',
    ]);

    $usaha->update($validated);

    return redirect()->back()->with('success', 'Data usaha berhasil diperbarui.');
}

    public function destroy($id){
        $usaha = Usaha::find($id);
        if(!$usaha){
            return redirect()->back()->with('error', 'Data usaha tidak ditemukan.');
        }
        $usaha->delete();
        return redirect()->back()->with('success', 'Data usaha berhasil dihapus.');
    }
}
