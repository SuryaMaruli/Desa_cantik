<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beritas = [
            [
                'judul' => 'Musrenbang Kelurahan Gunung Sugih Tahun 2026',
                'slug' => 'musrenbang-kelurahan-bulakan-tahun-2026',
                'excerpt' => 'Musyawarah Perencanaan Pembangunan Kelurahan Gunung Sugih tahun 2026 dilaksanakan untuk menampung aspirasi masyarakat.',
                'konten' => '<p>Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan Gunung Sugih tahun 2026 telah dilaksanakan pada hari Senin, 15 Januari 2026 di Aula Kantor Kelurahan Gunung Sugih. Acara ini dihadiri oleh berbagai elemen masyarakat, tokoh masyarakat, dan perwakilan dari berbagai organisasi kemasyarakatan.</p>
                
                <p>Dalam sambutannya, Lurah Bulakan Bapak M. Ali Wahidi, S.Sos., M.Si menekankan pentingnya partisipasi aktif masyarakat dalam perencanaan pembangunan. "Musrenbang adalah wadah demokrasi di mana setiap warga dapat menyampaikan usulan dan aspirasinya untuk pembangunan di lingkungan sekitar," ujarnya.</p>
                
                <p>Beberapa usulan prioritas yang berhasil dikumpulkan antara lain:</p>
                <ul>
                    <li>Peningkatan infrastruktur jalan lingkungan</li>
                    <li>Pembangunan drainase untuk mengatasi banjir</li>
                    <li>Penambahan fasilitas umum taman bermain anak</li>
                    <li>Program pemberdayaan UMKM lokal</li>
                    <li>Peningkatan pelayanan kesehatan masyarakat</li>
                </ul>
                
                <p>Semua usulan akan ditindaklanjuti dalam perencanaan pembangunan tingkat kecamatan dan kota. Masyarakat diimbau untuk terus memantau perkembangan pembangunan di wilayahnya.</p>',
                'kategori' => 'Pembangunan',
                'penulis' => 'Admin Kelurahan',
                'is_published' => true,
                'tanggal_publikasi' => '2026-01-15',
                'views' => 245
            ],
            [
                'judul' => 'Layanan Administrasi Kependudukan Dipercepat',
                'slug' => 'layanan-administrasi-kependudukan-dipercepat',
                'excerpt' => 'Kelurahan Gunung Sugih meluncurkan sistem pelayanan administrasi kependudukan yang lebih cepat dan efisien.',
                'konten' => '<p>Kelurahan Gunung Sugih terus berinovasi dalam memberikan pelayanan terbaik kepada masyarakat. Terbaru, kami meluncurkan sistem pelayanan administrasi kependudungan yang dipercepat untuk memenuhi kebutuhan masyarakat yang semakin dinamis.</p>
                
                <p>Beberapa peningkatan layanan yang telah dilakukan:</p>
                <ul>
                    <li>Pembuatan KTP elektronik dapat selesai dalam 7 hari kerja</li>
                    <li>Penerbitan Akta Kelahiran langsung jadi di hari yang sama</li>
                    <li>Pelayanan perpindahan penduduk lebih cepat dengan sistem online</li>
                    <li>Pembuatan Kartu Keluarga yang lebih efisien</li>
                </ul>
                
                <p>"Kami memahami bahwa dokumen kependudukan sangat penting bagi masyarakat. Oleh karena itu, kami terus berupaya mempercepat proses pelayanan tanpa mengurangi akurasi data," jelas Kasi Pelayanan Umum.</p>
                
                <p>Masyarakat dapat mengajukan permohonan secara online melalui website resmi Kelurahan Gunung Sugih atau datang langsung ke kantor dengan membawa persyaratan yang lengkap.</p>',
                'kategori' => 'Layanan',
                'penulis' => 'Admin Kelurahan',
                'is_published' => true,
                'tanggal_publikasi' => '2026-01-12',
                'views' => 189
            ],
            [
                'judul' => 'Program Desa Cantik Bulakan Raih Penghargaan',
                'slug' => 'program-desa-cantik-bulakan-raih-penghargaan',
                'excerpt' => 'Program Desa Cantik yang diinisiasi Kelurahan Gunung Sugih berhasil meraih penghargaan tingkat Kota Cilegon.',
                'konten' => '<p>Kebanggaan bagi kita semua! Program Desa Cantik yang telah digalakkan Kelurahan Gunung Sugih sejak tahun 2025 berhasil meraih penghargaan sebagai Program Terbaik kategori Lingkungan Hidup tingkat Kota Cilegon.</p>
                
                <p>Penghargaan ini diberikan dalam acara Apresiasi Inovasi Pelayanan Publik yang diselenggarakan oleh Pemerintah Kota Cilegon pada tanggal 10 Januari 2026 lalu. Program Desa Cantik Bulakan dinilai berhasil dalam:</p>
                
                <ol>
                    <li><strong>Penghijauan Lingkungan:</strong> Penanaman 1.000 pohon di berbagai titik</li>
                    <li><strong>Pengelolaan Sampah:</strong> Program bank sampah dan pengolahan kompos</li>
                    <li><strong>Pembersihan Lingkungan:</strong> Gotong royong rutin setiap minggu</li>
                    <li><strong>Pembangunan Taman:</strong> 5 taman baru di berbagai RW</li>
                    <li><strong>Sosialisasi:</strong> Edukasi kebersihan ke sekolah dan masyarakat</li>
                </ol>
                
                <p>"Ini adalah hasil kerja keras seluruh masyarakat Bulakan. Penghargaan ini menjadi motivasi kami untuk terus meningkatkan kualitas lingkungan," ujar Lurah Bulakan.</p>
                
                <p>Program Desa Cantik akan terus dikembangkan dengan menambahkan berbagai inovasi baru untuk menciptakan lingkungan yang bersih, hijau, dan sehat.</p>',
                'kategori' => 'Penghargaan',
                'penulis' => 'Admin Kelurahan',
                'is_published' => true,
                'tanggal_publikasi' => '2026-01-10',
                'views' => 412
            ],
            [
                'judul' => 'Vaksinasi COVID-19 Dosis Lanjutan Tersedia di Kelurahan',
                'slug' => 'vaksinasi-covid-19-dosis-lanjutan-tersedia-di-kelurahan',
                'excerpt' => 'Pemerintah Kelurahan Gunung Sugih menyediakan layanan vaksinasi COVID-19 dosis lanjutan untuk masyarakat.',
                'konten' => '<p>Dalam rangka meningkatkan kekebalan komunal masyarakat, Kelurahan Gunung Sugih kembali menyelenggarakan layanan vaksinasi COVID-19 dosis lanjutan (booster) bagi seluruh warga.</p>
                
                <p>Jadwal vaksinasi:</p>
                <ul>
                    <li><strong>Senin - Kamis:</strong> Pukul 08.00 - 12.00 WIB</li>
                    <li><strong>Jumat:</strong> Pukul 08.00 - 11.00 WIB</li>
                    <li><strong>Sabtu:</strong> Pukul 08.00 - 12.00 WIB</li>
                </ul>
                
                <p>Syarat peserta vaksinasi:</p>
                <ol>
                    <li>WNI berusia 18 tahun ke atas</li>
                    <li>Sudah menerima vaksin dosis kedua minimal 3 bulan yang lalu</li>
                    <li>Membawa KTP dan kartu vaksin sebelumnya</li>
                    <li>Dalam kondisi sehat (tidak demam)</li>
                </ol>
                
                <p>Jenis vaksin yang tersedia: Pfizer, Moderna, dan AstraZeneca. Masyarakat dapat memilih sesuai ketersediaan stok.</p>
                
                <p>"Vaksinasi adalah upaya kolektif kita untuk melindungi diri dan orang lain. Mari kita sukseskan program vaksinasi nasional," ajak Kasi Kesejahteraan Sosial.</p>
                
                <p>Informasi lebih lanjut dapat menghubungi Kantor Kelurahan Gunung Sugih di nomor (0254) 123-4567.</p>',
                'kategori' => 'Kesehatan',
                'penulis' => 'Admin Kelurahan',
                'is_published' => true,
                'tanggal_publikasi' => '2026-01-08',
                'views' => 156
            ],
            [
                'judul' => 'Pembangunan Jalan Lingkungan RW 03 Selesai',
                'slug' => 'pembangunan-jalan-lingkungan-rw-03-selesai',
                'excerpt' => 'Pembangunan jalan lingkungan di RW 03 Kelurahan Gunung Sugih telah selesai dan dapat digunakan masyarakat.',
                'konten' => '<p>Kabar gembira bagi warga RW 03 Kelurahan Gunung Sugih! Pembangunan jalan lingkungan yang telah dimulai sejak November 2025 kini telah selesai dan dapat digunakan oleh masyarakat.</p>
                
                <p>Spesifikasi pembangunan:</p>
                <ul>
                    <li>Panjang jalan: 450 meter</li>
                    <li>Lebar jalan: 4 meter</li>
                    <li>Konstruksi: ASPAL HOTMIX</li>
                    <li>Dilengkapi drainase di kedua sisi</li>
                    <li>Pemasangan penerangan jalan umum</li>
                </ul>
                
                <p>Pembangunan ini merupakan hasil dari Musrenbang tahun 2025 yang menjadi prioritas masyarakat RW 03. Dengan selesainya pembangunan jalan ini, diharapkan dapat:</p>
                
                <ol>
                    <li>Memperlancar akses transportasi warga</li>
                    <li>Mengurangi polusi debu saat musim kemarau</li>
                    <li>Mencegah genangan air saat musim hujan</li>
                    <li>Meningkatkan nilai ekonomi properti</li>
                    <li>Memperlancar akses darurat kendaraan</li>
                </ol>
                
                <p>"Kami berterima kasih atas dukungan dan kesabaran warga selama proses pembangunan. Ini adalah bukti komitmen kami dalam mewujudkan infrastruktur yang lebih baik," kata Lurah Bulakan saat meninjau lokasi.</p>
                
                <p>Pembangunan jalan lingkungan ini menggunakan dana APBD Kota Cilegon dan dikelola langsung oleh Dinas Pekerjaan Umum Kota Cilegon.</p>',
                'kategori' => 'Pembangunan',
                'penulis' => 'Admin Kelurahan',
                'is_published' => true,
                'tanggal_publikasi' => '2026-01-05',
                'views' => 298
            ]
        ];

        foreach ($beritas as $berita) {
            Berita::create($berita);
        }
    }
}

