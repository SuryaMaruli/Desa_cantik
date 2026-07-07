<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfilKelurahan;

class ProfilKelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilKelurahan::create([
            'nama_kelurahan' => 'Gunung Sugih',
            'tahun_pembukaan' => '1985',
            'nomor_kode_wilayah' => '36.71.02.1009',
            'nomor_kode_pos' => '42441',
            'kecamatan' => 'Ciwandan',
            'kabupaten_kota' => 'Cilegon',
            'dasar_hukum_pembentukan' => 'Peraturan Pemerintah Nomor 45 Tahun 1985 tentang Pembentukan Kelurahan Gunung Sugih',
            'provinsi' => 'Banten',
            'visi' => 'Menjadi kelurahan yang maju, sejahtera, dan berbudaya',
            'misi' => [
                'Meningkatkan kualitas pelayanan publik',
                'Memberdayakan masyarakat melalui program-program pembangunan',
                'Menciptakan lingkungan yang bersih dan sehat',
                'Meningkatkan partisipasi masyarakat dalam pembangunan'
            ],
            'wilayah_utara' => 'Kelurahan Cibeber',
            'wilayah_timur' => 'Kelurahan Karangasem',
            'wilayah_selatan' => 'Selat Sunda',
            'wilayah_barat' => 'Kelurahan Bagendung'
        ]);
    }
}

