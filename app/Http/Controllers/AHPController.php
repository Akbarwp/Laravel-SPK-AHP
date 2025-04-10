<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\KategoriService;
use App\Http\Services\KriteriaService;
use App\Http\Services\SubKriteriaService;

class AHPController extends Controller
{
    protected $kriteriaService, $kategoriService, $subKriteriaService;

    public function __construct(KriteriaService $kriteriaService, KategoriService $kategoriService, SubKriteriaService $subKriteriaService)
    {
        $this->kriteriaService = $kriteriaService;
        $this->kategoriService = $kategoriService;
        $this->subKriteriaService = $subKriteriaService;
    }

    public function index_perhitungan_utama()
    {
        if ($this->kriteriaService->getAll()->count() < 3) {
            return redirect('dashboard/kriteria')->with('gagal', "Kriteria harus lebih dari sama dengan 3!");
        }

        $judul = 'Perhitungan AHP Kriteria Utama';

        $kriteria = $this->kriteriaService->getAll();
        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

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

        // dd($matriksNilai->where('kriteria_id', $kriteria->last()->id)->first());

        return view('dashboard.perhitungan_utama.index', [
            'judul' => $judul,
            'kriteria' => $kriteria,
            'matriksPerbandingan' => $matriksPerbandingan,
            'matriksNilai' => $matriksNilai,
            'matriksPenjumlahan' => $matriksPenjumlahan,
            'matriksPenjumlahanPrioritas' => $matriksPenjumlahanPrioritas,
            'IR' => $IR,
        ]);
    }

    public function ubah_matriks_perbandingan_utama(Request $request)
    {
        $namaKriteria = $this->kriteriaService->getDataById($request->kriteria_id);
        $judul = 'Matriks Perbandingan Utama:';

        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->where('mpu.kriteria_id', '=', $request->kriteria_id)
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

        foreach ($this->kriteriaService->getAll() as $value => $item) {
            if ($matriksPerbandingan[$value]->kriteria_id_banding == $item->id) {
                $matriksPerbandingan[$value]->nama_kriteria_banding = $item->nama;
            }
        }

        // dd($matriksPerbandingan);

        return view('dashboard.perhitungan_utama.ubahMatriksPerbandingan', [
            'judul' => $judul,
            'namaKriteria' => $namaKriteria,
            'matriksPerbandingan' => $matriksPerbandingan,
        ]);
    }

    public function matriks_utama()
    {
        $this->matriks_nilai_utama();
        $this->matriks_penjumlahan_utama();

        return redirect('dashboard/kriteria/perhitungan_utama')->with('berhasil', ["Perhitungan matriks utama berhasil!", 0]);
    }

    public function matriks_perbandingan_utama(Request $request)
    {
        // dd($request->post());

        foreach ($this->kriteriaService->getAll() as $value => $item) {
            DB::table('matriks_perbandingan_utama')->where('kriteria_id', $request->kriteria_id)->where('kriteria_id_banding', $item->id)->update([
                'nilai' => $request->post()[$item->id],
            ]);
        }

        return redirect('dashboard/kriteria/perhitungan_utama')->with('berhasil', ["Matriks Perbandingan berhasil ditambahkan!", $this->kriteriaService->getDataById($request->kriteria_id)->nama]);
    }

    public function matriks_nilai_utama()
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();

        $kriteria = $this->kriteriaService->getAll();

