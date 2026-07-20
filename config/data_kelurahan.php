<?php

return [
    'subjects' => [
        [
            'key' => 'kependudukan',
            'icon' => 'bx-group',
            'name' => 'Kependudukan',
            'datasets' => [
                ['key' => 'jumlah_penduduk', 'name' => 'Jumlah Penduduk'],
                ['key' => 'jumlah_penduduk_jenis_kelamin', 'name' => 'Jumlah Penduduk menurut Jenis Kelamin', 'children' => [
                    ['key' => 'jumlah_penduduk_laki_laki', 'name' => 'Laki-laki'],
                    ['key' => 'jumlah_penduduk_perempuan', 'name' => 'Perempuan'],
                ]],
                ['key' => 'jumlah_kepala_keluarga', 'name' => 'Jumlah Kepala Keluarga (KK)'],
                ['key' => 'jumlah_kepala_keluarga_jenis_kelamin', 'name' => 'Jumlah Kepala Keluarga (KK) menurut Jenis Kelamin', 'children' => [
                    ['key' => 'jumlah_kk_laki_laki', 'name' => 'Laki-laki'],
                    ['key' => 'jumlah_kk_perempuan', 'name' => 'Perempuan'],
                ]],
                ['key' => 'jumlah_pengangguran', 'name' => 'Jumlah Pengangguran'],
            ],
        ],
        [
            'key' => 'pendidikan',
            'icon' => 'bx-book-open',
            'name' => 'Pendidikan',
            'datasets' => [
                ['key' => 'penduduk_tingkat_pendidikan', 'name' => 'Jumlah Penduduk Menurut Tingkat Pendidikan', 'children' => [
                    ['key' => 'tamat_sd', 'name' => 'Tamat SD/Sederajat'],
                    ['key' => 'tamat_smp', 'name' => 'Tamat SMP/Sederajat'],
                    ['key' => 'tamat_sma', 'name' => 'Tamat SMA/Sederajat'],
                    ['key' => 'tamat_s1', 'name' => 'Tamat S1/Sederajat'],
                    ['key' => 'tamat_s2_s3', 'name' => 'Tamat S2 dan S3/Sederajat'],
                ]],
                ['key' => 'anak_wajib_belajar_9_tahun', 'name' => 'Jumlah Anak Usia Wajib Belajar 9 tahun'],
                ['key' => 'rasio_guru_murid', 'name' => 'Rasio Guru Murid', 'children' => [
                    ['key' => 'guru_sd', 'name' => 'Jumlah guru SD dan sederajat'],
                    ['key' => 'siswa_sd', 'name' => 'Jumlah siswa SD dan sederajat'],
                    ['key' => 'guru_smp', 'name' => 'Jumlah guru SMP dan sederajat'],
                    ['key' => 'siswa_smp', 'name' => 'Jumlah siswa SMP dan sederajat'],
                    ['key' => 'guru_sma', 'name' => 'Jumlah guru SMA dan sederajat'],
                    ['key' => 'siswa_sma', 'name' => 'Jumlah siswa SMA dan sederajat'],
                ]],
                ['key' => 'sarana_pendidikan_masyarakat', 'name' => 'Jumlah Sarana Pendidikan Masyarakat', 'children' => [
                    ['key' => 'perpustakaan_desa', 'name' => 'Jumlah perpustakaan desa/kelurahan'],
                    ['key' => 'taman_bacaan', 'name' => 'Jumlah taman bacaan desa/kelurahan'],
                    ['key' => 'perpustakaan_keliling', 'name' => 'Jumlah perpustakaan keliling'],
                ]],
            ],
        ],
        [
            'key' => 'kesehatan',
            'icon' => 'bx-plus-medical',
            'name' => 'Kesehatan',
            'datasets' => [
                ['key' => 'ibu_hamil', 'name' => 'Jumlah Ibu Hamil'],
                ['key' => 'bayi_lahir_hidup', 'name' => 'Jumlah Bayi Lahir Hidup'],
                ['key' => 'bayi_lahir_mati', 'name' => 'Jumlah Bayi Lahir Mati'],
                ['key' => 'kejadian_wabah_penyakit', 'name' => 'Jumlah Kejadian Wabah Penyakit'],
                ['key' => 'angka_harapan_hidup', 'name' => 'Angka Harapan Hidup Desa/Kelurahan'],
                ['key' => 'sarana_prasarana_kesehatan', 'name' => 'Jumlah Sarana dan Prasarana Kesehatan', 'children' => [
                    ['key' => 'tempat_persalinan_rsu', 'name' => 'Jumlah Tempat persalinan Rumah Sakit Umum'],
                    ['key' => 'tempat_persalinan_rumah_bersalin', 'name' => 'Jumlah Tempat persalinan Rumah Bersalin'],
                    ['key' => 'tempat_persalinan_praktek_bidan', 'name' => 'Jumlah Tempat persalinan Rumah Praktek Bidan'],
                    ['key' => 'tempat_praktek_dokter', 'name' => 'Jumlah Tempat Praktek Dokter'],
                ]],
            ],
        ],
        [
            'key' => 'ekonomi',
            'icon' => 'bx-briefcase',
            'name' => 'Ekonomi',
            'datasets' => [
                ['key' => 'keluarga_prasejahtera', 'name' => 'Jumlah Keluarga Prasejahtera'],
                ['key' => 'pendapatan_kepala_keluarga', 'name' => 'Jumlah Pendapatan Kepala Keluarga'],
                ['key' => 'penduduk_mata_pencaharian', 'name' => 'Jumlah Penduduk Menurut Mata Pencaharian', 'children' => [
                    ['key' => 'sektor_pertanian', 'name' => 'Sektor Pertanian'],
                    ['key' => 'sektor_perkebunan', 'name' => 'Sektor Perkebunan'],
                    ['key' => 'sektor_peternakan', 'name' => 'Sektor Peternakan'],
                    ['key' => 'sektor_perikanan', 'name' => 'Sektor Perikanan'],
                    ['key' => 'sektor_kehutanan', 'name' => 'Sektor Kehutanan'],
                    ['key' => 'sektor_pertambangan', 'name' => 'Sektor Pertambangan'],
                    ['key' => 'sektor_industri_kecil', 'name' => 'Sektor Industri Kecil & Kerajinan Rumah Tangga'],
                    ['key' => 'sektor_industri_menengah_besar', 'name' => 'Sektor Industri Menengah & Besar'],
                    ['key' => 'sektor_perdagangan', 'name' => 'Sektor Perdagangan'],
                    ['key' => 'sektor_jasa', 'name' => 'Sektor Jasa'],
                ]],
            ],
        ],
        [
            'key' => 'sosial_keamanan_politik_pemerintahan_kelembagaan',
            'icon' => 'bx-shield-quarter',
            'name' => 'Sosial, Keamanan & Politik, Pemerintahan & Kelembagaan',
            'datasets' => [
                ['key' => 'konflik_sara', 'name' => 'Jumlah Konflik SARA'],
                ['key' => 'kasus_pertengkaran_perkelahian', 'name' => 'Jumlah Kasus Pertengkaran dan atau Perkelahian'],
                ['key' => 'kasus_perkelahian', 'name' => 'Jumlah Kasus Perkelahian'],
                ['key' => 'kegiatan_pemantapan_pancasila', 'name' => 'Jumlah Kegiatan Pemantapan Nilai Ideologi Pancasila Sebagai Dasar Negara'],
                ['key' => 'anggaran_belanja_penerimaan', 'name' => 'Jumlah aanggaran belanja dan penerimaan Desa/Kelurahan tahun ini'],
            ],
        ],
    ],
];
