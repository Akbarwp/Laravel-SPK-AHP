<?php

namespace App\Http\Repositories;

use App\Models\Kategori;
use App\Models\SubKriteria;
use App\Imports\KategoriImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KategoriRepository
{
    protected $kategori;

    public function __construct(Kategori $kategori)
    {
        $this->kategori = $kategori;
    }

    public function getAll()
    {
        $data = $this->kategori->orderBy('created_at', 'asc')->get();
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->kategori->paginate($perData);
        return $data;
    }

    public function simpan($data)
    {
        $data = $this->kategori->create($data);
        return $data;
    }

    public function getDataById($id)
    {
        $data = $this->kategori->where('id', $id)->firstOrFail();
        return $data;
    }

    public function perbarui($id, $data)
    {
        $data = $this->kategori->where('id', $id)->update([
            "nama" => $data['nama'],
        ]);
        return $data;
    }

    public function hapus($id)
    {
        DB::table('matriks_penjumlahan_prioritas_kriteria')->where('kategori_id', $id)->delete();
        DB::table('matriks_penjumlahan_kriteria')->where('kategori_id', $id)->orWhere('kategori_id_banding', $id)->delete();
        DB::table('matriks_nilai_prioritas_kriteria')->where('kategori_id', $id)->delete();
        DB::table('matriks_nilai_kriteria')->where('kategori_id', $id)->orWhere('kategori_id_banding', $id)->delete();
        DB::table('matriks_perbandingan_kriteria')->where('kategori_id', $id)->orWhere('kategori_id_banding', $id)->delete();
        SubKriteria::where('kategori_id', $id)->delete();

        $data = [
            $this->kategori->where('id', $id)->delete(),
        ];
        return $data;
    }

    public function import($data)
    {
        // menangkap file excel
        $file = $data->file('import_data');

        // import data
        $import = Excel::import(new KategoriImport, $file);

        return $import;
    }
}
