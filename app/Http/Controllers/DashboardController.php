<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class DashboardController extends Controller {
    public function index() {
        $role = session()->get( 'role' );
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
            return view( 'admin.dashboard.index' );
        } else if ( $role == 'karyawan' ) {
            return view( 'karyawan.dashboard.index' );
        } else if ( $role == 'pelanggan' ) {
            return view( 'pelanggan.dashboard.index' );
        } else {
            return redirect( '/login' );
        }

    }

    public function getChartData() {
        $today = Carbon::now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

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
    }

    public function getMonthlyChartData() {
        $year = Carbon::now()->year;

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
    }
}