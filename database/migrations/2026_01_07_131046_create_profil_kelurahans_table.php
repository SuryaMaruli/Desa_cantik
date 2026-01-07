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
        Schema::create('profil_kelurahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelurahan');
            $table->string('tahun_pembukaan', 10);
            $table->string('nomor_kode_wilayah', 50);
            $table->string('nomor_kode_pos', 10);
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->text('dasar_hukum_pembentukan');
            $table->string('provinsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_kelurahans');
    }
};
