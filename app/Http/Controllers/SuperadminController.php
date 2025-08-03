<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use App\Http\Requests\StoreSuperadminRequest;
use App\Http\Requests\UpdateSuperadminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        //
    }

    public function getSuperAdmin() {
        // ambil superadmin paginate
        $superadmin = Superadmin::paginate( 10 );
        return view( 'superadmin.datauser.superadmin', compact( 'superadmin' ) );
    }

    public function aktifkanSuperAdmin($id){
        $superadmin = Superadmin::find($id);
        $superadmin->status = 'aktif';
        $superadmin->save();
        return redirect()->back()->with('success', 'Super Admin berhasil diaktifkan');
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    */

       public function store( Request $request ) {
       $validated = $request->validate([
        'nama' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:admins,username',
        'status' => 'required|in:aktif,nonaktif',
        'nohp' => 'required|string|max:20',
        'password' => 'required|string|min:6',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'status.required' => 'Status wajib dipilih.',
        'status.in' => 'Status harus bernilai "aktif" atau "nonaktif".',
        'nohp.required' => 'Nomor HP wajib diisi.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',

    ]);

    // data baru
    $superadmin = new Superadmin();
    $superadmin->nama = $validated['nama'];
    $superadmin->username = $validated['username'];
    $superadmin->status = $validated['status'];
    $superadmin->password = bcrypt($validated['password']);
    $superadmin->no_hp = $validated['nohp'];
    $superadmin->save();

    return redirect()->back()->with('success', 'Superadmin berhasil ditambahkan.');
    }

    /**
    * Display the specified resource.
    */

    public function show( Superadmin $superadmin ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( Superadmin $superadmin ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

  public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
     'username' => 'required|string|max:255|unique:superadmins,username,' . $id . ',id',

        'status' => 'required|in:aktif,nonaktif',
        'nohp' => 'required|string|max:20',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'status.required' => 'Status wajib dipilih.',
        'status.in' => 'Status harus bernilai "aktif" atau "nonaktif".',
        'nohp.required' => 'Nomor HP wajib diisi.',
    ]);

    // Temukan dan update data
    $superadmin = Superadmin::findOrFail($id);
    $superadmin->nama = $validated['nama'];
    $superadmin->username = $validated['username'];
    $superadmin->status = $validated['status'];
    $superadmin->no_hp = $validated['nohp'];
    $superadmin->save();

    return redirect()->back()->with('success', 'Superadmin berhasil diperbarui.');
}


    /**
    * Remove the specified resource from storage.
    */

    public function destroy( $id) {
        // kasih validasi jika tidak ada

        $superadmin = Superadmin::find($id);
        if (!$superadmin) {
            return redirect()->back()->with('error', 'Superadmin tidak ditemukan.');
        }

        // jika session user id nya sama dengan superadmin id
        if(session()->get('user')->superadmin_id == $id){
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus diri sendiri.');
        }

        $superadmin->delete();
        return redirect()->back()->with('success', 'Superadmin berhasil dihapus.');
    }
}
