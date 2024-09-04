<?php

namespace App\Http\Controllers;

use App\Models\panen;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {

        $panens = panen::where('id_petani', Auth::user()->id)->get();
        $produksi = 0;
        $luas = 0;
        $produktivitas = 0;
        if (!$panens->isEmpty()) {
            // count all produksi from panens
            foreach ($panens as $panen) {
                $produksi += $panen->produksi;
            }
            // count all luas from panens
            foreach ($panens as $panen) {
                $luas += $panen->luas_panen;
            }
            // count all produktivitas from panens
            foreach ($panens as $panen) {
                $produktivitas += $panen->produktivitas;
            }
        }

        $bar_data = [];
        $bar_produktivitas = [];
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        if (!$panens->isEmpty()) {
            foreach ($months as $month) {
                $bar_data[] =
                    // $month,
                    panen::where('id_petani', Auth::user()->id)->whereMonth('created_at', $month)->sum('produksi');
            }
            foreach ($months as $month) {
                $bar_produktivitas[] =
                    // $month,
                    panen::where('id_petani', Auth::user()->id)->whereMonth('created_at', $month)->sum('produktivitas');
            }
        }



        return view('user.index', compact('panens', 'produksi', 'luas', 'produktivitas', 'bar_data', 'bar_produktivitas'));
    }

    public function tambah()
    {

        $provinsis = Provinsi::all();

        return view('user.panen.create', compact('provinsis'));
    }

    public function insertPanen(Request $request)
    {
        // return $request->all();

        $request->validate([
            'provinsi' => 'required',
            'luas' => 'required',
            'produktivitas' => 'required',
            'produksi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'provinsi.required' => 'Provinsi harus diisi',
            'luas.required' => 'Luas harus diisi',
            'produktivitas.required' => 'Produktivitas harus diisi',
            'produksi.required' => 'Produksi harus diisi',
            'latitude.required' => 'Latitude harus diisi',
            'longitude.required' => 'Longitude harus diisi',
        ]);

        $user = Auth::user();

        $panen = new panen();
        $panen->id_petani = $user->id;
        $panen->luas_panen = $request->luas;
        $panen->produktivitas = $request->produktivitas;
        $panen->produksi = $request->produksi;
        $panen->id_provinsi = $request->provinsi;
        $panen->latitude = $request->latitude;
        $panen->longitude = $request->longitude;
        $panen->save();

        return redirect()->route('user')->with('success', 'Data Panen Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $panen = panen::find($id);
        $provinsis = Provinsi::all();
        return view('user.panen.show', compact('panen', 'provinsis'));
    }

    public function edit($id)
    {
        $panen = panen::find($id);
        $provinsis = Provinsi::all();
        return view('user.panen.edit', compact('panen', 'provinsis'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'provinsi' => 'required',
            'luas' => 'required',
            'produktivitas' => 'required',
            'produksi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'provinsi.required' => 'Provinsi harus diisi',
            'luas.required' => 'Luas harus diisi',
            'produktivitas.required' => 'Produktivitas harus diisi',
            'produksi.required' => 'Produksi harus diisi',
            'latitude.required' => 'Latitude harus diisi',
            'longitude.required' => 'Longitude harus diisi',
        ]);

        $panen = panen::find($id);
        $panen->luas_panen = $request->luas;
        $panen->produktivitas = $request->produktivitas;
        $panen->produksi = $request->produksi;
        $panen->id_provinsi = $request->provinsi;
        $panen->latitude = $request->latitude;
        $panen->longitude = $request->longitude;
        $panen->save();

        return redirect()->route('user')->with('success', 'Data Panen Berhasil Diubah');
    }

    public function delete($id)
    {
        $panen = panen::find($id);
        $panen->delete();

        return redirect()->route('user')->with('success', 'Data Panen Berhasil Dihapus');
    }
}
