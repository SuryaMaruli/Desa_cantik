<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataStatistik extends Model
{
    protected $primaryKey = 'id_metadata';
    
    protected $fillable = [
        'nama_metadata',
        'deskripsi',
        'gambar',
    ];
    
    protected $table = 'metadata_statistik';
}
