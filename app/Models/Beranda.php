<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'nama_kelurahan',
        'deskripsi',
        'no_hp',
        'email',
        'gambar_header',
        'logo'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
