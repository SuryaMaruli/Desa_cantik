<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monografi extends Model
{
    protected $table = 'monografis'; // Pastikan nama tabel benar
    
    protected $fillable = [
        'gambar_mono',
        'gambar_struktur',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // PENTING: Tambahkan ini agar URL muncul di JSON response
    protected $appends = ['gambar_mono_url', 'gambar_struktur_url'];

    // Accessor untuk mendapatkan URL gambar monografi
    public function getGambarMonoUrlAttribute()
    {
        if ($this->gambar_mono) {
            return asset('storage/' . $this->gambar_mono);
        }
        return 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60';
    }

    // Accessor untuk mendapatkan URL gambar struktur
    public function getGambarStrukturUrlAttribute()
    {
        if ($this->gambar_struktur) {
            return asset('storage/' . $this->gambar_struktur);
        }
        return 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60';
    }
}