<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaKegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'tanggal_kegiatan',
        'tempat_kegiatan',
        'jam_kegiatan',
        'surat_pendukung',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];
}
