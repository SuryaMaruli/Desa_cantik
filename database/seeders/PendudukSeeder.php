<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penduduk;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendudukData = [
            ['nama' => 'Ahmad Wijaya', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '01'],
            ['nama' => 'Siti Nurhaliza', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '01'],
            ['nama' => 'Budi Santoso', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Belum Menikah', 'rw' => '02'],
            ['nama' => 'Dewi Lestari', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '02'],
            ['nama' => 'Rudi Hermawan', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '03'],
            ['nama' => 'Ratna Sari', 'jenis_kelamin' => 'Perempuan', 'status' => 'Belum Menikah', 'rw' => '03'],
            ['nama' => 'Hendra Gunawan', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '04'],
            ['nama' => 'Maya Putri', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '04'],
            ['nama' => 'Fajar Pratama', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Belum Menikah', 'rw' => '05'],
            ['nama' => 'Indah Permata', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '05'],
            ['nama' => 'Joko Susilo', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '06'],
            ['nama' => 'Sri Wahyuni', 'jenis_kelamin' => 'Perempuan', 'status' => 'Belum Menikah', 'rw' => '06'],
            ['nama' => 'Bambang Sutrisno', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '07'],
            ['nama' => 'Ani Suryani', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '07'],
            ['nama' => 'Eko Prasetyo', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Belum Menikah', 'rw' => '08'],
            ['nama' => 'Ratna Dewi', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '08'],
            ['nama' => 'Agus Salim', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '09'],
            ['nama' => 'Dina Marlina', 'jenis_kelamin' => 'Perempuan', 'status' => 'Belum Menikah', 'rw' => '09'],
            ['nama' => 'Hadi Saputra', 'jenis_kelamin' => 'Laki-laki', 'status' => 'Menikah', 'rw' => '10'],
            ['nama' => 'Fitri Handayani', 'jenis_kelamin' => 'Perempuan', 'status' => 'Menikah', 'rw' => '10'],
        ];

        foreach ($pendudukData as $data) {
            Penduduk::create($data);
        }
    }
}
