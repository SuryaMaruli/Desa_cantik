<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TentangDesa;
use App\Models\MetadataStatistik;
use App\Models\OutputProgram;

class DesaCantikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Tentang Desa
        TentangDesa::create([
            'deskripsi' => 'Desa Cinta Statistik (Desa Cantik) adalah sebuah program yang bertujuan untuk meningkatkan kemampuan aparat desa dalam mengelola dan memanfaatkan data agar perencanaan pembangunan desa lebih tepat sasaran. Saat ini, desa-desa telah dibekali dengan berbagai aplikasi pendataan seperti SDGs Desa, Prodeskel (Profil Desa dan Kelurahan), dan SIKS-NG (Sistem Informasi Kesejahteraan Sosial Next Generation). Namun, kualitas dan kapasitas sumber daya manusia di pemerintahan desa dalam hal pengelolaan dan literasi data masih tergolong rendah. Badan Pusat Statistik (BPS) sebagai lembaga yang membina statistik memiliki peranan penting dalam meningkatkan pengelolaan, pemanfaatan, dan literasi data di tingkat desa. Oleh karena itu, program Desa Cantik diluncurkan dengan tujuan untuk meningkatkan literasi data di kalangan seluruh aparat desa.'
        ]);

        // Seed Metadata Statistik
        $metadataItems = [
            [
                'nama_metadata' => 'Meta Data Kegiatan',
                'deskripsi' => 'Dokumentasi dan pencatatan seluruh kegiatan updating data kependudukan',
                'gambar' => 'metadata-kegiatan.jpg'
            ],
            [
                'nama_metadata' => 'Meta Data Variabel',
                'deskripsi' => 'Definisi dan klasifikasi variabel-variabel yang digunakan dalam pendataan',
                'gambar' => 'metadata-variabel.jpg'
            ],
            [
                'nama_metadata' => 'Meta Data Indikator',
                'deskripsi' => 'Indikator-indikator statistik untuk mengukur kualitas data kependudukan',
                'gambar' => 'metadata-indikator.jpg'
            ]
        ];

        foreach ($metadataItems as $item) {
            MetadataStatistik::create($item);
        }

        // Seed Output Program
        $outputPrograms = [
            [
                'judul_program' => 'SISTEM UPDATING DATA KEPENDUDUKAN',
                'deskripsi_program' => 'Kuesioner Updating Data Kependudukan'
            ],
            [
                'judul_program' => 'MEDIA PENGELOLAAN DATA KEPENDUDUKAN',
                'deskripsi_program' => 'Website Kelurahan Citangkil'
            ],
            [
                'judul_program' => 'PENINGKATAN KAPABILITAS & LITERASI STATISTIK AGEN STATISTIK DAN MASYARAKAT',
                'deskripsi_program' => 'Booklet Kelurahan Citangkil'
            ],
            [
                'judul_program' => 'SEGMENTASI DEMOGRAFIS KELUARGA KELURAHAN CITANGKIL',
                'deskripsi_program' => 'Buku Segmentasi Demografis Keluarga Kelurahan Citangkil'
            ]
        ];

        foreach ($outputPrograms as $program) {
            OutputProgram::create($program);
        }
    }
}
