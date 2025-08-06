<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Usaha;
class KaryawanController extends Controller
{
      public function getKaryawan() {
        $role = session()->get( 'role' );
        if($role == 'superadmin') {
        // ambil Admin paginate
        $karyawan = Karyawan::with('usaha')->paginate( 10 );
        $usaha = Usaha::all();
        return view( 'superadmin.datauser.karyawan', compact( 'karyawan', 'usaha' ) );
        }else if($role == 'admin') {
            $usaha = Usaha::where('admin_id', session()->get( 'user' )->admin_id)->first();
        // ambil Admin paginate
        $karyawan = Karyawan::with('usaha')->where('usaha_id', $usaha->usaha_id)->paginate( 10 );
        return view( 'admin.karyawan.index', compact( 'karyawan', 'usaha' ) );
        }
    }
        public function aktifkanKaryawan($id){
        $karyawan = Karyawan::find($id);
        $karyawan->status_akun = 'aktif';
        $karyawan->save();
        return redirect()->back()->with('success', 'Karyawan berhasil diaktifkan');
    }
       public function store( Request $request ) {
        $role = session()->get( 'role' );
        if($role == 'superadmin') {


       $validated = $request->validate([
        'nama' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:karyawans,username',
        'usaha_id' => 'required|exists:usaha,usaha_id',
        'status_akun' => 'required|in:aktif,nonaktif',
        'nohp' => 'required|string|max:20',
        'password' => 'required|string|min:6',
        'alamat' => 'required|string',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'usaha_id.required' => 'Usaha wajib dipilih.',
        'usaha_id.exists' => 'Usaha tidak ditemukan.',
        'status_akun.required' => 'Status wajib dipilih.',
        'status_akun.in' => 'Status harus bernilai "aktif" atau "nonaktif".',
        'nohp.required' => 'Nomor HP wajib diisi.',
        'nohp.max' => 'Nomor HP tidak boleh lebih dari 20 karakter.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'alamat.required' => 'Alamat wajib diisi.',
    ]);

    // data baru
    $karyawan = new Karyawan();
    $karyawan->nama = $validated['nama'];
    $karyawan->username = $validated['username'];
    $karyawan->usaha_id = $validated['usaha_id'];
    $karyawan->status_akun = $validated['status_akun'];
    $karyawan->password = bcrypt($validated['password']);
    $karyawan->no_hp = $validated['nohp'];
    $karyawan->alamat = $validated['alamat'];
    $karyawan->save();

    return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
     }
     else if($role == 'admin') {
        $usaha = Usaha::where('admin_id', session()->get( 'user' )->admin_id)->first();
        $usaha_id = $usaha->usaha_id;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:karyawans,username',
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
    $karyawan = new Karyawan();
    $karyawan->nama = $validated['nama'];
    $karyawan->username = $validated['username'];
    $karyawan->usaha_id = $usaha_id;
    $karyawan->status_akun = $validated['status_akun'];
    $karyawan->password = bcrypt($validated['password']);
    $karyawan->no_hp = $validated['nohp'];
    $karyawan->alamat = $validated['alamat'];
    $karyawan->save();
        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
     }else {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambahkan karyawan.');
     }
    }

      public function update(Request $request, $id)
{
      $role = session()->get( 'role' );
    if($role == 'superadmin') {
         $validated = $request->validate([
        'nama' => 'required|string|max:255',
     'username' => 'required|string|max:255|unique:karyawans,username,' . $id . ',karyawan_id',

        'usaha_id' => 'required|exists:usaha,usaha_id',
        'status_akun' => 'required|in:aktif,nonaktif',
        'nohp' => 'required|string|max:20',

        'alamat' => 'required|string',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'usaha_id.required' => 'Usaha wajib dipilih.',
        'usaha_id.exists' => 'Usaha tidak ditemukan.',
        'status_akun.required' => 'Status wajib dipilih.',
        'status_akun.in' => 'Status harus bernilai "aktif" atau "nonaktif".',
        'nohp.required' => 'Nomor HP wajib diisi.',
        'nohp.max' => 'Nomor HP tidak boleh lebih dari 20 karakter.',
        'alamat.required' => 'Alamat wajib diisi.',
    ]);

    // Temukan dan update data
    $karyawan = Karyawan::findOrFail($id);
    $karyawan->nama = $validated['nama'];
    $karyawan->username = $validated['username'];
    $karyawan->status_akun = $validated['status_akun'];
    $karyawan->usaha_id = $validated['usaha_id'];
    $karyawan->no_hp = $validated['nohp'];
    $karyawan->alamat = $validated['alamat'];
    $karyawan->save();

    return redirect()->back()->with('success', 'Karyawan berhasil diperbarui.');
    }else if($role == 'admin') {
          $validated = $request->validate([
        'nama' => 'required|string|max:255',
     'username' => 'required|string|max:255|unique:karyawans,username,' . $id . ',karyawan_id',


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
    $karyawan = Karyawan::findOrFail($id);
    $karyawan->nama = $validated['nama'];
    $karyawan->username = $validated['username'];
    $karyawan->status_akun = $validated['status_akun'];

    $karyawan->no_hp = $validated['nohp'];
    $karyawan->alamat = $validated['alamat'];
    $karyawan->save();

    return redirect()->back()->with('success', 'Karyawan berhasil diperbarui.');
    }
    // Validasi input

}

public function destroy($id){
    $karyawan = Karyawan::find($id);
    if(!$karyawan){
        return redirect()->back()->with('error', 'Karyawan tidak ditemukan');
    }
    $karyawan->delete();
    return redirect()->back()->with('success', 'Karyawan berhasil dihapus');
}



}
