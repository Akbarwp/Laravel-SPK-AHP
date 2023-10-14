<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $judul = 'Dashboard';

        $kriteria = Kriteria::get()->count();
        $kategori = Kategori::get()->count();
        $subKriteria = SubKriteria::get()->count();

        return view('dashboard.index', compact('judul', 'kriteria', 'kategori', 'subKriteria'));
    }

    public function profile(Request $request)
    {
        $judul = 'Profile';
        return view('dashboard.profile', [
            'judul' => $judul,
            'user' => auth()->user(),
        ]);
    }
}
