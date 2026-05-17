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
        Schema::create('visitor_stats', function (Blueprint $table) {
            $table->id();
            $table->string('period_type', 20); // weekly, monthly, total
            $table->string('period_key', 20);  // e.g. 2026-W05, 2026-01, total
            $table->unsignedBigInteger('count')->default(0);
            $table->timestamps();

            $table->unique(['period_type', 'period_key']);
            $table->index('period_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_stats');
    }
};
