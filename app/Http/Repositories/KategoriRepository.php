<?php

namespace App\Http\Repositories;

use App\Models\Kategori;

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
        $data = [
            $this->kategori->where('id', $id)->delete(),
        ];
        return $data;
    }
}
