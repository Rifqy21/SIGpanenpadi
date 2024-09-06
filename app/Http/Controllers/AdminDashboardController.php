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

            $panens = panen::join('users', 'panens.id_petani', '=', 'users.id')
                ->select('panens.*', 'users.name')
                ->get();
        }

        $bar_data = [];
        $bar_produktivitas = [];
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        if (!$panens->isEmpty()) {
            foreach ($months as $month) {
                $bar_data[] =
                    // $month,
                    panen::whereMonth('created_at', $month)->sum('produksi');
            }
            foreach ($months as $month) {
                $bar_produktivitas[] =
                    // $month,
                    panen::whereMonth('created_at', $month)->sum('produktivitas');
            }
        }

        return view('admin.index', compact('provinsis', 'panens', 'petanis', 'produksi', 'luas', 'produktivitas', 'bar_data', 'bar_produktivitas'));
    }

    public function aduan()
    {
        return view('admin.aduan');
    }

    public function createDataPanen()
    {
        $provinsis = Provinsi::all();

        $petani = User::where('role', 'user')->get();

        return view('admin.panen.create', compact('provinsis', 'petani'));
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
            'petani' => 'required',
        ], [
            'provinsi.required' => 'Provinsi harus diisi',
            'luas.required' => 'Luas harus diisi',
            'produktivitas.required' => 'Produktivitas harus diisi',
            'produksi.required' => 'Produksi harus diisi',
            'latitude.required' => 'Latitude harus diisi',
            'longitude.required' => 'Longitude harus diisi',
            'petani.required' => 'Petani harus diisi',
        ]);

        $panen = new panen();
        $panen->id_petani = $request->petani;
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
        $petani = User::where('role', 'user')->get();
        return view('admin.panen.edit', compact('panen', 'provinsis', 'petani'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'petani' => 'required',
            'provinsi' => 'required',
            'luas' => 'required',
            'produktivitas' => 'required',
            'produksi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'petani.required' => 'Petani harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'luas.required' => 'Luas harus diisi',
            'produktivitas.required' => 'Produktivitas harus diisi',
            'produksi.required' => 'Produksi harus diisi',
            'latitude.required' => 'Latitude harus diisi',
            'longitude.required' => 'Longitude harus diisi',
        ]);

        $panen = panen::find($id);
        $panen->id_petani = $request->petani;
        $panen->luas_panen = $request->luas;
        $panen->produktivitas = $request->produktivitas;
        $panen->produksi = $request->produksi;
        $panen->id_provinsi = $request->provinsi;
        $panen->latitude = $request->latitude;
        $panen->longitude = $request->longitude;
        $panen->updated_at = now();
        $panen->save();

        return redirect()->route('admin')->with('success', 'Data Panen Berhasil Diubah');
    }

    public function delete($id)
    {
        $panen = panen::find($id);
        $panen->delete();

        return redirect()->route('admin')->with('success', 'Data Panen Berhasil Dihapus');
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function insertUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password tidak sama',
            'password.min' => 'Password minimal berisi 6 karakter',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();

        return redirect()->route('admin')->with('success', 'User Berhasil Ditambahkan');
    }

    public function editUser($id, Request $request)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->updated_at = now();
        $user->save();

        return redirect()->route('admin')->with('success', 'User Berhasil Diubah');
    }

    public function deleteUser($id) {
        $user = User::find($id);

        // delete data panen apabila ada
        $panens = panen::where('id_petani', $id)->get();
        if (!$panens->isEmpty()) {
            foreach ($panens as $panen) {
                $panen->delete();
            }
        }

        $user->delete();

        return redirect()->route('admin')->with('success', 'User Berhasil Dihapus');
    }

}
