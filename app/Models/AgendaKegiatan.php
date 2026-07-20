<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Model;

class AgendaKegiatan extends Model
{
    use BelongsToVillage;

    protected $fillable = [
        'nama_kegiatan',
        'tanggal_kegiatan',
        'tempat_kegiatan',
        'jam_kegiatan',
        'keterangan',
        'surat_pendukung',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];
}
