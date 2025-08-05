<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Karyawan;
use App\Models\Usaha;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class DashboardController extends Controller {
    public function index() {
        $role = session()->get( 'role' );
        $user = session()->get( 'user' );
        if ( $role == 'superadmin' ) {
            $totalAdmin = Admin::count();
            $totalKaryawan = Karyawan::count();
            $totalPelanggan = Pelanggan::count();
            $totalPenjualan = DetailTransaksi::join( 'transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.transaksi_id' )
            ->where( 'transaksi.status', 'selesai' )
            ->sum( 'detail_transaksi.kuantitas' );
            $totalPendapatan = Transaksi::where( 'status', 'selesai' )
            ->sum( 'total_harga' );
            $transaksiTerakhir = Transaksi::with( 'detailTransaksi' )->with( 'usaha' )->with( 'pelanggan' )->where( 'status', 'selesai' )
            ->latest()
            ->take( 10 )
            ->get();

            return view( 'superadmin.dashboard.index', compact( 'totalAdmin', 'totalKaryawan', 'totalPelanggan', 'totalPenjualan', 'totalPendapatan', 'transaksiTerakhir' ) );
        } else if ( $role == 'admin' ) {
            $usaha = Usaha::where( 'admin_id', session()->get( 'user' )->admin_id )->first();
             $totalTransaksi = Transaksi::where( 'usaha_id', $usaha->usaha_id )->where( 'status', 'selesai' )->count();
            $totalKaryawan = Karyawan::where( 'usaha_id', $usaha->usaha_id )->count();
            $totalPelanggan = Pelanggan::count();
            $totalPenjualan = DetailTransaksi::join( 'transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.transaksi_id' )
            ->where( 'transaksi.status', 'selesai' )
            ->where( 'usaha_id', $usaha->usaha_id )
            ->sum( 'detail_transaksi.kuantitas' );
            $totalPendapatan = Transaksi::where( 'status', 'selesai' )
            ->where( 'usaha_id', $usaha->usaha_id )
            ->sum( 'total_harga' );
            $transaksiTerakhir = Transaksi::with( 'detailTransaksi' )->with( 'usaha' )->with( 'pelanggan' )->where( 'status', 'selesai' )->where( 'usaha_id', $usaha->usaha_id )
            ->latest()
            ->take( 10 )
            ->get();
            return view( 'admin.dashboard.index', compact( 'totalTransaksi', 'totalKaryawan', 'totalPelanggan', 'totalPenjualan', 'totalPendapatan', 'transaksiTerakhir' ) );
        } else if ( $role == 'karyawan' ) {
            $usaha = Usaha::where( 'usaha_id', session()->get( 'user' )->usaha_id )->first();
             $totalTransaksi = Transaksi::where( 'usaha_id', $usaha->usaha_id )->where( 'status', 'selesai' )->count();
            $totalKaryawan = Karyawan::where( 'usaha_id', $usaha->usaha_id )->count();
            $totalPelanggan = Pelanggan::count();
            $totalPenjualan = DetailTransaksi::join( 'transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.transaksi_id' )
            ->where( 'transaksi.status', 'selesai' )
            ->where( 'usaha_id', $usaha->usaha_id )
            ->sum( 'detail_transaksi.kuantitas' );
            $totalPendapatan = Transaksi::where( 'status', 'selesai' )
            ->where( 'usaha_id', $usaha->usaha_id )
            ->sum( 'total_harga' );
            $transaksiTerakhir = Transaksi::with( 'detailTransaksi' )->with( 'usaha' )->with( 'pelanggan' )->where( 'status', 'selesai' )->where( 'usaha_id', $user->usaha_id )
            ->latest()
            ->take( 10 )
            ->get();
            return view( 'karyawan.dashboard.index', compact('totalTransaksi', 'totalKaryawan', 'totalPelanggan', 'totalPenjualan', 'totalPendapatan', 'transaksiTerakhir') );
        } else if ( $role == 'pelanggan' ) {
            $totalTransaksi = Transaksi::where( 'pelanggan_id', session()->get( 'user' )->pelanggan_id )->where( 'status', 'selesai' )->count();
            $transaksiBatal = Transaksi::where( 'pelanggan_id', session()->get( 'user' )->pelanggan_id )->where( 'status', 'dibatalkan' )->count();
            $transaksiTerakhir = Transaksi::with( 'detailTransaksi' )->with( 'usaha' )->with( 'pelanggan' )->where( 'status', 'selesai' )->where( 'pelanggan_id', $user->pelanggan_id )
            ->latest()
            ->take( 10 )
            ->get();
            return view( 'pelanggan.dashboard.index', compact( 'totalTransaksi', 'transaksiBatal', 'transaksiTerakhir' ) );
        } else {
            return redirect( '/login' );
        }

    }

    public function getChartData() {
        $role = session()->get( 'role' );
        $user = session()->get( 'user' );

        $today = Carbon::now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        if($role == 'superadmin'){
                  $data = DB::table( 'transaksi' )
        ->select( DB::raw( 'DATE(created_at) as tanggal' ), DB::raw( 'SUM(total_harga) as total' ) )
        ->where( 'status', 'selesai' )
        ->whereBetween( 'created_at', [ $startOfMonth, $endOfMonth ] )
        ->groupBy( DB::raw( 'DATE(created_at)' ) )
        ->orderBy( 'tanggal' )
        ->get();

        $labels = $data->pluck( 'tanggal' );
        $totals = $data->pluck( 'total' );

        // return response( $data );
        return response()->json( [
            'labels' => $labels,
            'data' => $totals
        ] );
        }else if($role == 'admin'){
            $usaha = Usaha::where('admin_id', session()->get( 'user' )->admin_id)->first();
                   $data = DB::table( 'transaksi' )
        ->select( DB::raw( 'DATE(created_at) as tanggal' ), DB::raw( 'SUM(total_harga) as total' ) )
        ->where( 'status', 'selesai' )->where('usaha_id', $usaha->usaha_id)
        ->whereBetween( 'created_at', [ $startOfMonth, $endOfMonth ] )
        ->groupBy( DB::raw( 'DATE(created_at)' ) )
        ->orderBy( 'tanggal' )
        ->get();

        $labels = $data->pluck( 'tanggal' );
        $totals = $data->pluck( 'total' );

        // return response( $data );
        return response()->json( [
            'labels' => $labels,
            'data' => $totals
        ] );
        } else if($role == 'karyawan'){
          
                   $data = DB::table( 'transaksi' )
        ->select( DB::raw( 'DATE(created_at) as tanggal' ), DB::raw( 'SUM(total_harga) as total' ) )
        ->where( 'status', 'selesai' )->where('usaha_id', $user->usaha_id)
        ->whereBetween( 'created_at', [ $startOfMonth, $endOfMonth ] )
        ->groupBy( DB::raw( 'DATE(created_at)' ) )
        ->orderBy( 'tanggal' )
        ->get();

        $labels = $data->pluck( 'tanggal' );
        $totals = $data->pluck( 'total' );

        // return response( $data );
        return response()->json( [
            'labels' => $labels,
            'data' => $totals
        ] );
        }
        else if($role == 'pelanggan'){
                       $data = DB::table( 'transaksi' )
        ->select( DB::raw( 'DATE(created_at) as tanggal' ), DB::raw( 'SUM(total_harga) as total' ) )
        ->where( 'status', 'selesai' )->where('pelanggan_id', $user->pelanggan_id)
        ->whereBetween( 'created_at', [ $startOfMonth, $endOfMonth ] )
        ->groupBy( DB::raw( 'DATE(created_at)' ) )
        ->orderBy( 'tanggal' )
        ->get();

        $labels = $data->pluck( 'tanggal' );
        $totals = $data->pluck( 'total' );

        // return response( $data );
        return response()->json( [
            'labels' => $labels,
            'data' => $totals
        ] );
        }
        else{
            return response()->json(['message' => 'Unauthorized'], 401);
        }


    }

    public function getMonthlyChartData() {
        $year = Carbon::now()->year;

        $role = session()->get( 'role' );
        $user = session()->get( 'user' );
        if($role == 'superadmin'){
               $data = DB::table( 'transaksi' )
        ->select(
            DB::raw( 'MONTH(created_at) as bulan' ),
            DB::raw( 'SUM(total_harga) as total' )
        )
        ->where( 'status', 'selesai' )
        ->whereYear( 'created_at', $year )
        ->groupBy( DB::raw( 'MONTH(created_at)' ) )
        ->orderBy( 'bulan' )
        ->get();

        // Buat array bulan dari 1-12
        $bulanLabels = [
            0 => 'Jan', 1 => 'Feb', 2 => 'Mar', 3 => 'Apr',
            4 => 'Mei', 5 => 'Jun', 6 => 'Jul', 7 => 'Agu',
            8 => 'Sep', 9 => 'Okt', 10 => 'Nov', 11 => 'Des'
        ];

        $result = [];
        for ( $i = 1; $i <= 12; $i++ ) {
            $found = $data->firstWhere( 'bulan', $i );
            $result[] = $found ? $found->total : 0;
        }

        return response()->json( [
            'labels' => array_values( $bulanLabels ),
            'data' => $result
        ] );
        }else if($role == 'admin'){
            $usaha = Usaha::where('admin_id', session()->get( 'user' )->admin_id)->first();
                    $data = DB::table( 'transaksi' )
        ->select(
            DB::raw( 'MONTH(created_at) as bulan' ),
            DB::raw( 'SUM(total_harga) as total' )
        )
        ->where( 'status', 'selesai' )
        ->where('usaha_id', $usaha->usaha_id)
        ->whereYear( 'created_at', $year )
        ->groupBy( DB::raw( 'MONTH(created_at)' ) )
        ->orderBy( 'bulan' )
        ->get();

        // Buat array bulan dari 1-12
        $bulanLabels = [
            0 => 'Jan', 1 => 'Feb', 2 => 'Mar', 3 => 'Apr',
            4 => 'Mei', 5 => 'Jun', 6 => 'Jul', 7 => 'Agu',
            8 => 'Sep', 9 => 'Okt', 10 => 'Nov', 11 => 'Des'
        ];

        $result = [];
        for ( $i = 1; $i <= 12; $i++ ) {
            $found = $data->firstWhere( 'bulan', $i );
            $result[] = $found ? $found->total : 0;
        }

        return response()->json( [
            'labels' => array_values( $bulanLabels ),
            'data' => $result
        ] );
        }
        else if($role == 'karyawan'){
              
                    $data = DB::table( 'transaksi' )
        ->select(
            DB::raw( 'MONTH(created_at) as bulan' ),
            DB::raw( 'SUM(total_harga) as total' )
        )
        ->where( 'status', 'selesai' )
        ->where('usaha_id', $user->usaha_id)
        ->whereYear( 'created_at', $year )
        ->groupBy( DB::raw( 'MONTH(created_at)' ) )
        ->orderBy( 'bulan' )
        ->get();

        // Buat array bulan dari 1-12
        $bulanLabels = [
            0 => 'Jan', 1 => 'Feb', 2 => 'Mar', 3 => 'Apr',
            4 => 'Mei', 5 => 'Jun', 6 => 'Jul', 7 => 'Agu',
            8 => 'Sep', 9 => 'Okt', 10 => 'Nov', 11 => 'Des'
        ];

        $result = [];
        for ( $i = 1; $i <= 12; $i++ ) {
            $found = $data->firstWhere( 'bulan', $i );
            $result[] = $found ? $found->total : 0;
        }

        return response()->json( [
            'labels' => array_values( $bulanLabels ),
            'data' => $result
        ] );
        }
        else if($role == 'pelanggan'){
                $data = DB::table( 'transaksi' )
        ->select(
            DB::raw( 'MONTH(created_at) as bulan' ),
            DB::raw( 'SUM(total_harga) as total' )
        )
        ->where( 'status', 'selesai' )
        ->where('pelanggan_id', $user->pelanggan_id)
        ->whereYear( 'created_at', $year )
        ->groupBy( DB::raw( 'MONTH(created_at)' ) )
        ->orderBy( 'bulan' )
        ->get();

        // Buat array bulan dari 1-12
        $bulanLabels = [
            0 => 'Jan', 1 => 'Feb', 2 => 'Mar', 3 => 'Apr',
            4 => 'Mei', 5 => 'Jun', 6 => 'Jul', 7 => 'Agu',
            8 => 'Sep', 9 => 'Okt', 10 => 'Nov', 11 => 'Des'
        ];

        $result = [];
        for ( $i = 1; $i <= 12; $i++ ) {
            $found = $data->firstWhere( 'bulan', $i );
            $result[] = $found ? $found->total : 0;
        }

        return response()->json( [
            'labels' => array_values( $bulanLabels ),
            'data' => $result
        ] );
        }
        else{
            return response()->json(['message' => 'Unauthorized'], 401);
        }


    }
}
