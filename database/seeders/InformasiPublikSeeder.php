<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InformasiPublik;

class InformasiPublikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Lembaga Kemasyarakatan',
                'sub_deskripsi' => 'Informasi lengkap tentang lembaga-lembaga yang ada di Kelurahan Gunung Sugih.',
                'deskripsi' => 'Kelurahan Gunung Sugih memiliki beberapa lembaga kemasyarakatan yang aktif dalam membantu pemerintah kelurahan dalam menjalankan roda pemerintahan dan pelayanan masyarakat. Lembaga-lembaga ini meliputi PKK, Karang Taruna, LPM, dan lainnya yang berperan penting dalam pembangunan masyarakat.',
            ],
            [
                'judul' => 'Lembaga Pemberdayaan Masyarakat',
                'sub_deskripsi' => 'Program pemberdayaan untuk meningkatkan kesejahteraan masyarakat.',
                'deskripsi' => 'Berbagai program pemberdayaan masyarakat telah dilaksanakan di Kelurahan Gunung Sugih untuk meningkatkan kesejahteraan dan kemandirian masyarakat. Program ini meliputi pelatihan keterampilan, bantuan modal usaha, dan pengembangan UMKM lokal.',
            ],
            [
                'judul' => 'Agenda & Kegiatan',
                'sub_deskripsi' => 'Jadwal kegiatan dan acara yang akan dilaksanakan di kelurahan.',
                'deskripsi' => 'Berbagai kegiatan rutin dan kegiatan khusus dijadwalkan sepanjang tahun di Kelurahan Gunung Sugih. Mulai dari posyandu, gotong royong, hingga perayaan hari besar keagamaan dan nasional. Masyarakat dapat mengikuti dan berpartisipasi aktif dalam setiap kegiatan.',
            ],
            [
                'judul' => 'Dokumen Publik',
                'sub_deskripsi' => 'Akses dokumen dan peraturan yang dapat diakses oleh masyarakat.',
                'deskripsi' => 'Transparansi dan akuntabilitas pemerintahan menjadi prioritas Kelurahan Gunung Sugih. Berbagai dokumen publik seperti APBDes, peraturan lokal, laporan kegiatan, dan informasi penting lainnya dapat diakses oleh masyarakat untuk memastikan pelayanan yang berintegritas.',
            ],
        ];

        foreach ($data as $item) {
            InformasiPublik::create($item);
        }
    }
}
