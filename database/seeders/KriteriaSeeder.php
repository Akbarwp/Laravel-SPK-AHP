<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode = ["K00001", "K00002", "K00003"];
        $namaKriteria = ["Harga", "Jumlah Menu", "Popularitas"];
        $nilaiKriteria = [1, 3, 5, 0.33, 1, 3, 0.2, 0.33, 1];

        for ($i = 0; $i < 3; $i++) {
            Kriteria::create([
                "kode" => $kode[$i],
                "nama" => $namaKriteria[$i],
            ]);
        }

        $kriteria = Kriteria::orderBy('id', 'asc')->get();
        $j = 0;
        foreach ($kriteria as $krit) {
            foreach ($kriteria as $kritBanding) {
                DB::table('matriks_perbandingan_utama')->insert([
                    'nilai' => $nilaiKriteria[$j],
                    'kriteria_id' => $krit->id,
                    'kriteria_id_banding' => $kritBanding->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $j++;
            }
        }

        // $this->add_matriks_perbandingan();
        // $this->add_penilaian_alternatif();
        $this->matriks_nilai_utama();
        $this->matriks_penjumlahan_utama();
    }

    public function add_matriks_perbandingan()
    {
        $kriteria = Kriteria::orderBy('id', 'asc')->get();
        foreach ($kriteria as $item) {
            foreach ($kriteria as $value) {
                if ($item->id == $value->id) {
                    DB::table('matriks_perbandingan_utama')->insert([
                        'nilai' => 1,
                        'kriteria_id' => $item->id,
                        'kriteria_id_banding' => $value->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                } else {
                    DB::table('matriks_perbandingan_utama')->insert([
                        'nilai' => null,
                        'kriteria_id' => $item->id,
                        'kriteria_id_banding' => $value->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }

    public function add_penilaian_alternatif()
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::orderBy('id', 'asc')->get();
        foreach ($kriteria as $value) {
            foreach ($alternatif as $item) {
                $penilaian = DB::table('penilaian')->where('alternatif_id', $item->id)->where('kriteria_id', $value->id)->first();
                if ($penilaian == null) {
                    DB::table('penilaian')->insert([
                        'alternatif_id' => $item->id,
                        'kriteria_id' => $value->id,
                        'sub_kriteria_id' => null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }

    public function matriks_nilai_utama()
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_utama as mpu')
            ->join('kriteria as k', 'k.id', '=', 'mpu.kriteria_id')
            ->select('mpu.*', 'k.id as kriteria_id', 'k.nama as nama_kriteria')
            ->orderBy('mpu.kriteria_id', 'asc')
            ->orderBy('mpu.kriteria_id_banding', 'asc')
            ->get();

        $kriteria = Kriteria::orderBy('id', 'asc')->get();

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

        $kriteria = Kriteria::orderBy('id', 'asc')->get();

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
}
