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

        $matriksNilai = DB::table('matriks_nilai_utama as mnu')
            ->join('kriteria as k', 'k.id', '=', 'mnu.kriteria_id')
            ->select('mnu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();
        $matriksPenjumlahan = DB::table('matriks_penjumlahan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

        $matriksPenjumlahanPrioritas = DB::table('matriks_penjumlahan_prioritas_utama')->get();
        $IR = DB::table('index_random_consistency')->where('ukuran_matriks', $kriteria->count())->first()->nilai;

        $hasilSolusi = DB::table('hasil_solusi_ahp as hsa')
            ->join('alternatif as a', 'a.id', '=', 'hsa.alternatif_id')
            ->select('hsa.*', 'a.nama as nama_alternatif')
            ->get();
        $hasilNilaiData = '';
        foreach ($hasilSolusi as $item) {
            $hasilNilaiData .= number_format($item->nilai, 3) . ", ";
        }
        $hasilNilaiData = rtrim($hasilNilaiData, ", ");

        return view('dashboard.index', compact('judul', 'kriteria', 'kategori', 'subKriteria', 'alternatif', 'hasilSolusi', 'hasilNilaiData', 'matriksNilai', 'matriksPenjumlahan', 'matriksPenjumlahanPrioritas', 'IR'));
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
