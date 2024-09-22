<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Alternatif;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123'),
        ]);

        // $kode = ["A", "B", "C"];
        // $namaKriteria = ["Harga", "Jumlah Menu", "Popularitas"];
        // for ($i = 0; $i < 3; $i++) {
        //     Kriteria::create([
        //         "kode" => $kode[$i],
        //         "nama" => $namaKriteria[$i],
        //     ]);
        // }

        // $namaKategori = ["Baik", "Cukup", "Kurang"];
        // for ($i = 0; $i < 4; $i++) {
        //     Kategori::create([
        //         "nama" => $namaKategori[$i],
        //     ]);
        // }

        // $namaSubKategori = ["AA", "BB", "CC", "DD"];
        // for ($j = 0; $j < 3; $j++) {
        //     for ($i = 0; $i < 4; $i++) {
        //         SubKriteria::create([
        //             "nama" => $namaSubKategori[$i],
        //             "kriteria_id" => $j+1,
        //             "kategori_id" => $i+1,
        //         ]);
        //     }
        // }

        $nilaiIR = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];
        for ($i = 0; $i < 15; $i++) {
            DB::table('index_random_consistency')->insert([
                "ukuran_matriks" => $i+1,
                "nilai" => $nilaiIR[$i],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }

        Alternatif::factory(10)->create();
    }
}
