<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_kelurahan_statistiks', function (Blueprint $table) {
            $table->unsignedSmallInteger('year')->nullable()->after('dataset_key')->index();
        });

        DB::table('data_kelurahan_statistiks')
            ->whereNull('year')
            ->update(['year' => (int) date('Y')]);

        Schema::table('data_kelurahan_statistiks', function (Blueprint $table) {
            $table->dropUnique('data_kelurahan_statistiks_village_id_dataset_key_unique');
            $table->unique(['village_id', 'dataset_key', 'year'], 'data_kelurahan_statistiks_village_dataset_year_unique');
        });
    }

    public function down(): void
    {
        Schema::table('data_kelurahan_statistiks', function (Blueprint $table) {
            $table->dropUnique('data_kelurahan_statistiks_village_dataset_year_unique');
            $table->dropColumn('year');
            $table->unique(['village_id', 'dataset_key']);
        });
    }
};
