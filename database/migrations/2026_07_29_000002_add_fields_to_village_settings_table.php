<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('village_settings', 'village_id')) {
                $table->foreignId('village_id')->nullable()->after('id')->index();
            }

            if (!Schema::hasColumn('village_settings', 'key')) {
                $table->string('key')->after('village_id');
            }

            if (!Schema::hasColumn('village_settings', 'value')) {
                $table->text('value')->nullable()->after('key');
            }
        });

        Schema::table('village_settings', function (Blueprint $table) {
            $table->unique(['village_id', 'key'], 'village_settings_village_key_unique');
        });
    }

    public function down(): void
    {
        Schema::table('village_settings', function (Blueprint $table) {
            $table->dropUnique('village_settings_village_key_unique');

            if (Schema::hasColumn('village_settings', 'value')) {
                $table->dropColumn('value');
            }

            if (Schema::hasColumn('village_settings', 'key')) {
                $table->dropColumn('key');
            }

            if (Schema::hasColumn('village_settings', 'village_id')) {
                $table->dropColumn('village_id');
            }
        });
    }
};
