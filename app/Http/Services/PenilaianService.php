<?php

namespace App\Http\Services;

use App\Http\Repositories\PenilaianRepository;

class PenilaianService
{
    protected $penilaianRepository;

    public function __construct(PenilaianRepository $penilaianRepository)
    {
        $this->penilaianRepository = $penilaianRepository;
    }

    public function getAll()
    {
        $data = $this->penilaianRepository->getAll();
        return $data;
    }

    public function getDataById($id)
    {
        $data = $this->penilaianRepository->getDataById($id);
        return $data;
    }

    public function getDataByAlternatifId($id)
    {
        $data = $this->penilaianRepository->getDataByAlternatifId($id);
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->penilaianRepository->getPaginate($perData);
        return $data;
    }

    public function perbaruiPostData($request)
    {
        $data = [true, $this->penilaianRepository->perbarui($request)];
        return $data;
    }
}
