<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        Galeri::create([
            'judul_foto' => 'Kegiatan Vaksinasi Massal',
            'deskripsi' => 'Kegiatan vaksinasi COVID-19 untuk warga Kelurahan Citangkil',
            'kategori' => 'kesehatan',
            'tanggal_kegiatan' => '2024-01-15',
            'foto' => 'galeri/sample1.jpg',
        ]);

        Galeri::create([
            'judul_foto' => 'Pembagian Bantuan Sosial',
            'deskripsi' => 'Pembagian sembako kepada warga terdampak pandemi',
            'kategori' => 'sosial',
            'tanggal_kegiatan' => '2024-01-10',
            'foto' => 'galeri/sample2.jpg',
        ]);

        Galeri::create([
            'judul_foto' => 'Gotong Royong Membersihkan Lingkungan',
            'deskripsi' => 'Kerja bakti membersihkan saluran air dan lingkungan sekitar',
            'kategori' => 'lingkungan',
            'tanggal_kegiatan' => '2024-01-05',
            'foto' => 'galeri/sample3.jpg',
        ]);
    }
}
