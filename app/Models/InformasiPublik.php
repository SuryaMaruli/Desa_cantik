<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    protected $fillable = [
        'judul',
        'sub_deskripsi',
        'deskripsi',
    ];
    
    protected $table = 'informasi_publiks';
}
