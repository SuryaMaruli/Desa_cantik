<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'nama_layanan',
        'kategori',
        'persyaratan',
    ];

    protected $casts = [
        'persyaratan' => 'array',
    ];
}
