<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentangDesa extends Model
{
    protected $primaryKey = 'id_tentang';
    
    protected $fillable = [
        'deskripsi',
    ];
    
    protected $table = 'tentang_desa';
}
