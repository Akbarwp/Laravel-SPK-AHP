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
        Schema::create('alternatif', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId("alternatif_id")->constrained("alternatif", "id");
            $table->foreignId("kriteria_id")->constrained("kriteria", "id");
            $table->foreignId("sub_kriteria_id")->nullable()->constrained("sub_kriteria", "id");
            $table->timestamps();
        });

        Schema::create('hasil_solusi_ahp', function (Blueprint $table) {
            $table->id();
            $table->double('nilai');
            $table->foreignId("alternatif_id")->constrained("alternatif", "id");
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
        Schema::dropIfExists('hasil_solusi_ahp');
        Schema::dropIfExists('penilaian');
        Schema::dropIfExists('alternatif');
    }
};
