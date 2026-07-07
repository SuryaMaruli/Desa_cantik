<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestasi;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prestasi::create([
            'judul' => 'Juara 1 Kelurahan Terbersih',
            'peringkat' => 'Juara 1',
            'tingkat' => 'Kota Cilegon',
            'penyelenggara' => 'Pemerintah Kota Cilegon',
            'tahun' => 2024,
            'deskripsi' => 'Kelurahan Gunung Sugih meraih juara 1 dalam kompetisi kelurahan terbersih tingkat Kota Cilegon.',
            'tanggal' => '2024-03-15',
        ]);

        Prestasi::create([
            'judul' => 'Kelurahan Teraktif dalam Vaksinasi',
            'peringkat' => 'Penghargaan',
            'tingkat' => 'Provinsi Banten',
            'penyelenggara' => 'Dinas Kesehatan Provinsi Banten',
            'tahun' => 2023,
            'deskripsi' => 'Penghargaan sebagai kelurahan dengan partisipasi vaksinasi tertinggi di Provinsi Banten.',
            'tanggal' => '2023-12-10',
        ]);

        Prestasi::create([
            'judul' => 'Pelayanan Publik Terbaik',
            'peringkat' => 'Terbaik',
            'tingkat' => 'Kota Cilegon',
            'penyelenggara' => 'Ombudsman RI Perwakilan Banten',
            'tahun' => 2023,
            'deskripsi' => 'Apresiasi atas inovasi dan kualitas pelayanan publik yang prima kepada masyarakat.',
            'tanggal' => '2023-08-20',
        ]);
    }
}
