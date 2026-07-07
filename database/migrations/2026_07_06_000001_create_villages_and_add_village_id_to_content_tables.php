<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $contentTables = [
        'berandas',
        'data_lurahs',
        'profil_kelurahans',
        'beritas',
        'galeris',
        'layanans',
        'penduduks',
        'monografis',
        'prestasis',
        'informasi_publiks',
        'agenda_kegiatans',
        'tentang_desa',
        'metadata_statistik',
        'output_programs',
        'maklumat_pelayananans',
        'struktur_organisasis',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('villages')) {
            Schema::create('villages', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('name');
                $table->string('official_name');
                $table->string('district')->nullable();
                $table->string('city')->nullable();
                $table->string('province')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('map_query')->nullable();
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });
        }

        $now = now();
        $villages = [
            [
                'slug' => 'gunung-sugih',
                'name' => 'Gunung Sugih',
                'official_name' => 'Kelurahan Gunung Sugih',
                'district' => 'Ciwandan',
                'city' => 'Kota Cilegon',
                'province' => 'Banten',
                'postal_code' => '42447',
                'address' => 'Jl. Raya Gunung Sugih No. 123',
                'phone' => '(0254) 123-4567',
                'email' => 'kelurahan@gunungsugih.go.id',
                'map_query' => 'Kantor Kelurahan Gunung Sugih, Cilegon',
                'is_default' => true,
            ],
            [
                'slug' => 'karangasem',
                'name' => 'Karangasem',
                'official_name' => 'Kelurahan Karangasem',
                'district' => 'Ciwandan',
                'city' => 'Kota Cilegon',
                'province' => 'Banten',
                'postal_code' => '42447',
                'address' => 'Jl. Raya Karangasem No. 123',
                'phone' => '(0254) 123-4567',
                'email' => 'kelurahan@karangasem.go.id',
                'map_query' => 'Kantor Kelurahan Karangasem, Cilegon',
                'is_default' => false,
            ],
            [
                'slug' => 'bulakan',
                'name' => 'Bulakan',
                'official_name' => 'Kelurahan Bulakan',
                'district' => 'Bulakan',
                'city' => 'Kota Cilegon',
                'province' => 'Banten',
                'postal_code' => '42441',
                'address' => 'Jl. Raya Bulakan No. 123',
                'phone' => '(0254) 123-4567',
                'email' => 'kelurahan@bulakan.go.id',
                'map_query' => 'Kantor Kelurahan Bulakan, Cilegon',
                'is_default' => false,
            ],
        ];

        foreach ($villages as $village) {
            DB::table('villages')->updateOrInsert(
                ['slug' => $village['slug']],
                $village + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        $defaultVillageId = DB::table('villages')->where('slug', 'gunung-sugih')->value('id');

        foreach ($this->contentTables as $tableName) {
            if (!Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'village_id')) {
                continue;
            }

            $hasIdColumn = Schema::hasColumn($tableName, 'id');

            Schema::table($tableName, function (Blueprint $table) use ($hasIdColumn) {
                $column = $table->foreignId('village_id')->nullable()->index();

                if ($hasIdColumn) {
                    $column->after('id');
                }
            });

            DB::table($tableName)->whereNull('village_id')->update(['village_id' => $defaultVillageId]);
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'village_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('village_id')->nullable()->after('id')->index();
            });

            DB::table('users')->whereNull('village_id')->update(['village_id' => $defaultVillageId]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'village_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('village_id');
            });
        }

        foreach (array_reverse($this->contentTables) as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'village_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('village_id');
            });
        }

        Schema::dropIfExists('villages');
    }
};
