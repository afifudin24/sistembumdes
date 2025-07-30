<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session()->get('role');
        if($role == 'superadmin') {
              return view('superadmin.dashboard.index');
        }else if ($role == 'admin') {
             return view('admin.dashboard.index');
        }else if($role == 'karyawan') {
             return view('karyawan.dashboard.index');
        }else if($role == 'pelanggan') {
             return view('pelanggan.dashboard.index');
        }else{
            return redirect('/login');
        }

    }
}
