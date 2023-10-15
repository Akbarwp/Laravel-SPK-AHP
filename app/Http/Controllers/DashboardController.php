<?php

namespace App\Http\Controllers;

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

        return view('dashboard.index', compact('judul', 'kriteria', 'kategori', 'subKriteria', 'matriksNilai', 'matriksPenjumlahan', 'matriksPenjumlahanPrioritas', 'IR'));
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
