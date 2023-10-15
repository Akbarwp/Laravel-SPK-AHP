<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\SubKriteriaService;
use App\Http\Requests\SubKriteriaStoreRequest;
use App\Http\Requests\SubKriteriaUpdateRequest;
use App\Http\Services\KategoriService;
use App\Http\Services\KriteriaService;

class SubKriteriaController extends Controller
{
    protected $subKriteriaService, $kriteriaService, $kategoriService;

    public function __construct(SubKriteriaService $subKriteriaService, KriteriaService $kriteriaService, KategoriService $kategoriService)
    {
        $this->subKriteriaService = $subKriteriaService;
        $this->kriteriaService = $kriteriaService;
        $this->kategoriService = $kategoriService;
    }

    public function index()
    {
        if ($this->kategoriService->getAll()->count() < 3) {
            return redirect('dashboard/kategori')->with('gagal', "Kategori harus lebih dari sama dengan 3!");
        }

        $judul = "Sub Kriteria";
        $kriteria = $this->kriteriaService->getAll();
        $kategori = $this->kategoriService->getAll();
        $subKriteria = $this->subKriteriaService->getAll();

        $data = null;
        foreach ($kriteria as $item) {
            $data[] = [
                'kriteria_id' => $item->id,
                'kriteria' => $item->nama,
                'sub_kriteria' => $this->subKriteriaService->getWhereKriteria($item->id),
            ];
        }

        // dd($data);

        return view('dashboard.sub_kriteria.index', [
            "judul" => $judul,
            "data" => $data,
            "kategori" => $kategori,
            "subKriteria" => $subKriteria,
        ]);
    }

    public function simpan(SubKriteriaStoreRequest $request)
    {
        $data = $this->subKriteriaService->simpanPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/sub_kriteria')->with('gagal', $data[1]);
        }
        return redirect('dashboard/sub_kriteria')->with('berhasil', "Data berhasil disimpan!");
    }

    public function ubah(Request $request)
    {
        $data = $this->subKriteriaService->ubahGetData($request);
        return $data;
    }

    public function perbarui(SubKriteriaUpdateRequest $request)
    {
        $data = $this->subKriteriaService->perbaruiPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/sub_kriteria')->with('gagal', $data[1]);
        }
        return redirect('dashboard/sub_kriteria')->with('berhasil', "Data berhasil diperbarui!");
    }

    public function hapus(Request $request)
    {
        $this->subKriteriaService->hapusPostData($request->id);
        return redirect('dashboard/sub_kriteria');
    }
}
