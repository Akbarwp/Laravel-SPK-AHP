<?php

namespace App\Http\Services;

use App\Http\Repositories\AlternatifRepository;

class AlternatifService
{
    protected $alternatifRepository;

    public function __construct(AlternatifRepository $alternatifRepository)
    {
        $this->alternatifRepository = $alternatifRepository;
    }

    public function getAll()
    {
        $data = $this->alternatifRepository->getAll();
        return $data;
    }

    public function getDataById($id)
    {
        $data = $this->alternatifRepository->getDataById($id);
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->alternatifRepository->getPaginate($perData);
        return $data;
    }

    public function simpanPostData($request)
    {
        $validate = $request->validated();
        $data = [true, $this->alternatifRepository->simpan($validate)];
        return $data;
    }

    public function ubahGetData($request)
    {
        $data = $this->alternatifRepository->getDataById($request->id);
        return $data;
    }

    public function perbaruiPostData($request)
    {
        $validate = $request->validated();
        $data = [true, $this->alternatifRepository->perbarui($request->id, $validate)];
        return $data;
    }

    public function hapusPostData($request)
    {
        $data = $this->alternatifRepository->hapus($request);
        return $data;
    }

    public function import($request)
    {
        $data = $this->alternatifRepository->import($request);
        return $data;
    }
}
