<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataLurah;

class DataLurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataLurah::create([
            'nama_lurah' => 'M. ALI WAHIDI, S.Sos.M.Si',
            'nip' => '196512311985031023',
            'pangkat' => 'Pembina Tingkat I',
            'golongan' => 'IV/b',
            'jabatan' => 'Lurah Citangkil',
            'sambutan_lurah' => 'Situs web ini kami hadirkan sebagai wadah untuk mempublikasi atau informasi kepada masyarakat. Dengan kemudahan yang diberikan, diharapkan dapat mempercepat proses pelayanan publik dan mempermudah masyarakat dalam memperoleh informasi terkini.',
            'foto_lurah' => null,
        ]);
    }
}
