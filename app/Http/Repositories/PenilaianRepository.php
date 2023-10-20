<?php

namespace App\Http\Repositories;

use App\Models\Penilaian;
use Illuminate\Support\Facades\DB;

class PenilaianRepository
{
    protected $penilaian;

    public function __construct(Penilaian $penilaian)
    {
        $this->penilaian = $penilaian;
    }

    public function getAll()
    {
        $data = $this->penilaian->orderBy('created_at', 'asc')->get();
        return $data;
    }

    public function getPaginate($perData)
    {
        $data = $this->penilaian->paginate($perData);
        return $data;
    }

    public function simpan($data)
    {
        $data = $this->penilaian->create($data);
        return $data;
    }

    public function getDataById($id)
    {
        $data = $this->penilaian->where('id', $id)->firstOrFail();
        return $data;
    }

    public function getDataByAlternatifId($id)
    {
        $data = $this->penilaian->where('alternatif_id', $id)->firstOrFail();
        return $data;
    }

    public function perbarui($request)
    {
        foreach ($this->penilaian->where('alternatif_id', $request->alternatif_id)->get() as $item) {
            $this->penilaian->where('alternatif_id', $request->alternatif_id)->where('kriteria_id', $item->kriteria_id)->update([
                'sub_kriteria_id' => $request[$item->kriteria_id],
            ]);
        }
        return true;
    }
}
