<?php

namespace App\Http\Services;

use App\Http\Repositories\KategoriRepository;

class KategoriService
{
    protected $kategoriRepository;

    public function __construct(KategoriRepository $kategoriRepository)
    {
        $this->kategoriRepository = $kategoriRepository;
    }

    public function getAll()
    {
        $data = $this->kategoriRepository->getAll();
        return $data;
    }

    public function getDataById($id)
    {
        $data = $this->kategoriRepository->getDataById($id);
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->kategoriRepository->getPaginate($perData);
        return $data;
    }

    public function simpanPostData($request)
    {
        $validate = $request->validated();
        $data = [true, $this->kategoriRepository->simpan($validate)];
        return $data;
    }

    public function ubahGetData($request)
    {
        $data = $this->kategoriRepository->getDataById($request->id);
        return $data;
    }

    public function perbaruiPostData($request)
    {
        $validate = $request->validated();
        $data = [true, $this->kategoriRepository->perbarui($request->id, $validate)];
        return $data;
    }

    public function hapusPostData($request)
    {
        $data = $this->kategoriRepository->hapus($request);
        return $data;
    }

    public function import($request)
    {
        $data = $this->kategoriRepository->import($request);
        return $data;
    }
}
