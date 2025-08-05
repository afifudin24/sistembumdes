<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Usaha;
class LandingPageController extends Controller {
    public function index() {
      $produks = Produk::with('usaha')->inRandomOrder()->limit(3)->get();

    return view( 'landingpage.index', compact( 'produks' ) );
    }

    public function listProduk(Request $request){
         $usaha = Usaha::all();

    if ($request->has('usaha_id') && $request->usaha_id != '') {
        $produks = Produk::where('usaha_id', $request->usaha_id)->paginate(10);
    } else {
        $produks = Produk::paginate(2);
    }

    return view('landingpage.listproduk', compact('produks', 'usaha'));
    }
}
