<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin {
    public function handle( Request $request, Closure $next, ...$roles ) {
        // Cek apakah user login
        if ( !session()->has( 'login' ) || !session()->has( 'role' ) ) {
            return redirect( '/login' )->with( 'error', 'Silakan login terlebih dahulu.' );
        }

        // Cek role jika ditentukan
        if ( $roles && !in_array( session( 'role' ), $roles ) ) {
            abort( 403, 'Tidak memiliki akses.' );
        }

        return $next( $request );
    }
}
