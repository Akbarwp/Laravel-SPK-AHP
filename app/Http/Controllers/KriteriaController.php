<?php

namespace App\Http\Controllers;

use App\Http\Requests\KriteriaRequest;
use App\Http\Services\KriteriaService;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    protected $kriteriaService;

    public function __construct(KriteriaService $kriteriaService)
    {
        $this->kriteriaService = $kriteriaService;
    }

    public function index()
    {
        $judul = "Kriteria";
        $data = $this->kriteriaService->getAll();

        return view('dashboard.kriteria.index', [
            "judul" => $judul,
            "data" => $data,
        ]);
    }

    public function simpan(KriteriaRequest $request)
    {
        $data = $this->kriteriaService->simpanPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/kriteria')->with('gagal', $data[1]);
        }
        return redirect('dashboard/kriteria')->with('berhasil', "Data berhasil disimpan!");
    }

    public function ubah(Request $request)
    {
        $data = $this->kriteriaService->ubahGetData($request);
        return $data;
    }

    public function perbarui(KriteriaRequest $request)
    {
        $data = $this->kriteriaService->perbaruiPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/kriteria')->with('gagal', $data[1]);
        }
        return redirect('dashboard/kriteria')->with('berhasil', "Data berhasil diperbarui!");
    }

    public function hapus(Request $request)
    {
        $this->kriteriaService->hapusPostData($request->id);
        return redirect('dashboard/kriteria');
    }

    public function import(Request $request)
    {
        // validasi
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        $this->kriteriaService->import($request);

        // alihkan halaman kembali
        return redirect('dashboard/kriteria')->with('berhasil', "Data berhasil di import!");
    }
}
