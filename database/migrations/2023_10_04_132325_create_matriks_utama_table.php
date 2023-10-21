<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriks_perbandingan_utama', function (Blueprint $table) {
            $table->id();
            $table->double('nilai')->nullable();
            $table->foreignId("kriteria_id")->constrained("kriteria", "id");
            $table->foreignId("kriteria_id_banding")->constrained("kriteria", "id");
            $table->timestamps();
        });

        Schema::create('matriks_nilai_utama', function (Blueprint $table) {
            $table->id();
            $table->double('nilai');
            $table->foreignId("kriteria_id")->constrained("kriteria", "id");
            $table->foreignId("kriteria_id_banding")->constrained("kriteria", "id");
            $table->timestamps();
        });

        Schema::create('matriks_nilai_prioritas_utama', function (Blueprint $table) {
            $table->id();
            $table->double('prioritas');
            $table->foreignId("kriteria_id")->constrained("kriteria", "id");
            $table->timestamps();
        });

        Schema::create('matriks_penjumlahan_utama', function (Blueprint $table) {
            $table->id();
            $table->double('nilai');
            $table->foreignId("kriteria_id")->constrained("kriteria", "id");
            $table->foreignId("kriteria_id_banding")->constrained("kriteria", "id");
            $table->timestamps();
        });

        Schema::create('matriks_penjumlahan_prioritas_utama', function (Blueprint $table) {
            $table->id();
            $table->double('prioritas');
            $table->foreignId("kriteria_id")->constrained("kriteria", "id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriks_nilai_prioritas_utama');
        Schema::dropIfExists('matriks_nilai_utama');
        Schema::dropIfExists('matriks_penjumlahan_prioritas_utama');
        Schema::dropIfExists('matriks_penjumlahan_utama');
        Schema::dropIfExists('matriks_perbandingan_utama');
    }
};
