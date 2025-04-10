<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            IRSeeder::class,
            KriteriaSeeder::class,
            KategoriSeeder::class,
            SubKategoriSeeder::class,
            AlternatifSeeder::class,
        ]);
    }
}
