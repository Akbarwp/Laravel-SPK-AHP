<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = Kriteria::orderBy('id')->get();
        $kategori = Kategori::orderBy('id')->get();
        $namaSubKategori = ["AA", "BB", "CC", "DD"];
        $nilaiSubKategori = [1, 3, 5, 0.33, 1, 3, 0.2, 0.33, 1];

        foreach ($kriteria as $kri) {
            $i = 0;
            $j = 0;
            foreach ($kategori as $kat) {
                SubKriteria::create([
                    "nama" => $namaSubKategori[$i],
                    "kriteria_id" => $kri->id,
                    "kategori_id" => $kat->id,
                ]);
                $i++;

                foreach ($kategori as $katBanding) {
                    DB::table('matriks_perbandingan_kriteria')->insert([
                        'nilai' => $nilaiSubKategori[$j],
                        'kriteria_id' => $kri->id,
                        'kategori_id' => $kat->id,
                        'kategori_id_banding' => $katBanding->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    $j++;
                }
            }
            // $this->add_matriks_perbandingan($kri->id);
            $this->matriks_nilai_kriteria($kri->id);
            $this->matriks_penjumlahan_kriteria($kri->id);
        }
    }

    public function add_matriks_perbandingan($kriteria_id)
    {
        $kategori = Kategori::orderBy('id', 'asc')->get();

        foreach ($kategori as $item) {
            foreach ($kategori as $value) {
                $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria')->where('kriteria_id', $kriteria_id)->where('kategori_id', $item->id)->where('kategori_id_banding', $value->id)->first();

                if ($matriksPerbandingan == null) {
                    if ($item->id == $value->id) {
                        DB::table('matriks_perbandingan_kriteria')->insert([
                            'nilai' => 1,
                            'kriteria_id' => $kriteria_id,
                            'kategori_id' => $item->id,
                            'kategori_id_banding' => $value->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    } else {
                        DB::table('matriks_perbandingan_kriteria')->insert([
                            'nilai' => null,
                            'kriteria_id' => $kriteria_id,
                            'kategori_id' => $item->id,
                            'kategori_id_banding' => $value->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }

                } elseif ($matriksPerbandingan->kategori_id_banding != $value->id) {
                    if ($item->id == $value->id) {
                        DB::table('matriks_perbandingan_kriteria')->insert([
                            'nilai' => 1,
                            'kriteria_id' => $kriteria_id,
                            'kategori_id' => $item->id,
                            'kategori_id_banding' => $value->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    } else {
                        DB::table('matriks_perbandingan_kriteria')->insert([
                            'nilai' => null,
                            'kriteria_id' => $kriteria_id,
                            'kategori_id' => $item->id,
                            'kategori_id_banding' => $value->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
    }

    public function matriks_nilai_kriteria($kriteria_id)
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria as mpk')
            ->where('mpk.kriteria_id', $kriteria_id)
            ->orderBy('mpk.kategori_id', 'asc')
            ->orderBy('mpk.kategori_id_banding', 'asc')
            ->get();

        $kategori = Kategori::orderBy('id', 'asc')->get();

        DB::table('matriks_nilai_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        DB::table('matriks_nilai_prioritas_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        foreach ($matriksPerbandingan as $item) {
            $jumlahNilai = $matriksPerbandingan->where('kategori_id_banding', $item->kategori_id_banding)->sum('nilai');

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

            DB::table('matriks_nilai_prioritas_kriteria')->insert([
                'prioritas' => $nilai / $jumlahKriteria,
                'kriteria_id' => $kriteria_id,
                'kategori_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function matriks_penjumlahan_kriteria($kriteria_id)
    {
        $matriksPerbandingan = DB::table('matriks_perbandingan_kriteria as mpk')
            ->where('kriteria_id', $kriteria_id)
            ->orderBy('mpk.kategori_id', 'asc')
            ->orderBy('mpk.kategori_id_banding', 'asc')
            ->get();

        $matriksNilaiPrioritas = DB::table('matriks_nilai_prioritas_kriteria')->where('kriteria_id', $kriteria_id)->get();

        $kategori = Kategori::orderBy('id', 'asc')->get();

        DB::table('matriks_penjumlahan_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        DB::table('matriks_penjumlahan_prioritas_kriteria')->where('kriteria_id', $kriteria_id)->delete();
        foreach ($matriksPerbandingan as $item) {
            $prioritas = $matriksNilaiPrioritas->where('kategori_id', $item->kategori_id_banding)->first()->prioritas;

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

            DB::table('matriks_penjumlahan_prioritas_kriteria')->insert([
                'prioritas' => $nilai / $prioritas,
                'kriteria_id' => $kriteria_id,
                'kategori_id' => $item->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
