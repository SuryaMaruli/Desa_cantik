<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'konten',
        'kategori',
        'penulis',
        'gambar',
        'is_published',
        'is_utama',
        'tanggal_publikasi',
        'views'
    ];

protected $casts = [
        'is_published' => 'boolean',
        'is_utama' => 'boolean',
        'tanggal_publikasi' => 'date',
        'views' => 'integer'
    ];

    // Auto generate slug dari judul
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul') && empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    public function fotos()
    {
        return $this->hasMany(BeritaFoto::class)->orderBy('urutan');
    }

    public function fotoUtama()
    {
        return $this->hasOne(BeritaFoto::class)->where('is_utama', true);
    }

    // Scope untuk berita yang dipublikasikan
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Scope untuk berita terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal_publikasi', 'desc');
    }

// Scope untuk berita populer
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    // Scope untuk berita utama
    public function scopeUtama($query)
    {
        return $query->where('is_utama', true);
    }

    // Scope berdasarkan kategori
    public function scopeByCategory($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Mendapatkan URL gambar
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/berita/' . $this->gambar);
        }
        return asset('images/default-berita.jpg');
    }

    // Mendapatkan excerpt otomatis jika tidak ada
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->konten), 150);
    }
}
