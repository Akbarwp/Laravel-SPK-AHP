<?php

namespace App\Http\Repositories;

use App\Models\Kategori;
use Carbon\Carbon;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\DB;

class SubKriteriaRepository
{
    protected $subKriteria, $kategori;

    public function __construct(SubKriteria $subKriteria, Kategori $kategori)
    {
        $this->subKriteria = $subKriteria;
        $this->kategori = $kategori;
    }

    public function getAll()
    {
        $data = $this->subKriteria->orderBy('created_at', 'asc')->get();
        return $data;
    }

    public function getWhereKriteria($kriteria_id)
    {
        $data = $this->subKriteria->where('kriteria_id', $kriteria_id)->get();
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->subKriteria->paginate($perData);
        return $data;
    }

    public function simpan($data)
    {
        $subKriteria = $this->subKriteria->where('kriteria_id', $data['kriteria_id'])->where('kategori_id', $data['kategori_id'])->first();
        if ($subKriteria != null) {
            return $data = false;
        }

        $data = $this->subKriteria->create($data);
        $this->add_matriks_perbandingan($data['kriteria_id']);

        return $data;
    }

    public function add_matriks_perbandingan($kriteria_id)
    {
        $kategori = $this->kategori->orderBy('created_at', 'asc')->get();

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

    public function getDataById($id)
    {
        $data = $this->subKriteria->where('id', $id)->firstOrFail();
        return $data;
    }

    public function perbarui($id, $data)
    {
        $data = $this->subKriteria->where('id', $id)->update([
            "nama" => $data['nama'],
            "kategori_id" => $data['kategori_id'],
        ]);
        return $data;
    }

    public function hapus($id)
    {
        $data = [
            $this->subKriteria->where('id', $id)->delete(),
        ];
        return $data;
    }
}
