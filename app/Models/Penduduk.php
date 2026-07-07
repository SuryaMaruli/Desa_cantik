<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'status',
        'rw'
    ];
}
