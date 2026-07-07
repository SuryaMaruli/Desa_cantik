<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class MetadataStatistik extends Model
{
    use BelongsToVillage;

    protected $primaryKey = 'id_metadata';
    
    protected $fillable = [
        'nama_metadata',
        'deskripsi',
        'gambar',
        'file_pdf',
        'link',
    ];
    
    protected $table = 'metadata_statistik';
}
