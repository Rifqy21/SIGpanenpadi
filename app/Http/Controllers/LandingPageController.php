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
    $provinsi = Provinsi::all();

    $bps = public_path('data/bps.json');

    if (file_exists($bps)) {
        $data = file_get_contents($bps);
        $data = json_decode($data, true);
        $dataBps = $data['datas'];
    } else {
        $dataBps = [];
    }

    // Siapkan data grafik
    $labels = [];
    $luasData = [];
    $produksiData = [];
    $produktifitasData = [];

    foreach ($dataBps as $item) {
        $labels[] = $item['provinsi'];
        $luasData[] = $item['luas_panen'];
        $produksiData[] = $item['produksi'];
        $produktifitasData[] = $item['produktifitas'];
    }

    return view('landing', compact('provinsi', 'dataBps', 'labels', 'luasData', 'produksiData', 'produktifitasData'));
}

   public function dataPanen(Request $request)
{
    $provinsi = Provinsi::all();

    $bpsPath = public_path('data/bps.json');
    $dataBps = [];

    if (file_exists($bpsPath)) {
        $jsonContent = file_get_contents($bpsPath);
        $data = json_decode($jsonContent, true);

        if (isset($data['datas'])) {
            $dataBps = $data['datas'];

            // Ambil semua tahun unik dari data
            $tahunList = collect($dataBps)->pluck('tahun')->unique()->sort()->values()->all();

            // Filter berdasarkan tahun jika dikirimkan
            $filterTahun = $request->input('tahun');
            if ($filterTahun && $filterTahun !== 'semua_tahun') {
                $dataBps = array_filter($dataBps, function ($item) use ($filterTahun) {
                    return $item['tahun'] == $filterTahun;
                });
            }

            // Urutkan data berdasarkan tahun (optional)
            usort($dataBps, function ($a, $b) {
                return $a['tahun'] <=> $b['tahun'];
            });
        } else {
            $tahunList = [];
        }
    } else {
        $tahunList = [];
    }

    return view('data_panen', compact('provinsi', 'dataBps', 'tahunList'));
}


        public function bpsMaps(Request $request)
    {
        $provinsis = Provinsi::all();
        $bps = public_path('data/bps.json');
        $dataBps = [];

        if (file_exists($bps)) {
            $data = file_get_contents($bps);
            $data = json_decode($data, true);
            $dataBps = $data['datas'];
        }

        $years = array_unique(array_column($dataBps, 'tahun'));
        sort($years);

        $tahunDipilih = $request->input('tahun');
        if ($tahunDipilih) {
            $dataBps = array_filter($dataBps, function ($item) use ($tahunDipilih) {
                return $item['tahun'] == $tahunDipilih;
            });
            $dataBps = array_values($dataBps);
        }

        return view('bps_maps', compact('dataBps', 'years', 'provinsis', 'tahunDipilih'));
    }

    public function getPanenLimits(Request $request)
{
    $tahun = $request->query('tahun');

    $bps = public_path('data/bps.json');
    if (!file_exists($bps)) {
        return response()->json(['upperLimit' => 0, 'lowerLimit' => 0]);
    }

    $data = json_decode(file_get_contents($bps), true);
    $dataPanen = $data['datas'];

    if ($tahun) {
        $dataPanen = array_filter($dataPanen, function ($item) use ($tahun) {
            return $item['tahun'] == $tahun;
        });
    }

    $produksi = array_column($dataPanen, 'produksi');
    $produksi = array_map('floatval', $produksi);

    if (count($produksi) === 0) {
        return response()->json(['upperLimit' => 0, 'lowerLimit' => 0]);
    }

    $mean = array_sum($produksi) / count($produksi);

    $variance = array_sum(array_map(function ($val) use ($mean) {
        return pow($val - $mean, 2);
    }, $produksi)) / 37;

    $stdDev = sqrt($variance);
    $k = 0.45;

    return response()->json([
        'mean' => $mean,
        'stdDev' => $stdDev,
        'upperLimit' => floor($mean + ($k * $stdDev)),
        'lowerLimit' => floor($mean - ($k * $stdDev)),
    ]);
}

}
