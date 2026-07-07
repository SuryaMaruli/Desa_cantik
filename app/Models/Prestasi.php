<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVillage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use BelongsToVillage;

    use HasFactory;

    protected $fillable = [
        'judul',
        'peringkat',
        'tingkat',
        'penyelenggara',
        'tahun',
        'deskripsi',
        'tanggal',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'tanggal' => 'date',
    ];

    public function fotos()
    {
        return $this->hasMany(PrestasiFoto::class)->orderBy('position');
    }
}
