<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\panen;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LandingPageController extends Controller
{
    public function index()
    {
        $panen = panen::all();
        $provinsi = Provinsi::all();
        $produksi = [];
        if (!$panen->isEmpty()) {
            for ($i = 0; $i < 13; $i++) {
                $produksi[] = panen::whereMonth('created_at', $i + 1)->sum('produksi');
            }
            // join panen with user where id_petani = id and join with provinsi where id_provinsi = id
            $panen = panen::join('users', 'panens.id_petani', '=', 'users.id')
                ->join('provinsis', 'panens.id_provinsi', '=', 'provinsis.id')
                ->select('panens.*', 'users.name', 'provinsis.nama_provinsi')
                ->get();
        }


        $panenTahun = panen::whereYear('updated_at', date('Y'))->get();

        $provinsis = Provinsi::all();

        $allLuasPanen = 0;
        $allProduktivitas = 0;
        $allProduksi = 0;
        foreach ($provinsis as $province) {
            $luasPanenVal = 0;
            $produktivitasVal = 0;
            $produksiVal = 0;

            foreach ($panenTahun as $panenT) {
                if ($panenT->id_provinsi == $province->id) {
                    $luasPanenVal += $panenT->luas_panen;
                    $produktivitasVal += $panenT->produktivitas;
                    $produksiVal += $panenT->produksi;
                    $allLuasPanen += $panenT->luas_panen;
                    $allProduktivitas += $panenT->produktivitas;
                    $allProduksi += $panenT->produksi;
                }
            }
            $books[] = [$province->nama_provinsi, $luasPanenVal, $produktivitasVal, $produksiVal, date('Y')];
        }


        return view('welcome', compact('panen', 'produksi', 'provinsi', 'books'));
    }

    public function sendAduan(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'subject.required' => 'Subject harus diisi',
            'message.required' => 'Message harus diisi'
        ]);

        $aduan = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unreply'
        ];

        Aduan::create($aduan);

        return redirect('/')->with('success', 'Pesan berhasil dikirim');

    }
}
