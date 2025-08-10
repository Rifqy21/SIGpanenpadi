<?php

namespace App\Http\Controllers;
use App\Models\panen;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();
        $jumlahProvinsi = Provinsi::count();
        // Baca data BPS JSON
        $path = public_path('data/bps.json');
        $dataBps = File::exists($path) ? json_decode(File::get($path), true)['datas'] ?? [] : [];

        // Ambil data panen dari database
        $panens = Panen::all();
        $produksi = $panens->sum('produksi');
        $luas = $panens->sum('luas_panen');
        $produktivitas = $panens->sum('produktivitas');

        // Data grafik per bulan
        $bar_data = [];
        $bar_produktivitas = [];
        for ($i = 1; $i <= 12; $i++) {
            $bar_data[] = Panen::whereMonth('created_at', $i)->sum('produksi');
            $bar_produktivitas[] = Panen::whereMonth('created_at', $i)->sum('produktivitas');
        }

        //  Ambil daftar tahun dari tabel panens
        $tahunList = Panen::selectRaw('YEAR(created_at) as tahun')
        ->distinct()
        ->orderByDesc('tahun')
        ->pluck('tahun');
        $selectedTahun = $tahunList->first(); // Tahun terbaru sebagai default

        return view('admin.index', compact(
        'provinsi',
        'dataBps',
        'produksi',
        'luas',
        'produktivitas',
        'bar_data',
        'bar_produktivitas',
        'tahunList',
        'selectedTahun',
        'jumlahProvinsi'
    ));
    }

public function getStatistikByTahun(Request $request)
{
    $tahun = $request->query('tahun');

    $data = Panen::where('tahun', $tahun)
        ->select(
            'tahun',
            DB::raw('SUM(produksi) as total_produksi'),
            DB::raw('SUM(luas_panen) as total_luas'),
            DB::raw('SUM(produktivitas) as total_produktivitas')
        )
        ->groupBy('tahun')
        ->first();

    return response()->json($data);
}
}