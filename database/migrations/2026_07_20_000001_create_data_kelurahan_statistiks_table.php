<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_kelurahan_statistiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->nullable()->index();
            $table->string('subject_key');
            $table->string('dataset_key');
            $table->string('parent_key')->nullable();
            $table->string('label');
            $table->decimal('value', 20, 2)->nullable();
            $table->timestamps();

            $table->unique(['village_id', 'dataset_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_kelurahan_statistiks');
    }
};
