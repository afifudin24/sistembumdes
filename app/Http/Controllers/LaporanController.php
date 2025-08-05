<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Usaha;
use App\Models\DetailTransaksi;
use App\Models\Produk;


class LaporanController extends Controller
{
    public function index(Request $request) {
        $role = session()->get( 'role' );
        $user = session()->get( 'user' );
        if($role == 'superadmin'){
              $query = Transaksi::with( 'usaha' )->with( 'pelanggan' )->with( 'detailTransaksi' )->where( 'status', 'selesai' );
          if ( $request->filled( 'tanggal_mulai' ) && $request->filled( 'tanggal_akhir' ) ) {
            $query->whereBetween( 'tanggal', [ $request->tanggal_mulai, $request->tanggal_akhir ] );
        }
        $laporan = $query->paginate( 10 );
        return view( 'superadmin.laporanpenjualan.index', compact( 'laporan' ) );
        }else if($role == 'admin'){
            $usaha = Usaha::where('admin_id', $user->admin_id)->first();
            $query = Transaksi::with( 'usaha' )->with( 'pelanggan' )->with( 'detailTransaksi' )->where( 'status', 'selesai' )->where('usaha_id', $usaha->usaha_id);
            if ( $request->filled( 'tanggal_mulai' ) && $request->filled( 'tanggal_akhir' ) ) {
                $query->whereBetween( 'tanggal', [ $request->tanggal_mulai, $request->tanggal_akhir ] );
            }
             $laporan = $query->paginate( 10 );
        return view( 'admin.laporanpenjualan.index', compact( 'laporan' ) );
        } else if($role == 'karyawan'){
              $query = Transaksi::with( 'usaha' )->with( 'pelanggan' )->with( 'detailTransaksi' )->where( 'status', 'selesai' )->where('usaha_id', $user->usaha_id);
            if ( $request->filled( 'tanggal_mulai' ) && $request->filled( 'tanggal_akhir' ) ) {
                $query->whereBetween( 'tanggal', [ $request->tanggal_mulai, $request->tanggal_akhir ] );
            }
             $laporan = $query->paginate( 10 );
            
              return view( 'karyawan.laporanpenjualan.index', compact( 'laporan' ) );
        }
        
        else{
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah produk.');
        }


    }

    public function exportToPDF(Request $request) {
        $role = session()->get( 'role' );
        $user = session()->get( 'user' );
        if($role == 'superadmin'){
            $query = Transaksi::with( 'usaha' )->with( 'pelanggan' )->with( 'detailTransaksi' )->where( 'status', 'selesai' );
            if ( $request->filled( 'tanggal_mulai' ) && $request->filled( 'tanggal_akhir' ) ) {
                $query->whereBetween( 'tanggal', [ $request->tanggal_mulai, $request->tanggal_akhir ] );
            }
            $laporan = $query->get();
              $pdf = Pdf::loadView( 'superadmin.laporanpenjualan.pdf', compact( 'laporan' ) );
        }else if($role == 'admin'){
            $usaha = Usaha::where('admin_id', $user->admin_id)->first();
            $query = Transaksi::with( 'usaha' )->with( 'pelanggan' )->with( 'detailTransaksi' )->where( 'status', 'selesai' )->where('usaha_id', $usaha->usaha_id);
            if ( $request->filled( 'tanggal_mulai' ) && $request->filled( 'tanggal_akhir' ) ) {
                $query->whereBetween( 'tanggal', [ $request->tanggal_mulai, $request->tanggal_akhir ] );
            }
            $laporan = $query->get();
              $pdf = Pdf::loadView( 'admin.laporanpenjualan.pdf', compact( 'laporan' ) );

           
        } else if($role == 'karyawan'){
            $query = Transaksi::with( 'usaha' )->with( 'pelanggan' )->with( 'detailTransaksi' )->where( 'status', 'selesai' )->where('usaha_id', $user->usaha_id);
            if ( $request->filled( 'tanggal_mulai' ) && $request->filled( 'tanggal_akhir' ) ) {
                $query->whereBetween( 'tanggal', [ $request->tanggal_mulai, $request->tanggal_akhir ] );
            }
            $laporan = $query->get();
              $pdf = Pdf::loadView( 'karyawan.laporanpenjualan.pdf', compact( 'laporan' ) );
        }
        
        else{
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah produk.');
        }

        return $pdf->download( 'laporan_penjualan.pdf' );
    }
}
