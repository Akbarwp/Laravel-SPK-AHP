<?php

namespace App\Http\Repositories;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        return $data;
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

        $data = [
            SubKriteria::where('kriteria_id', $id)->delete(),
            $this->kriteria->where('id', $id)->delete(),
        ];
        return $data;
    }
}
