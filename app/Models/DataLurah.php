<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class DataLurah extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'nama_lurah',
        'nip',
        'pangkat',
        'golongan',
        'jabatan',
        'sambutan_lurah',
        'foto_lurah',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
