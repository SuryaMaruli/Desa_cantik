# TODO - Update Kelola Admin

- [x] Edit `app/Http/Controllers/Auth/LoginController.php`
  - [x] Hapus pemanggilan `createDummyUser()` di `showLoginForm()`
  - [x] Hapus blok pemanggilan `createDummyUser()` di `login()`
  - [x] Hapus method `createDummyUser()`
- [x] Verifikasi perubahan file login controller

- [x] Edit `resources/views/admin/admin/index.blade.php`
  - [x] Ubah struktur markup kotak pencarian agar lebih modern
  - [x] Tambahkan styling kotak pencarian agar elegan (hover/focus/gradient/shadow)
  - [x] Pastikan `id="searchAdmin"` tetap sama agar JS pencarian tetap berjalan
- [x] Verifikasi hasil perubahan tampilan

# TODO - Navbar Freeze Saat Scroll (Beranda)

- [x] Edit `resources/views/layouts/app.blade.php`
  - [x] Ubah `.navbar` agar freeze saat scroll (sticky/fixed di atas)
  - [x] Atur `z-index` dan lebar agar tetap stabil di semua halaman frontend
  - [x] Tambahkan kompensasi spacing konten agar tidak tertutup navbar
- [x] Verifikasi tampilan navbar saat scroll

# TODO - Tombol Panah Ke Atas (Beranda) - Penyesuaian Lanjutan

- [x] Edit `resources/views/layouts/app.blade.php`
  - [x] Pindahkan struktur tombol panah ke atas agar berada tepat di atas footer
  - [x] Tambahkan style tombol di layout agar posisi dan tampilannya konsisten
  - [x] Tambahkan script klik tombol untuk scroll halus ke paling atas
- [x] Edit `resources/views/beranda.blade.php`
  - [x] Hapus duplikasi struktur/style/script tombol panah dari beranda agar tidak bentrok
- [ ] Verifikasi perilaku tombol di halaman beranda
