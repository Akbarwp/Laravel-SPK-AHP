<?php

use App\Http\Controllers\AHPController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    'middleware' => 'guest'

], function() {
    Route::get('/', [AuthenticatedSessionController::class, 'create']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create']);
    Route::get('/register', [RegisteredUserController::class, 'create']);
});

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'dashboard',

], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [DashboardController::class, 'profile'])->name('profile');

    Route::group([
        'prefix' => 'kriteria'
    ], function () {
        Route::get('/', [KriteriaController::class, 'index'])->name('kriteria');
        Route::post('/simpan', [KriteriaController::class, 'simpan'])->name('kriteria.simpan');
        Route::get('/ubah', [KriteriaController::class, 'ubah'])->name('kriteria.ubah');
        Route::post('/ubah', [KriteriaController::class, 'perbarui'])->name('kriteria.perbarui');
        Route::post('/hapus', [KriteriaController::class, 'hapus'])->name('kriteria.hapus');

        Route::get('/perhitungan_utama', [AHPController::class, 'index_perhitungan_utama'])->name('perhitungan_utama');
        Route::get('/matriks_perbandingan/{kriteria_id}', [AHPController::class, 'ubah_matriks_perbandingan_utama'])->name('matriks_perbandingan_utama.ubah');
        Route::post('/matriks_perbandingan', [AHPController::class, 'matriks_perbandingan_utama'])->name('matriks_perbandingan_utama.hitung');
        Route::post('/matriks_utama', [AHPController::class, 'matriks_utama'])->name('matriks_utama.hitung');
    });

    Route::group([
        'prefix' => 'kategori'
    ], function () {
        Route::get('/', [KategoriController::class, 'index'])->name('kategori');
        Route::post('/simpan', [KategoriController::class, 'simpan'])->name('kategori.simpan');
        Route::get('/ubah', [KategoriController::class, 'ubah'])->name('kategori.ubah');
        Route::post('/ubah', [KategoriController::class, 'perbarui'])->name('kategori.perbarui');
        Route::post('/hapus', [KategoriController::class, 'hapus'])->name('kategori.hapus');
    });

    Route::group([
        'prefix' => 'sub_kriteria'
    ], function () {
        Route::get('/', [SubKriteriaController::class, 'index'])->name('sub_kriteria');
        Route::post('/simpan', [SubKriteriaController::class, 'simpan'])->name('sub_kriteria.simpan');
        Route::get('/ubah', [SubKriteriaController::class, 'ubah'])->name('sub_kriteria.ubah');
        Route::post('/ubah', [SubKriteriaController::class, 'perbarui'])->name('sub_kriteria.perbarui');
        Route::post('/hapus', [SubKriteriaController::class, 'hapus'])->name('sub_kriteria.hapus');

        Route::get('/perhitungan_kriteria/{kriteria_id}', [AHPController::class, 'index_perhitungan_kriteria'])->name('perhitungan_kriteria.ubah');
        Route::get('/matriks_perbandingan/{kriteria_id}/{kategori_id}', [AHPController::class, 'ubah_matriks_perbandingan_kriteria'])->name('matriks_perbandingan_kriteria.ubah');
        Route::post('/matriks_perbandingan/{kriteria_id}', [AHPController::class, 'matriks_perbandingan_kriteria'])->name('matriks_perbandingan_kriteria.hitung');
        Route::post('/matriks_kriteria/{kriteria_id}', [AHPController::class, 'matriks_kriteria'])->name('matriks_kriteria.hitung');
    });
});

require __DIR__.'/auth.php';
