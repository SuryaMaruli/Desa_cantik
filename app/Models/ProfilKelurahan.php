<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKelurahan extends Model
{
    protected $table = 'profil_kelurahans';
    
    protected $fillable = [
        'nama_kelurahan',
        'tahun_pembukaan',
        'nomor_kode_wilayah',
        'nomor_kode_pos',
        'kecamatan',
        'kabupaten_kota',
        'dasar_hukum_pembentukan',
        'provinsi',
        'visi',
        'misi',
        'wilayah_utara',
        'wilayah_timur',
        'wilayah_selatan',
        'wilayah_barat'
    ];

    protected $casts = [
        'tahun_pembukaan' => 'integer',
        'misi' => 'array',
    ];
}
