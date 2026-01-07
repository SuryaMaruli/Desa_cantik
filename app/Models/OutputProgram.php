<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutputProgram extends Model
{
    protected $primaryKey = 'id_program';
    
    protected $fillable = [
        'judul_program',
        'deskripsi_program',
    ];
    
    protected $table = 'output_program';
}
