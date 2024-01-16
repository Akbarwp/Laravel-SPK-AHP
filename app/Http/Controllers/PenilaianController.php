<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\KategoriService;
use App\Http\Services\KriteriaService;
use App\Http\Services\PenilaianService;
use App\Http\Services\SubKriteriaService;

class PenilaianController extends Controller
{
    protected $penilaianService, $kriteriaService, $subKriteriaService, $kategoriService;

    public function __construct(PenilaianService $penilaianService, KriteriaService $kriteriaService, SubKriteriaService $subKriteriaService, KategoriService $kategoriService)
    {
        $this->penilaianService = $penilaianService;
        $this->kriteriaService = $kriteriaService;
        $this->subKriteriaService = $subKriteriaService;
        $this->kategoriService = $kategoriService;
    }

    public function index()
    {
        $judul = 'Penilaian';
        $kriteria = $this->kriteriaService->getAll();

        $matriksNilaiKriteria = DB::table('matriks_nilai_prioritas_utama as mnu')
            ->join('kriteria as k', 'k.id', '=', 'mnu.kriteria_id')
            ->select('mnu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();
        $matriksNilaiSubKriteria = DB::table('matriks_nilai_prioritas_kriteria as mnk')
            ->join('kategori as k', 'k.id', '=', 'mnk.kategori_id')
            ->select('mnk.*', 'k.id as kategori_id', 'k.nama as nama_kategori')
            ->get();
        if ($matriksNilaiKriteria->where('kriteria_id', $kriteria->last()->id)->first() == null) {
            return redirect('dashboard/kriteria/perhitungan_utama')->with('gagal', 'Perhitungan Kriteria Utama belum tuntas!');
        } else if ($matriksNilaiSubKriteria->where('kriteria_id', $kriteria->last()->id)->first() == null) {
            return redirect('dashboard/sub_kriteria')->with('gagal', 'Perhitungan Sub Kriteria belum tuntas!');
        }

        $data = $this->penilaianService->getAll();
        $kategori = $this->kategoriService->getAll();
        $hasil = DB::table('hasil_solusi_ahp as hsa')
            ->join('alternatif as a', 'a.id', '=', 'hsa.alternatif_id')
            ->select('hsa.*', 'a.nama as nama_alternatif')
            ->get();

        return view('dashboard.penilaian.index', [
            'judul' => $judul,
            'data' => $data,
            'kriteria' => $kriteria,
            'kategori' => $kategori,
            'matriksNilaiKriteria' => $matriksNilaiKriteria,
            'matriksNilaiSubKriteria' => $matriksNilaiSubKriteria,
            'hasil' => $hasil,
        ]);
    }

    public function ubah(Request $request)
    {
        $judul = 'Penilaian Alternatif';

        $subKriteria = $this->subKriteriaService->getAll();
        $data = $this->penilaianService->getDataByAlternatifId($request->alternatif_id);

        return view('dashboard.penilaian.ubahPenilaianAlternatif', [
            'judul' => $judul,
            'data' => $data,
            'subKriteria' => $subKriteria,
        ]);
    }

    public function perbarui(Request $request)
    {
        // dd($request->post());

        $this->penilaianService->perbaruiPostData($request);
        $alternatif = $this->penilaianService->getDataByAlternatifId($request->alternatif_id)->alternatif->nama;
        return redirect('dashboard/penilaian')->with('berhasil', ['Data Penilaian Alternatif telah diperbarui!', $alternatif]);
    }

    public function perhitungan_alternatif()
    {
        $penilaian = $this->penilaianService->getAll();
        if ($penilaian->where('sub_kriteria_id', null)->first() != null) {
            return redirect('dashboard/penilaian')->with('gagal', 'Penilaian Alternatif belum tuntas!');
        }

        $matriksNilaiKriteria = DB::table('matriks_nilai_prioritas_utama')->get();
        $matriksNilaiSubKriteria = DB::table('matriks_nilai_prioritas_kriteria')->get();

        // $data = [];
        DB::table('hasil_solusi_ahp')->truncate();
        foreach($penilaian->unique('alternatif_id') as $item) {
            $nilai = 0;
            foreach($penilaian->where('alternatif_id', $item->alternatif_id) as $value) {
                $kriteria = $matriksNilaiKriteria->where('kriteria_id', $value->kriteria_id)->first()->prioritas;
                $subKriteria = $matriksNilaiSubKriteria->where('kriteria_id', $value->kriteria_id)->where('kategori_id', $value->subKriteria->kategori->id)->first();
                $nilai += $kriteria * $subKriteria->prioritas;

                // $data[] = [
                //     'id' => $penilaian->where('alternatif_id', $item->alternatif_id)->where('kriteria_id', $value->kriteria_id)->first()->id,
                //     'kriteria_id' => $value->kriteria_id,
                //     'kriteria' => $kriteria,
                //     'sub_kriteria_id' => $value->sub_kriteria_id,
                //     'sub_kriteria_nama' => $value->subKriteria->nama,
                //     'sub_kriteria' => $subKriteria->prioritas,
                //     'hasil_kali' => $kriteria * $subKriteria->prioritas,
                // ];
            }
            // $data[] = [
            //     'id' => $penilaian->where('alternatif_id', $item->alternatif_id)->first()->alternatif_id,
            //     'nilai' => $nilai,
            // ];

            DB::table('hasil_solusi_ahp')->insert([
                'nilai' => $nilai,
                'alternatif_id' => $item->alternatif_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // dd($data);

        return redirect('dashboard/penilaian')->with('berhasil', ['Perhitungan AHP Alternatif berhasil!', 0]);
    }

    public function hasil_akhir()
    {
        $judul = 'Hasil Akhir';
        $hasil = DB::table('hasil_solusi_ahp as hsa')
            ->join('alternatif as a', 'a.id', '=', 'hsa.alternatif_id')
            ->select('hsa.*', 'a.nama as nama_alternatif')
            ->orderBy('hsa.nilai', 'desc')
            ->get();
        return view('dashboard.penilaian.hasil', [
            'judul' => $judul,
            'hasil' => $hasil,
        ]);
    }

    public function pdf_ahp()
    {
        $judul = 'Laporan Hasil AHP';
        $kriteria = $this->kriteriaService->getAll();

        $matriksNilaiKriteria = DB::table('matriks_nilai_prioritas_utama as mnu')
            ->join('kriteria as k', 'k.id', '=', 'mnu.kriteria_id')
            ->select('mnu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();
        $matriksNilaiSubKriteria = DB::table('matriks_nilai_prioritas_kriteria as mnk')
            ->join('kategori as k', 'k.id', '=', 'mnk.kategori_id')
            ->select('mnk.*', 'k.id as kategori_id', 'k.nama as nama_kategori')
            ->get();
        if ($matriksNilaiKriteria->where('kriteria_id', $kriteria->last()->id)->first() == null) {
            return redirect('dashboard/kriteria/perhitungan_utama')->with('gagal', 'Perhitungan Kriteria Utama belum tuntas!');
        } else if ($matriksNilaiSubKriteria->where('kriteria_id', $kriteria->last()->id)->first() == null) {
            return redirect('dashboard/sub_kriteria')->with('gagal', 'Perhitungan Sub Kriteria belum tuntas!');
        }

        $data = $this->penilaianService->getAll();
        $kategori = $this->kategoriService->getAll();
        $hasil = DB::table('hasil_solusi_ahp as hsa')
            ->join('alternatif as a', 'a.id', '=', 'hsa.alternatif_id')
            ->select('hsa.*', 'a.nama as nama_alternatif')
            ->get();

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadview('dashboard.pdf.penilaian', [
            'judul' => $judul,
            'data' => $data,
            'kriteria' => $kriteria,
            'kategori' => $kategori,
            'matriksNilaiKriteria' => $matriksNilaiKriteria,
            'matriksNilaiSubKriteria' => $matriksNilaiSubKriteria,
            'hasil' => $hasil,
        ]);

        // return $pdf->download('laporan-penilaian.pdf');
        return $pdf->stream();
    }

    public function pdf_hasil()
    {
        $judul = 'Laporan Hasil Akhir';
        $hasil = DB::table('hasil_solusi_ahp as hsa')
            ->join('alternatif as a', 'a.id', '=', 'hsa.alternatif_id')
            ->select('hsa.*', 'a.nama as nama_alternatif')
            ->orderBy('hsa.nilai', 'desc')
            ->get();

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadview('dashboard.pdf.hasil_akhir', [
            'judul' => $judul,
            'hasil' => $hasil,
        ]);

        // return $pdf->download('laporan-penilaian.pdf');
        return $pdf->stream();
    }
}
