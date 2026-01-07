<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tentang_desa', function (Blueprint $table) {
            $table->id('id_tentang');
            $table->text('deskripsi');
            $table->timestamps();
        });

        Schema::create('metadata_statistik', function (Blueprint $table) {
            $table->id('id_metadata');
            $table->string('nama_metadata');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        Schema::create('output_program', function (Blueprint $table) {
            $table->id('id_program');
            $table->string('judul_program');
            $table->text('deskripsi_program');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tentang_desa');
        Schema::dropIfExists('metadata_statistik');
        Schema::dropIfExists('output_program');
    }
};
