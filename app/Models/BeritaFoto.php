<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_id',
        'foto',
        'urutan',
        'is_utama',
    ];

    protected $casts = [
        'is_utama' => 'boolean',
        'urutan' => 'integer',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function getFotoUrlAttribute()
    {
        return asset('storage/berita/' . $this->foto);
    }
}
