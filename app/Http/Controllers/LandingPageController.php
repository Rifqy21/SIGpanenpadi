<?php

namespace App\Http\Controllers;

use App\Models\panen;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $panen = panen::all();
        $provinsi = Provinsi::all();
        $produksi = [];
        if (!$panen->isEmpty()) {
            for($i = 0; $i < 13; $i++){
                $produksi[] = panen::whereMonth('created_at', $i+1)->sum('produksi');
            }
        }

        return view('welcome', compact('panen', 'produksi', 'provinsi'));
    }
}
