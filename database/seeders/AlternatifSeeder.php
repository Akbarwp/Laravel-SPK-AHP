<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alternatif::factory(10)->create();
        $this->add_penilaian_alternatif();
        $this->perhitungan_alternatif();
    }

    public function add_penilaian_alternatif()
    {
        $alternatif = Alternatif::orderBy('id', 'asc')->get();
        $kriteria = Kriteria::orderBy('id', 'asc')->get();
        $subKriteria = SubKriteria::orderBy('id', 'asc')->get();
        foreach ($alternatif as $item) {
            foreach ($kriteria as $value) {
                $penilaian = Penilaian::where('alternatif_id', $item->id)->where('kriteria_id', $value->id)->first();
                if ($penilaian == null) {
                    DB::table('penilaian')->insert([
                        'alternatif_id' => $item->id,
                        'kriteria_id' => $value->id,
                        'sub_kriteria_id' => $subKriteria->where('kriteria_id', $value->id)->random()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }

    public function perhitungan_alternatif()
    {
        $penilaian = Penilaian::orderBy('id', 'asc')->get();
        $matriksNilaiKriteria = DB::table('matriks_nilai_prioritas_utama')->get();
        $matriksNilaiSubKriteria = DB::table('matriks_nilai_prioritas_kriteria')->get();

        DB::table('hasil_solusi_ahp')->truncate();
        foreach($penilaian->unique('alternatif_id') as $item) {
            $nilai = 0;
            foreach($penilaian->where('alternatif_id', $item->alternatif_id) as $value) {
                $kriteria = $matriksNilaiKriteria->where('kriteria_id', $value->kriteria_id)->first()->prioritas;
                $subKriteria = $matriksNilaiSubKriteria->where('kriteria_id', $value->kriteria_id)->where('kategori_id', $value->subKriteria->kategori->id)->first();
                $nilai += $kriteria * $subKriteria->prioritas;
            }

            DB::table('hasil_solusi_ahp')->insert([
                'nilai' => $nilai,
                'alternatif_id' => $item->alternatif_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
