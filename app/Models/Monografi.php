<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Monografi extends Model
{
    use HasFactory;

    protected $table = 'monografis';
    
    // === KONFIGURASI KUNCI ===
    // Karena nama kolom di database adalah 'id_monografi'
    protected $primaryKey = 'id_monografi'; 
    
    // Pastikan type-nya integer dan auto-increment (default true)
    public $incrementing = true; 
    protected $keyType = 'int';
    // =========================

    protected $fillable = [
        'gambar_mono',
        'gambar_struktur',
    ];

    protected $appends = ['gambar_mono_url', 'gambar_struktur_url'];

    public function getGambarMonoUrlAttribute()
    {
        if ($this->gambar_mono && Storage::disk('public')->exists($this->gambar_mono)) {
            return Storage::url($this->gambar_mono);
        }
        return 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60';
    }

    public function getGambarStrukturUrlAttribute()
    {
        if ($this->gambar_struktur && Storage::disk('public')->exists($this->gambar_struktur)) {
            return Storage::url($this->gambar_struktur);
        }
        return 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60';
    }
}