<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $judul = 'Dashboard';

        $kriteria = Kriteria::get();
        $kategori = Kategori::get()->count();
        $subKriteria = SubKriteria::get()->count();
        $alternatif = Alternatif::get();

        $hasilSolusi = DB::table('hasil_solusi_ahp as hsa')
            ->join('alternatif as a', 'a.id', '=', 'hsa.alternatif_id')
            ->select('hsa.*', 'a.nama as nama_alternatif')
            ->get();

        $hasilNilaiData = '';
        foreach ($hasilSolusi as $item) {
            $hasilNilaiData .= number_format($item->nilai, 3) . ", ";
        }
        $hasilNilaiData = rtrim($hasilNilaiData, ", ");

        return view('dashboard.index', compact('judul', 'kriteria', 'kategori', 'subKriteria', 'alternatif', 'hasilSolusi', 'hasilNilaiData'));
    }

    public function profile(Request $request)
    {
        $judul = 'Profile';
        return view('dashboard.profile', [
            'judul' => $judul,
            'user' => auth()->user(),
        ]);
    }
}
