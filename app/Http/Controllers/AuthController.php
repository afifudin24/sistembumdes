<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Superadmin;
use App\Models\Admin;
use App\Models\Karyawan;
use App\Models\Pelanggan;

class AuthController extends Controller {

    public function login( Request $request ) {

        $request->validate( [
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required|in:superadmin,admin,karyawan,pelanggan',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'role.required'     => 'Peran (role) wajib dipilih.',
            'role.in'           => 'Peran yang dipilih tidak valid. Pilih salah satu dari: superadmin, admin, karyawan, atau pelanggan.',
        ] );

        $username = $request->username;
        $password = $request->password;
        $role     = $request->role;

        $user = null;

        switch ( $role ) {
            case 'superadmin':
            $user = Superadmin::where( 'username', $username )->first();
            break;
            case 'admin':
            $user = Admin::where( 'username', $username )->first();
            break;
            case 'karyawan':
            $user = Karyawan::where( 'username', $username )->first();
            break;
            case 'pelanggan':
            $user = Pelanggan::where( 'username', $username )->first();
            break;

        }

        if ( $user && Hash::check( $password, $user->password ) ) {
            // Simpan user info ke session
            Session::put( 'login', true );
            Session::put( 'role', $role );
            Session::put( 'user', $user );

            return redirect( '/dashboard' );

        }

        return back()->with( 'error', 'Username atau password salah.' );
    }

}