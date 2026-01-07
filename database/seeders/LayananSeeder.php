<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Layanan Kependudukan
        Layanan::create([
            'nama_layanan' => 'Kartu Tanda Penduduk (KTP)',
            'kategori' => 'kependudukan',
            'persyaratan' => [
                'Surat Pengantar RT/RW',
                'Kartu Keluarga Asli',
                'Akta Kelahiran',
                'Pas Foto 3x4 (4 lembar)',
                'Formulir Permohonan KTP'
            ],
        ]);

        Layanan::create([
            'nama_layanan' => 'Kartu Keluarga (KK)',
            'kategori' => 'kependudukan',
            'persyaratan' => [
                'Surat Pengantar RT/RW',
                'KTP Suami/Istri',
                'Akta Nikah',
                'Akta Kelahiran Anak',
                'Formulir Permohonan KK'
            ],
        ]);

        Layanan::create([
            'nama_layanan' => 'Akta Kelahiran',
            'kategori' => 'kependudukan',
            'persyaratan' => [
                'Surat Kelahiran dari Rumah Sakit/Bidan',
                'KTP Ayah dan Ibu',
                'KK Ayah dan Ibu',
                'Surat Nikah Orang Tua',
                'Formulir Permohonan Akta Kelahiran'
            ],
        ]);

        // Layanan Permintaan Data
        Layanan::create([
            'nama_layanan' => 'Permohonan Data Statistik Warga',
            'kategori' => 'data',
            'persyaratan' => [
                'Surat Permohonan Resmi',
                'Identitas Pemohon (KTP)',
                'Tujuan Penggunaan Data',
                'Surat Kuasa (jika diwakilkan)',
                'Formulir Permohonan Data'
            ],
        ]);

        Layanan::create([
            'nama_layanan' => 'Data Kependudukan Umum',
            'kategori' => 'data',
            'persyaratan' => [
                'Surat Permohonan Instansi',
                'Identitas Pemohon',
                'Jenis Data yang Dibutuhkan',
                'Tujuan Penggunaan Data',
                'Formulir Permohonan'
            ],
        ]);
    }
}
