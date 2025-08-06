<?php
use Carbon\Carbon;

if ( !function_exists( 'formatRupiah' ) ) {
    function formatRupiah( $angka, $prefix = 'Rp' )
 {
        if ( !is_numeric( $angka ) ) {
            return $prefix . ' 0';
        }

        return $prefix . ' ' . number_format( $angka, 0, ',', '.' );
    }
}

if ( !function_exists( 'formatTanggal' ) ) {
    function formatTanggal( $datetime )
 {
        return Carbon::parse( $datetime )->format( 'd/m/y' );
        // Format: 02/08/25
    }
}

if (!function_exists('potongDeskripsi')) {
    function potongDeskripsi($teks, $maks = 20)
    {
        return strlen($teks) > $maks
            ? substr($teks, 0, $maks) . '............'
            : $teks;
    }
}
