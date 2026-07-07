<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class OutputProgram extends Model
{
    use BelongsToVillage;

    protected $primaryKey = 'id_program';
    
    protected $fillable = [
        'judul_program',
        'deskripsi_program',
        'informasi_tambahan',
        'gambar',
    ];
    
    protected $table = 'output_program';
}
