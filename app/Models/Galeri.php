<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $primaryKey = 'id_galeri';
    
    protected $fillable = [
        'judul_foto',
        'deskripsi',
        'kategori',
        'tanggal_kegiatan',
        'foto',
    ];
    
    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];
}
