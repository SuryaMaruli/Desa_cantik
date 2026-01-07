<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'nama_layanan',
        'kategori',
        'persyaratan',
    ];

    protected $casts = [
        'persyaratan' => 'array',
    ];
}
