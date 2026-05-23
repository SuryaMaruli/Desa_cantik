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
        Schema::table('galeris', function (Blueprint $table) {
            $table->string('grup_id')->nullable()->after('position');
            $table->integer('grup_order')->nullable()->default(0)->after('grup_id');
            $table->boolean('is_grup_utama')->default(false)->after('grup_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->dropColumn(['grup_id', 'grup_order', 'is_grup_utama']);
        });
    }
};
