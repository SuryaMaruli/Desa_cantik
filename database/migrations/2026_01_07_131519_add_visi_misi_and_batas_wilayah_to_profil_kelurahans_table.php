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
        Schema::table('profil_kelurahans', function (Blueprint $table) {
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->string('wilayah_utara')->nullable();
            $table->string('wilayah_timur')->nullable();
            $table->string('wilayah_selatan')->nullable();
            $table->string('wilayah_barat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_kelurahans', function (Blueprint $table) {
            $table->dropColumn(['visi', 'misi', 'wilayah_utara', 'wilayah_timur', 'wilayah_selatan', 'wilayah_barat']);
        });
    }
};
