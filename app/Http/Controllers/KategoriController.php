<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Http\Services\KategoriService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected $kategoriService;

    public function __construct(KategoriService $kategoriService)
    {
        $this->kategoriService = $kategoriService;
    }

    public function index()
    {
        $judul = "Kategori";
        $data = $this->kategoriService->getAll();

        return view('dashboard.kategori.index', [
            "judul" => $judul,
            "data" => $data,
        ]);
    }

    public function simpan(KategoriRequest $request)
    {
        $data = $this->kategoriService->simpanPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/kategori')->with('gagal', $data[1]);
        }
        return redirect('dashboard/kategori')->with('berhasil', "Data berhasil disimpan!");
    }

    public function ubah(Request $request)
    {
        $data = $this->kategoriService->ubahGetData($request);
        return $data;
    }

    public function perbarui(KategoriRequest $request)
    {
        $data = $this->kategoriService->perbaruiPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/kategori')->with('gagal', $data[1]);
        }
        return redirect('dashboard/kategori')->with('berhasil', "Data berhasil diperbarui!");
    }

    public function hapus(Request $request)
    {
        $this->kategoriService->hapusPostData($request->id);
        return redirect('dashboard/kategori');
    }

    public function import(Request $request)
    {
        // validasi
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        $this->kategoriService->import($request);

        // alihkan halaman kembali
        return redirect('dashboard/kategori')->with('berhasil', "Data berhasil di import!");
    }
}
