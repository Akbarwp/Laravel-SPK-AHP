<?php

namespace App\Http\Services;

use App\Http\Repositories\KriteriaRepository;

class KriteriaService
{
    protected $kriteriaRepository, $penilaianRepository;

    public function __construct(KriteriaRepository $kriteriaRepository)
    {
        $this->kriteriaRepository = $kriteriaRepository;
    }

    public function getAll()
    {
        $data = $this->kriteriaRepository->getAll();
        return $data;
    }

    public function getDataById($id)
    {
        $data = $this->kriteriaRepository->getDataById($id);
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->kriteriaRepository->getPaginate($perData);
        return $data;
    }

    public function simpanPostData($request)
    {
        $validate = $request->validated();
        $data = [true, $this->kriteriaRepository->simpan($validate)];
        return $data;
    }

    public function ubahGetData($request)
    {
        $data = $this->kriteriaRepository->getDataById($request->id);
        return $data;
    }

    public function perbaruiPostData($request)
    {
        $validate = $request->validated();
        $data = [true, $this->kriteriaRepository->perbarui($request->id, $validate)];
        return $data;
    }

    public function hapusPostData($request)
    {
        $data = $this->kriteriaRepository->hapus($request);
        return $data;
    }

    public function import($request)
    {
        $data = $this->kriteriaRepository->import($request);
        return $data;
    }
}
