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
        Schema::create('berita_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('beritas')->onDelete('cascade');
            $table->string('foto');
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_utama')->default(false);
            $table->timestamps();

            $table->index(['berita_id', 'urutan']);
            $table->index(['berita_id', 'is_utama']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_fotos');
    }
};
