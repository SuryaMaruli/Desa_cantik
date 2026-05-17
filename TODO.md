# TODO - Fitur Jumlah Kunjungan Beranda (Unique Visitor)

- [x] Buat migration tabel `visitor_stats` (weekly, monthly, total)
- [x] Buat model `VisitorStat`
- [x] Buat migration tabel `visitor_hits` untuk pencatatan visitor unik per periode
- [x] Buat model `VisitorHit`
- [x] Update `DashboardController@index` agar hitung unique visitor berbasis cookie `visitor_uuid` (bukan refresh)
- [x] Pastikan UI statistik hanya tampil di halaman beranda (`resources/views/dashboard/index.blade.php`)
- [x] Hapus UI statistik kunjungan dari layout global (`resources/views/layouts/app.blade.php`)
- [x] Jalankan migration untuk verifikasi
- [x] Final check hasil implementasi
