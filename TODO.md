# TODO - Implementasi Halaman Kata Sambutan & Admin CRUD

- [x] Tambah route public halaman `kata-sambutan` di `routes/web.php`
- [x] Tambah route admin delete konten kata sambutan + foto di `routes/web.php`
- [x] Tambah method `kataSambutan()` di `DashboardController` untuk render halaman baru
- [x] Update tombol "Baca Sambutan Lengkap" di `resources/views/dashboard/index.blade.php` agar menuju route baru
- [x] Buat view baru `resources/views/kata-sambutan.blade.php` menampilkan Foto, Nama, dan kata sambutan lurah
- [x] Update `DataLurahController`:
  - [x] Tambah validasi request pada method `update`
  - [x] Tambah method delete konten kata sambutan + foto (record tetap ada)
- [x] Update `resources/views/admin/data-lurah/index.blade.php`:
  - [x] Tambah tombol "Hapus Kata Sambutan"
  - [x] Tambah JS untuk memanggil endpoint delete
  - [x] Pastikan tampilan foto utama mengikuti data database
- [ ] Uji alur:
  - [ ] Public page kata sambutan tampil benar
  - [ ] Admin bisa create/update/read/delete (hapus konten sambutan + foto)
