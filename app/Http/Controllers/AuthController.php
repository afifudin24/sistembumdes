<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Superadmin;
use App\Models\Admin;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class AuthController extends Controller {

    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
        'role'     => 'required|in:superadmin,admin,karyawan,pelanggan',
    ], [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'role.required'     => 'Peran (role) wajib dipilih.',
        'role.in'           => 'Peran yang dipilih tidak valid. Pilih salah satu dari: superadmin, admin, karyawan, atau pelanggan.',
    ]);

    $username = $request->username;
    $password = $request->password;
    $role     = $request->role;

    $user = null;

    switch ($role) {
        case 'superadmin':
            $user = Superadmin::where('username', $username)->first();
            break;
        case 'admin':
            $user = Admin::where('username', $username)->first();
            break;
        case 'karyawan':
            $user = Karyawan::where('username', $username)->first();
            break;
        case 'pelanggan':
            $user = Pelanggan::where('username', $username)->first();
            break;
    }

    if ($user) {
        if ($user->status_akun === 'nonaktif') {
            return back()->with('error', 'Akun Anda belum aktif.')->withInput();
        }

        if (Hash::check($password, $user->password)) {
            Session::put('login', true);
            Session::put('role', $role);
            Session::put('user', $user);

            return redirect('/dashboard');
        }
    }

    return back()->with('error', 'Username atau password salah.')->withInput();
}

public function register(Request $request)
{

   $request->validate([
    'nama'     => 'required|string|max:100',
    'username' => 'required|string|max:50|unique:pelanggans,username',
    'password' => 'required|string|min:6',
    'no_hp'    => 'required|string|max:20',
    'alamat'   => 'required|string',
], [
    'nama.required'      => 'Nama wajib diisi.',
    'nama.max'           => 'Nama maksimal 100 karakter.',
    'username.required'  => 'Username wajib diisi.',
    'username.max'       => 'Username maksimal 50 karakter.',
    'username.unique'    => 'Username sudah digunakan.',
    'password.required'  => 'Password wajib diisi.',
    'password.min'       => 'Password minimal 6 karakter.',
    'no_hp.required'     => 'Nomor HP wajib diisi.',
    'no_hp.max'          => 'Nomor HP maksimal 20 karakter.',
    'alamat.required'    => 'Alamat wajib diisi.',
]);

//   dd($request->username);
   $user = Pelanggan::create([
        'nama'           => $request->nama,
        'username'       => $request->username,
        'password'       => Hash::make($request->password),
        'no_hp'          => $request->no_hp,
        'alamat'         => $request->alamat,
        'tanggal_daftar' => Carbon::now(),
        'status_akun'    => 'nonaktif',
    ]);

    return redirect('/login')->with('success', 'Pendaftaran berhasil! Tunggu aktivasi akun.');
}


public function logout(Request $request)
{
    $request->session()->flush(); // hapus semua session
    $request->session()->flash('success', 'Anda berhasil logout');
    return redirect('/login');
}


}
