<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Display the gallery page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Sample gallery data
        $galeri = [
            [
                'id' => 1,
                'judul' => 'Kegiatan Vaksinasi',
                'gambar' => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Vaksinasi',
                'kategori' => 'kesehatan',
                'kategori_label' => 'Kesehatan',
                'tanggal' => '2024-12-15'
            ],
            [
                'id' => 2,
                'judul' => 'Pembagian Bantuan Sosial',
                'gambar' => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Bansos',
                'kategori' => 'sosial',
                'kategori_label' => 'Sosial',
                'tanggal' => '2024-12-10'
            ],
            [
                'id' => 3,
                'judul' => 'Gotong Royong',
                'gambar' => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Gotong+Royong',
                'kategori' => 'lingkungan',
                'kategori_label' => 'Lingkungan',
                'tanggal' => '2024-12-05'
            ],
            [
                'id' => 4,
                'judul' => 'Pelatihan UMKM',
                'gambar' => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Pelatihan+UMKM',
                'kategori' => 'ekonomi',
                'kategori_label' => 'Ekonomi',
                'tanggal' => '2024-12-01'
            ],
            [
                'id' => 5,
                'judul' => 'Festival Budaya',
                'gambar' => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Festival+Budaya',
                'kategori' => 'budaya',
                'kategori_label' => 'Budaya',
                'tanggal' => '2024-11-28'
            ],
            [
                'id' => 6,
                'judul' => 'Posyandu Balita',
                'gambar' => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Posyandu',
                'kategori' => 'kesehatan',
                'kategori_label' => 'Kesehatan',
                'tanggal' => '2024-11-25'
            ]
        ];

        return view('admin.galeri.index', compact('galeri'));
    }
}
