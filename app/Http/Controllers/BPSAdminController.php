<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;

class BPSAdminController extends Controller
{
    private function getJsonData()
    {
        $bps = public_path('data/bps.json');

        if (file_exists($bps)) {
            $data = file_get_contents($bps);
            $decoded = json_decode($data, true);

            if (!$decoded || !isset($decoded['datas'])) {
                return ['datas' => []];
            }

            return $decoded;
        }

        $initialData = ['datas' => []];
        $this->saveJsonData($initialData);
        return $initialData;
    }

    private function saveJsonData($data)
    {
        $bps = public_path('data/bps.json');
        $directory = dirname($bps);

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($bps, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $provinsis = Provinsi::all();
        $data = $this->getJsonData();
        $dataBps = $data['datas'];

        foreach ($dataBps as $index => $item) {
            if (!isset($item['id']) || empty($item['id'])) {
                $dataBps[$index]['id'] = $index + 1;
            }
        }

        if (count($dataBps) > 0) {
            $data['datas'] = $dataBps;
            $this->saveJsonData($data);
        }

        usort($dataBps, function ($a, $b) {
            return $a['tahun'] <=> $b['tahun'];
        });

        $tahun = array_unique(array_column($dataBps, 'tahun'));
        $tahun = array_values($tahun);

        return view('admin.bps.index', compact('provinsis', 'dataBps', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'luas_panen' => 'required|numeric|min:0',
            'produktifitas' => 'required|numeric|min:0',
            'produksi' => 'required|numeric|min:0',
            'tahun' => 'required|integer|min:2000|max:2030'
        ]);

        $data = $this->getJsonData();

        $newId = 1;
        if (count($data['datas']) > 0) {
            $ids = array_column($data['datas'], 'id');
            $ids = array_filter($ids);
            $newId = count($ids) > 0 ? max($ids) + 1 : 1;
        }

        $newData = [
            'id' => $newId,
            'provinsi' => $request->provinsi,
            'luas_panen' => (float) $request->luas_panen,
            'produktifitas' => (float) $request->produktifitas,
            'produksi' => (float) $request->produksi,
            'tahun' => (int) $request->tahun
        ];

        $data['datas'][] = $newData;
        $this->saveJsonData($data);

        return redirect()->route('bps.index')->with('success', 'Data panen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'luas_panen' => 'required|numeric|min:0',
            'produktifitas' => 'required|numeric|min:0',
            'produksi' => 'required|numeric|min:0',
            'tahun' => 'required|integer|min:2000|max:2030'
        ]);

        $data = $this->getJsonData();

        $found = false;
        foreach ($data['datas'] as $index => $item) {
            if ($item['id'] == $id) {
                $data['datas'][$index] = [
                    'id' => (int) $id,
                    'provinsi' => $request->provinsi,
                    'luas_panen' => (float) $request->luas_panen,
                    'produktifitas' => (float) $request->produktifitas,
                    'produksi' => (float) $request->produksi,
                    'tahun' => (int) $request->tahun
                ];
                $found = true;
                break;
            }
        }

        if (!$found) {
            return redirect()->route('bps.index')->with('error', 'Data tidak ditemukan!');
        }

        $this->saveJsonData($data);

        return redirect()->route('bps.index')->with('success', 'Data panen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = $this->getJsonData();

        $found = false;
        foreach ($data['datas'] as $index => $item) {
            if ($item['id'] == $id) {
                unset($data['datas'][$index]);
                $data['datas'] = array_values($data['datas']);
                $found = true;
                break;
            }
        }

        if (!$found) {
            return redirect()->route('bps.index')->with('error', 'Data tidak ditemukan!');
        }

        $this->saveJsonData($data);

        return redirect()->route('bps.index')->with('success', 'Data panen berhasil dihapus!');
    }

    public function map(Request $request)
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

        return view('admin.bps.map', compact('dataBps', 'years', 'provinsis', 'tahunDipilih'));
    }

    //Hitung batas atas/bawah per tahun
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
