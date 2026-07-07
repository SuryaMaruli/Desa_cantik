<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('villages')->where('slug', 'citangkil')->update([
            'slug' => 'bulakan',
            'name' => 'Bulakan',
            'official_name' => 'Kelurahan Bulakan',
            'district' => 'Bulakan',
            'address' => 'Jl. Raya Bulakan No. 123',
            'email' => 'kelurahan@bulakan.go.id',
            'map_query' => 'Kantor Kelurahan Bulakan, Cilegon',
        ]);

        DB::table('villages')->where('slug', 'kepuh')->update([
            'slug' => 'karangasem',
            'name' => 'Karangasem',
            'official_name' => 'Kelurahan Karangasem',
            'address' => 'Jl. Raya Karangasem No. 123',
            'email' => 'kelurahan@karangasem.go.id',
            'map_query' => 'Kantor Kelurahan Karangasem, Cilegon',
        ]);
    }

    public function down(): void
    {
        DB::table('villages')->where('slug', 'bulakan')->update([
            'slug' => 'citangkil',
            'name' => 'Citangkil',
            'official_name' => 'Kelurahan Citangkil',
            'district' => 'Citangkil',
            'address' => 'Jl. Raya Citangkil No. 123',
            'email' => 'kelurahan@citangkil.go.id',
            'map_query' => 'Kantor Kelurahan Citangkil, Cilegon',
        ]);

        DB::table('villages')->where('slug', 'karangasem')->update([
            'slug' => 'kepuh',
            'name' => 'Kepuh',
            'official_name' => 'Kelurahan Kepuh',
            'address' => 'Jl. Raya Kepuh No. 123',
            'email' => 'kelurahan@kepuh.go.id',
            'map_query' => 'Kantor Kelurahan Kepuh, Cilegon',
        ]);
    }
};
