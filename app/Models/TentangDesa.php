<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class TentangDesa extends Model
{
    use BelongsToVillage;

    protected $primaryKey = 'id_tentang';
    
    protected $fillable = [
        'deskripsi',
    ];
    
    protected $table = 'tentang_desa';
}
