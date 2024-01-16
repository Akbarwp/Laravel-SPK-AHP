<?php

namespace App\Http\Repositories;

use App\Imports\KriteriaImport;
use Carbon\Carbon;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KriteriaRepository
{
    protected $kriteria;

    public function __construct(Kriteria $kriteria)
    {
        $this->kriteria = $kriteria;
    }

    public function getAll()
    {
        $data = $this->kriteria->orderBy('created_at', 'asc')->get();
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->kriteria->paginate($perData);
        return $data;
    }

    public function simpan($data)
    {
        $data = $this->kriteria->create($data);
        DB::table('matriks_perbandingan_utama')->truncate();
        $this->add_matriks_perbandingan();
        $this->add_penilaian_alternatif();

        return $data;
    }

    public function import($data)
    {
        // menangkap file excel
        $file = $data->file('import_data');

        // import data
        $import = Excel::import(new KriteriaImport, $file);

        DB::table('matriks_perbandingan_utama')->truncate();
        $this->add_matriks_perbandingan();
        $this->add_penilaian_alternatif();

        return $import;
    }

    public function add_matriks_perbandingan()
    {
        $kriteria = $this->getAll();
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
        $kriteria = $this->kriteria->all();
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

    public function getDataById($id)
    {
        $data = $this->kriteria->where('id', $id)->firstOrFail();
        return $data;
    }

    public function perbarui($id, $data)
    {
        $data = $this->kriteria->where('id', $id)->update([
            "kode" => $data['kode'],
            "nama" => $data['nama'],
        ]);
        return $data;
    }

    public function hapus($id)
    {
        DB::table('matriks_penjumlahan_prioritas_kriteria')->where('kriteria_id', $id)->delete();
        DB::table('matriks_penjumlahan_kriteria')->where('kriteria_id', $id)->delete();
        DB::table('matriks_nilai_prioritas_kriteria')->where('kriteria_id', $id)->delete();
        DB::table('matriks_nilai_kriteria')->where('kriteria_id', $id)->delete();
        DB::table('matriks_perbandingan_kriteria')->where('kriteria_id', $id)->delete();

        DB::table('matriks_penjumlahan_prioritas_utama')->where('kriteria_id', $id)->delete();
        DB::table('matriks_penjumlahan_utama')->where('kriteria_id', $id)->orWhere('kriteria_id_banding', $id)->delete();
        DB::table('matriks_nilai_prioritas_utama')->where('kriteria_id', $id)->delete();
        DB::table('matriks_nilai_utama')->where('kriteria_id', $id)->orWhere('kriteria_id_banding', $id)->delete();
        DB::table('matriks_perbandingan_utama')->where('kriteria_id', $id)->orWhere('kriteria_id_banding', $id)->delete();

        DB::table('penilaian')->where('kriteria_id', $id)->delete();

        $data = [
            SubKriteria::where('kriteria_id', $id)->delete(),
            $this->kriteria->where('id', $id)->delete(),
        ];
        return $data;
    }
}
