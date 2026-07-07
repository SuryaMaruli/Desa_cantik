<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'judul',
        'sub_deskripsi',
        'deskripsi',
    ];
    
    protected $table = 'informasi_publiks';
}
