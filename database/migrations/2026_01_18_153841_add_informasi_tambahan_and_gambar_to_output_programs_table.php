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
        Schema::table('output_program', function (Blueprint $table) {
            $table->text('informasi_tambahan')->nullable()->after('deskripsi_program');
            $table->string('gambar')->nullable()->after('informasi_tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('output_program', function (Blueprint $table) {
            $table->dropColumn(['informasi_tambahan', 'gambar']);
        });
    }
};