        // $dataNilai = [];
        DB::table('matriks_nilai_utama')->truncate();
        DB::table('matriks_nilai_prioritas_utama')->truncate();
        foreach ($matriksPerbandingan as $item) {
            $jumlahNilai = $matriksPerbandingan->where('kriteria_id_banding', $item->kriteria_id_banding)->sum('nilai');
            // $dataNilai[] = [
            //     'nilai_banding' => $item->nilai,
            //     'jumlah_banding' => $jumlahNilai,
            //     'nilai' => $item->nilai / $jumlahNilai,
            //     'kriteria_id' => $item->kriteria_id,
            //     'kriteria_id_banding' => $item->kriteria_id_banding,
            // ];

            DB::table('matriks_nilai_utama')->insert([
                'nilai' => $item->nilai / $jumlahNilai,
                'kriteria_id' => $item->kriteria_id,
                'kriteria_id_banding' => $item->kriteria_id_banding,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $matriksNilai = DB::table('matriks_nilai_utama as mnu')
            ->join('kriteria as k', 'k.id', '=', 'mnu.kriteria_id')
            ->select('mnu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

        foreach ($kriteria as $item) {
            $nilai = $matriksNilai->where('kriteria_id', $item->id)->sum('nilai');
            $jumlahKriteria = $kriteria->count();

            DB::table('matriks_nilai_prioritas_utama')->insert([
                'prioritas' => $nilai / $jumlahKriteria,
                'kriteria_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        // dd($dataNilai);
        // dd($matriksPerbandingan);
    }

    public function matriks_penjumlahan_utama()
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();

        $matriksNilaiPrioritas = DB::table('matriks_nilai_prioritas_utama as mnpu')
            ->join('kriteria as k', 'k.id', '=', 'mnpu.kriteria_id')
            ->select('mnpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->get();

        $kriteria = $this->kriteriaService->getAll();

        // $dataNilai = [];
        DB::table('matriks_penjumlahan_utama')->truncate();
        DB::table('matriks_penjumlahan_prioritas_utama')->truncate();
        foreach ($matriksPerbandingan as $item) {
            $prioritas = $matriksNilaiPrioritas->where('kriteria_id', $item->kriteria_id_banding)->first()->prioritas;
            // $dataNilai[] = [
            //     'nilai_banding' => $item->nilai,
            //     'prioritas_nilai' => $prioritas,
            //     'nilai' => $item->nilai * $prioritas,
            //     'kriteria_id' => $item->kriteria_id,
            //     'kriteria_id_banding' => $item->kriteria_id_banding,
            // ];

            DB::table('matriks_penjumlahan_utama')->insert([
                'nilai' => $item->nilai * $prioritas,
                'kriteria_id' => $item->kriteria_id,
                'kriteria_id_banding' => $item->kriteria_id_banding,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $matriksPenjumlahan = DB::table('matriks_penjumlahan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();
        // $dataNilai = [];
        foreach ($kriteria as $item) {
            $nilai = $matriksPenjumlahan->where('kriteria_id', $item->id)->sum('nilai');
            $prioritas = $matriksNilaiPrioritas->where('kriteria_id', $item->id)->first()->prioritas;

            // $dataNilai[] = [
            //     'penjumlahan_kriteria' => $nilai,
            //     'prioritas' => $prioritas,
            //     'nilai' => $nilai / $prioritas,
            //     'kriteria_id' => $item->id,
            // ];

            DB::table('matriks_penjumlahan_prioritas_utama')->insert([
                'prioritas' => $nilai / $prioritas,
                'kriteria_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        // dd($dataNilai);
        // dd($matriksPerbandingan);
    }

    //? Sub Kriteria
    public function index_perhitungan_kriteria(Request $request)
    {
        $judul = 'Perhitungan AHP Per Kriteria:';
        $kriteria = $this->kriteriaService->getDataById($request->kriteria_id);
        $kategori = $this->kategoriService->getAll();
        $subKriteria = $this->subKriteriaService->getWhereKriteria($request->kriteria_id);

        if ($subKriteria->count() != $kategori->count()) {
            return redirect('dashboard/sub_kriteria')->with('gagal', "Sub Kriteria pada Kriteria:". $kriteria->nama ." belum lengkap!");
        }

        $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria as mpk')
            ->join('kategori as k', 'k.id', '=', 'mpk.kategori_id')
            ->where('kriteria_id', $request->kriteria_id)
            ->select('mpk.*', 'k.id as kategori_id', 'k.nama as nama_kategori')
            ->orderBy('mpk.id', 'asc')
            ->get();

        $matriksNilai = DB::table('matriks_nilai_kriteria as mnk')
            ->join('kategori as k', 'k.id', '=', 'mnk.kategori_id')
            ->where('kriteria_id', $request->kriteria_id)
            ->select('mnk.*', 'k.id as kategori_id', 'k.nama as nama_kategori')
            ->get();

        $matriksPenjumlahan = DB::table('matriks_penjumlahan_kriteria as mpk')
            ->join('kategori as k', 'k.id', '=', 'mpk.kategori_id')
            ->where('kriteria_id', $request->kriteria_id)
            ->select('mpk.*', 'k.id as kategori_id', 'k.nama as nama_kategori')
            ->get();

        $matriksPenjumlahanPrioritas = DB::table('matriks_penjumlahan_prioritas_kriteria')->where('kriteria_id', $request->kriteria_id)->get();
        $IR = DB::table('index_random_consistency')->where('ukuran_matriks', $kategori->count())->first()->nilai;

        // dd($matriksNilai->where('kategori_id', $kategori->last()->id)->first());

        return view('dashboard.sub_kriteria.perhitungan_kriteria.perhitungan', [
            'judul' => $judul,
            'kriteria' => $kriteria,
            'kategori' => $kategori,
            'matriksPerbandingan' => $matriksPerbandingan,
            'matriksNilai' => $matriksNilai,
            'matriksPenjumlahan' => $matriksPenjumlahan,
            'matriksPenjumlahanPrioritas' => $matriksPenjumlahanPrioritas,
            'IR' => $IR,
        ]);
    }

    public function ubah_matriks_perbandingan_kriteria(Request $request)
    {
        $judul = 'Matriks Perbandingan Utama:';

        $kategori = $this->kategoriService->getDataById($request->kategori_id);
        $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria as mpk')
            ->join('kategori as k', 'k.id', '=', 'mpk.kategori_id')
            ->where('kriteria_id', $request->kriteria_id)
            ->where('kategori_id', $request->kategori_id)
            ->select('mpk.*', 'k.id as kategori_id', 'k.nama as nama_kategori')
            ->get();

        foreach ($this->kategoriService->getAll() as $value => $item) {
            if ($matriksPerbandingan[$value]->kategori_id_banding == $item->id) {
                $matriksPerbandingan[$value]->nama_kategori_banding = $item->nama;
            }
        }

        return view('dashboard.sub_kriteria.perhitungan_kriteria.ubahMatriksPerbandingan', [
            'judul' => $judul,
            'kategori' => $kategori,
            'matriksPerbandingan' => $matriksPerbandingan,
        ]);
    }

    public function matriks_kriteria(Request $request)
    {
        $this->matriks_nilai_kriteria($request->kriteria_id);
        $this->matriks_penjumlahan_kriteria($request->kriteria_id);

        $kriteria = $this->kriteriaService->getDataById($request->kriteria_id);
        return redirect('dashboard/sub_kriteria/perhitungan_kriteria/' . $request->kriteria_id)->with('berhasil', ["Perhitungan matriks kriteria ". $kriteria->nama ." berhasil!", 0]);
    }

    public function matriks_perbandingan_kriteria(Request $request)
    {
        // dd($request->post());

        foreach ($this->kategoriService->getAll() as $value => $item) {
            DB::table('matriks_perbandingan_kriteria')
                ->where('kriteria_id', $request->kriteria_id)
                ->where('kategori_id', $request->kategori_id)
                ->where('kategori_id_banding', $item->id)
                ->update([
                'nilai' => $request->post()[$item->id],
            ]);
        }

        return redirect('dashboard/sub_kriteria/perhitungan_kriteria/' . $request->kriteria_id)->with('berhasil', ["Matriks Perbandingan berhasil ditambahkan!", $this->kategoriService->getDataById($request->kategori_id)->nama]);
    }

    public function matriks_nilai_kriteria($kriteria_id)
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria as mpk')
            ->where('mpk.kriteria_id', $kriteria_id)
            ->orderBy('mpk.kategori_id', 'asc')
            ->orderBy('mpk.kategori_id_banding', 'asc')
            ->get();

        $kategori = $this->kategoriService->getAll();

        // $dataNilai = [];
        DB::table('matriks_nilai_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        DB::table('matriks_nilai_prioritas_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        foreach ($matriksPerbandingan as $item) {
            $jumlahNilai = $matriksPerbandingan->where('kategori_id_banding', $item->kategori_id_banding)->sum('nilai');
            // $dataNilai[] = [
            //     'nilai_banding' => $item->nilai,
            //     'jumlah_banding' => $jumlahNilai,
            //     'nilai' => $item->nilai / $jumlahNilai,
            //     'kriteria_id' => $item->kriteria_id,
            //     'kategori_id' => $item->kategori_id,
            //     'kategori_id_banding' => $item->kategori_id_banding,
            // ];

            DB::table('matriks_nilai_kriteria')->insert([
                'nilai' => $item->nilai / $jumlahNilai,
                'kriteria_id' => $item->kriteria_id,
                'kategori_id' => $item->kategori_id,
                'kategori_id_banding' => $item->kategori_id_banding,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $matriksNilai = DB::table('matriks_nilai_kriteria as mnk')->where('kriteria_id', $kriteria_id)->get();

        foreach ($kategori as $item) {
            $nilai = $matriksNilai->where('kategori_id', $item->id)->sum('nilai');
            $jumlahKriteria = $kategori->count();

            // $dataNilai[] = [
            //     'prioritas' => $nilai / $jumlahKriteria,
            //     'kriteria_id' => $kriteria_id,
            //     'kategori_id' => $item->id,
            // ];

            DB::table('matriks_nilai_prioritas_kriteria')->insert([
                'prioritas' => $nilai / $jumlahKriteria,
                'kriteria_id' => $kriteria_id,
                'kategori_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        // dd($dataNilai);
        // dd($matriksPerbandingan);
    }

    public function matriks_penjumlahan_kriteria($kriteria_id)
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria as mpk')
            ->where('kriteria_id', $kriteria_id)
            ->orderBy('mpk.kategori_id', 'asc')
            ->orderBy('mpk.kategori_id_banding', 'asc')
            ->get();

        $matriksNilaiPrioritas = DB::table('matriks_nilai_prioritas_kriteria')->where('kriteria_id', $kriteria_id)->get();

        $kategori = $this->kategoriService->getAll();

        // $dataNilai = [];
        DB::table('matriks_penjumlahan_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        DB::table('matriks_penjumlahan_prioritas_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        foreach ($matriksPerbandingan as $item) {
            $prioritas = $matriksNilaiPrioritas->where('kategori_id', $item->kategori_id_banding)->first()->prioritas;

            // $dataNilai[] = [
            //     'nilai_banding' => $item->nilai,
            //     'prioritas_nilai' => $prioritas,
            //     'nilai' => $item->nilai * $prioritas,
            //     'kriteria_id' => $item->kriteria_id,
            //     'kriteria_id_banding' => $item->kriteria_id_banding,
            // ];

            DB::table('matriks_penjumlahan_kriteria')->insert([
                'nilai' => $item->nilai * $prioritas,
                'kriteria_id' => $item->kriteria_id,
                'kategori_id' => $item->kategori_id,
                'kategori_id_banding' => $item->kategori_id_banding,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $matriksPenjumlahan = DB::table('matriks_penjumlahan_kriteria as mpk')
            ->where('kriteria_id', $kriteria_id)
            ->orderBy('mpk.kategori_id', 'asc')
            ->orderBy('mpk.kategori_id_banding', 'asc')
            ->get();

        foreach ($kategori as $item) {
            $nilai = $matriksPenjumlahan->where('kategori_id', $item->id)->sum('nilai');
            $prioritas = $matriksNilaiPrioritas->where('kategori_id', $item->id)->first()->prioritas;

            // $dataNilai[] = [
            //     'penjumlahan_kriteria' => $nilai,
            //     'prioritas' => $prioritas,
            //     'nilai' => $nilai / $prioritas,
            //     'kriteria_id' => $item->id,
            // ];

            DB::table('matriks_penjumlahan_prioritas_kriteria')->insert([
                'prioritas' => $nilai / $prioritas,
                'kriteria_id' => $kriteria_id,
                'kategori_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        // dd($dataNilai);
        // dd($matriksPerbandingan);
    }
}
