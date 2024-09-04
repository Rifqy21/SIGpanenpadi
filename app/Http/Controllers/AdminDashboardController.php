<?php

namespace App\Http\Controllers;

use App\Models\panen;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::all();
        $panens = panen::all();
        $petanis = User::where('role', 'user')->get();
        return view('admin.index', compact('provinsis', 'panens', 'petanis'));
    }

    public function aduan()
    {
        return view('admin.aduan');
    }

    public function createDataPanen()
    {
        return view('admin.panen.create');
    }

    public function insertDataPanen(Request $request)
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

        return redirect()->route('admin')->with('success', 'Data Panen Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $panen = panen::find($id);
        $provinsis = Provinsi::all();
        return view('admin.panen.show', compact('panen', 'provinsis'));
    }

    public function edit($id)
    {
        $panen = panen::find($id);
        $provinsis = Provinsi::all();
        return view('admin.panen.edit', compact('panen', 'provinsis'));
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

        return redirect()->route('admin')->with('success', 'Data Panen Berhasil Diubah');
    }

    public function delete($id)
    {
        $panen = panen::find($id);
        $panen->delete();

        return redirect()->route('admin')->with('success', 'Data Panen Berhasil Dihapus');
    }

}
