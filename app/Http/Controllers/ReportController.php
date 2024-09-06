<?php

namespace App\Http\Controllers;

use App\Models\panen;
use App\Models\Provinsi;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSXGen;

class ReportController extends Controller
{
    public function index()
    {

        $reports = Report::all();

        $tahun = $reports->pluck('year');

        // unique the tahun
        $tahun = $tahun->unique();
        // sort the tahun
        $tahun = $tahun->sort();

        $panens = panen::all();

        // get all the year from panen updated_at
        $tahunPanen = $panens->pluck('updated_at')->map(function ($item) {
            return $item->format('Y');
        });

        // unique the tahunPanen
        $tahunPanen = $tahunPanen->unique();
        // sort the tahunPanen
        $tahunPanen = $tahunPanen->sort();

        return view('admin.report.index', compact('reports', 'tahun', 'tahunPanen'));
    }

    public function generateLaporan(Request $request)
    {

        $request->validate([
            "title" => "required",
            "description" => "required",
            "tahun" => "required",
        ], [
            "title.required" => "Judul laporan harus diisi",
            "description.required" => "Deskripsi laporan harus diisi",
            "tahun.required" => "Tahun laporan harus diisi",
        ]);

        // get all panen where updated_at year is equal to $request->tahun
        $panens = panen::whereYear('updated_at', $request->tahun)->get();

        $provinsis = Provinsi::all();

        $books = [
            ['Luas Panen, Produksi, dan Produktivitas Padi Menurut Provinsi Tahun: ' . $request->tahun],
            ['38 Provinsi', 'Luas panen (Ha)', 'Produktivitas (Ku/Ha)', 'Produksi (ton)'],
        ];

        $allLuasPanen = 0;
        $allProduktivitas = 0;
        $allProduksi = 0;
        foreach($provinsis as $province) {
            $luasPanen = 0;
            $produktivitas = 0;
            $produksi = 0;

            foreach($panens as $panen) {
                if($panen->id_provinsi == $province->id) {
                    $luasPanen += $panen->luas_panen;
                    $produktivitas += $panen->produktivitas;
                    $produksi += $panen->produksi;
                    $allLuasPanen += $panen->luas_panen;
                    $allProduktivitas += $panen->produktivitas;
                    $allProduksi += $panen->produksi;
                }
            }
            $books[] = [$province->nama_provinsi, $luasPanen, $produktivitas, $produksi];
        
        }

        $books[] = ['Indonesia', $allLuasPanen, $allProduktivitas, $allProduksi];

        $xlsx = SimpleXLSXGen::fromArray($books);

        // create a name of excel file with title and tahun and unique it
        $filename = $request->title . ' ' . $request->tahun . uniqid() . '.xlsx';
        $xlsx->saveAs('assets/reports/' . $filename);

        Report::create([
            "title" => $request->title,
            "description" => $request->description,
            "year" => $request->tahun,
            "file" => $filename,
            "user_id" => Auth::user()->id,
        ]);

        return redirect()->route('admin.report.index')->with('success', 'Laporan berhasil dibuat');
    }

    public function delete($id)
    {
        $report = Report::find($id);

        if($report) {
            unlink('assets/reports/' . $report->file);
            $report->delete();
            return redirect()->route('admin.report.index')->with('success', 'Laporan berhasil dihapus');
        }
        

        return redirect()->route('admin.report.index')->with('error', 'Laporan tidak ditemukan');
    }
}
