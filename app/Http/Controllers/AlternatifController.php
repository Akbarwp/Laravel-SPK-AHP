<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AlternatifRequest;
use App\Http\Services\AlternatifService;

class AlternatifController extends Controller
{
    protected $alternatifService;

    public function __construct(AlternatifService $alternatifService)
    {
        $this->alternatifService = $alternatifService;
    }

    public function index()
    {
        $judul = 'Alternatif';
        $data = $this->alternatifService->getAll();

        return view('dashboard.alternatif.index', compact('judul', 'data'));
    }

    public function simpan(AlternatifRequest $request)
    {
        $data = $this->alternatifService->simpanPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/alternatif')->with('gagal', $data[1]);
        }
        return redirect('dashboard/alternatif')->with('berhasil', "Data berhasil disimpan!");
    }

    public function ubah(Request $request)
    {
        $data = $this->alternatifService->ubahGetData($request);
        return $data;
    }

    public function perbarui(AlternatifRequest $request)
    {
        $data = $this->alternatifService->perbaruiPostData($request);
        if (!$data[0]) {
            return redirect('dashboard/alternatif')->with('gagal', $data[1]);
        }
        return redirect('dashboard/alternatif')->with('berhasil', "Data berhasil diperbarui!");
    }

    public function hapus(Request $request)
    {
        $this->alternatifService->hapusPostData($request->id);
        return redirect('dashboard/alternatif');
    }

    public function import(Request $request)
    {
        // validasi
        $request->validate([
            'import_data' => 'required|mimes:xls,xlsx'
        ]);

        $this->alternatifService->import($request);

        // alihkan halaman kembali
        return redirect('dashboard/alternatif')->with('berhasil', "Data berhasil di import!");
    }
}
