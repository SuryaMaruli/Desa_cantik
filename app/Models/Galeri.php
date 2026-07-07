<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use BelongsToVillage;

    protected $primaryKey = 'id_galeri';
    
    protected $fillable = [
        'judul_foto',
        'deskripsi',
        'kategori',
        'tanggal_kegiatan',
        'foto',
        'position',
        'grup_id',
        'grup_order',
        'is_grup_utama',
    ];
    
    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];
}
