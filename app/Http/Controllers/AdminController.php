<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
      public function getAdmin() {
        // ambil Admin paginate
        $admin = Admin::paginate( 10 );
        return view( 'superadmin.datauser.admin', compact( 'admin' ) );
    }
        public function aktifkanAdmin($id){
        $admin = Admin::find($id);
        $admin->status = 'aktif';
        $admin->save();
        return redirect()->back()->with('success', 'Admin berhasil diaktifkan');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    $admin = new Admin();
    $admin->nama = $validated['nama'];
    $admin->username = $validated['username'];
    $admin->status = $validated['status'];
    $admin->password = bcrypt($validated['password']);
    $admin->no_hp = $validated['nohp'];
    $admin->save();

    return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
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
      'username' => 'required|string|max:255|unique:admins,username,' . $id . ',admin_id',
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
    $admin = Admin::findOrFail($id);
    $admin->nama = $validated['nama'];
    $admin->username = $validated['username'];
    $admin->status = $validated['status'];
    $admin->no_hp = $validated['nohp'];
    $admin->save();

    return redirect()->back()->with('success', 'Admin berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id) {
        // kasih validasi jika tidak ada

        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->back()->with('error', 'Superadmin tidak ditemukan.');
        }



        $admin->delete();
        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }
}
