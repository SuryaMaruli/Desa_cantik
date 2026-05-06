<?php

use Illuminate\Support\Facades\Route;

// --- CONTROLLERS IMPORT ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController; // Public Dashboard
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataKelurahanController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfilKelurahanController;
use App\Http\Controllers\Admin\DesaCantikController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\DataLurahController;
use App\Http\Controllers\Admin\MonografiController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\InformasiPublikController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\ProfilController;

// --- MODELS IMPORT (Untuk Public Routes) ---
use App\Models\Layanan; 
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\TentangDesa;
use App\Models\MetadataStatistik;
use App\Models\InformasiPublik;
use App\Models\OutputProgram;
use App\Models\Prestasi;
use App\Models\Penduduk;
use App\Models\ProfilKelurahan;
use App\Models\Monografi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/storage/{path}', function ($path) {
    // Decode URL-encoded characters (handle %20 for spaces, etc.)
    $path = urldecode($path);
    
    // Debug: Log the request
    \Log::info("Storage access attempt: " . $path);
    \Log::info("Original path: " . request()->path());
    
    // Security check - prevent directory traversal
    if (str_contains($path, '..') || str_starts_with($path, '/')) {
        \Log::warning("Security violation attempt: " . $path);
        abort(403, 'Access denied');
    }
    
    $fullPath = storage_path('app/public/' . $path);
    \Log::info("Full path: " . $fullPath);
    \Log::info("File exists: " . (file_exists($fullPath) ? 'YES' : 'NO'));
    
    if (!file_exists($fullPath)) {
        \Log::warning("File not found: " . $fullPath);
        abort(404, 'File not found');
    }
    
    // Check if it's actually a file
    if (!is_file($fullPath)) {
        \Log::warning("Not a file: " . $fullPath);
        abort(403, 'Not a file');
    }
    
    $fileInfo = pathinfo($fullPath);
    $extension = strtolower($fileInfo['extension'] ?? '');
    
    // Set proper headers based on file type
    $headers = [];
    
    switch ($extension) {
        case 'pdf':
            $headers['Content-Type'] = 'application/pdf';
            $headers['Content-Disposition'] = 'inline; filename="' . basename($fullPath) . '"';
            break;
        case 'jpg':
        case 'jpeg':
            $headers['Content-Type'] = 'image/jpeg';
            break;
        case 'png':
            $headers['Content-Type'] = 'image/png';
            break;
        case 'gif':
            $headers['Content-Type'] = 'image/gif';
            break;
        default:
            $headers['Content-Type'] = 'application/octet-stream';
    }
    
    \Log::info("Serving file: " . $fullPath);
    return response()->file($fullPath, $headers);
})->where('path', '.*')->name('storage.file');

// =========================================================================
// 1. PUBLIC ROUTES (Frontend)
// =========================================================================

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('/profil-kelurahan', function () {
    $profilKelurahan = ProfilKelurahan::first();
    $monografis = Monografi::latest()->get();
    return view('profil', compact('profilKelurahan', 'monografis'));
});

Route::get('/layanan', function () {
    return view('layanan');
});

Route::get('/layanan-kependudukan', function () {
    $layananKependudukan = Layanan::where('kategori', 'kependudukan')
        ->orderBy('nama_layanan', 'asc')->get();       
    return view('layanan-kependudukan', compact('layananKependudukan'));
});

Route::get('/layanan-data', function () {
    $layananData = Layanan::where('kategori', 'data')
        ->orderBy('nama_layanan', 'asc')->get();
    return view('layanan-data', compact('layananData'));
});

Route::get('/data', function () {
    $pendudukData = Penduduk::orderBy('rw')->orderBy('nama')->get();
    
    // Hitung statistik
    $totalPenduduk = $pendudukData->count();
    $lakiLaki = $pendudukData->where('jenis_kelamin', 'Laki-laki')->count();
    $perempuan = $pendudukData->where('jenis_kelamin', 'Perempuan')->count();
    
    // Hitung data per RW
    $rws = [];
    for ($i = 1; $i <= 10; $i++) {
        $rwNo = str_pad($i, 2, '0', STR_PAD_LEFT);
        $jumlahRw = $pendudukData->where('rw', $rwNo)->count();
        $lakiRw = $pendudukData->where('rw', $rwNo)->where('jenis_kelamin', 'Laki-laki')->count();
        $perempuanRw = $pendudukData->where('rw', $rwNo)->where('jenis_kelamin', 'Perempuan')->count();
        
        if ($jumlahRw > 0) {
            $rws[] = [
                'no' => $rwNo,
                'jumlah' => $jumlahRw,
                'laki' => $lakiRw,
                'perempuan' => $perempuanRw,
                'persentase' => $totalPenduduk > 0 ? round(($jumlahRw / $totalPenduduk) * 100) : 0
            ];
        }
    }
    
    // Format data untuk charts
    $rwLabels = []; $rwLakiData = []; $rwPerempuanData = []; $rwPieLabels = []; $rwPieData = [];
    
    foreach ($rws as $rw) {
        $rwLabels[] = 'RW ' . $rw['no'];
        $rwLakiData[] = $rw['laki'];
        $rwPerempuanData[] = $rw['perempuan'];
        $rwPieLabels[] = 'RW ' . $rw['no'];
        $rwPieData[] = $rw['persentase'];
    }
    
    return view('data', compact('totalPenduduk', 'lakiLaki', 'perempuan', 'rws', 'rwLabels', 'rwLakiData', 'rwPerempuanData', 'rwPieLabels', 'rwPieData'));
});

Route::get('/desa-cantik', function () {
    $galeri = Galeri::latest()->take(6)->get();
    $tentang = TentangDesa::first();
    $metadata = MetadataStatistik::all();
    $outputPrograms = OutputProgram::all();
    $prestasi = Prestasi::latest()->get();
    return view('desa-cantik', compact('galeri', 'tentang', 'metadata', 'outputPrograms', 'prestasi'));
});

Route::get('/desa-cantik/output/{id}', [DesaCantikController::class, 'showOutput'])->name('desa-cantik.show-output');

Route::get('/informasi-publik/{id}', function ($id) {
    $informasi = InformasiPublik::findOrFail($id);
    return view('informasi-publik-detail', compact('informasi'));
})->name('informasi-publik.detail');

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/berita', function () {
    $kategori = request('kategori');
    $query = Berita::where('is_published', true)->orderBy('tanggal_publikasi', 'desc');
    
    if ($kategori && $kategori !== 'Semua') {
        $query->where('kategori', $kategori);
    }
    
    $berita = $query->get();
    
    // Ambil kategori unik dari database
    $kategoriList = Berita::where('is_published', true)
        ->whereNotNull('kategori')
        ->distinct()
        ->pluck('kategori')
        ->sort()
        ->values();
    
    return view('berita', compact('berita', 'kategori', 'kategoriList'));
});

Route::get('/berita/{id}', function ($id) {
    $berita = Berita::where('id', $id)->where('is_published', true)->first();
    if (!$berita) abort(404);
    return view('berita-detail', compact('berita'));
});


// =========================================================================
// 2. AUTHENTICATION ROUTES
// =========================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =========================================================================
// 3. ADMIN ROUTES
// =========================================================================

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // --- BERANDA ---
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');
    Route::post('/beranda', [BerandaController::class, 'store'])->name('beranda.store');
    Route::put('/beranda/{id}', [BerandaController::class, 'update'])->name('beranda.update');
    
    // --- PROFIL ---
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    
    // --- MONOGRAFI ---
    Route::get('/monografi', [MonografiController::class, 'index'])->name('monografi.index');
    Route::post('/monografi', [MonografiController::class, 'store'])->name('monografi.store');
    Route::get('/monografi/{id}/edit', [MonografiController::class, 'edit'])->name('monografi.edit');
    Route::put('/monografi/{id}', [MonografiController::class, 'update'])->name('monografi.update');
    Route::delete('/monografi/{id}', [MonografiController::class, 'destroy'])->name('monografi.destroy');

    // --- DATA KELURAHAN ---
    Route::get('/data-kelurahan', [DataKelurahanController::class, 'index'])->name('data-kelurahan.index');
    Route::post('/data-kelurahan/store', [DataKelurahanController::class, 'store'])->name('data-kelurahan.store');
    Route::put('/data-kelurahan/update/{id}', [DataKelurahanController::class, 'update'])->name('data-kelurahan.update');
    Route::delete('/data-kelurahan/delete/{id}', [DataKelurahanController::class, 'destroy'])->name('data-kelurahan.destroy');
    
    // --- GALERI ---
    Route::resource('galeri', GaleriController::class);
    
    // --- PROFIL KELURAHAN ---
    Route::get('/profil-kelurahan', [ProfilKelurahanController::class, 'index'])->name('profil-kelurahan.index');
    Route::put('/profil-kelurahan', [ProfilKelurahanController::class, 'update'])->name('profil-kelurahan.update');
    
    // --- DESA CANTIK ---
    Route::get('/desa-cantik', [DesaCantikController::class, 'index'])->name('desa-cantik.index');
    Route::post('/desa-cantik/tentang', [DesaCantikController::class, 'updateTentang'])->name('desa-cantik.update-tentang');
    
    // Desa Cantik: Metadata
    Route::post('/desa-cantik/metadata', [DesaCantikController::class, 'storeMetadata'])->name('desa-cantik.store-metadata');
    Route::put('/desa-cantik/metadata/{id}', [DesaCantikController::class, 'updateMetadata'])->name('desa-cantik.update-metadata'); // Perbaikan: PUT
    Route::delete('/desa-cantik/metadata/{id}', [DesaCantikController::class, 'deleteMetadata'])->name('desa-cantik.delete-metadata');
    
    // Desa Cantik: Output
    Route::post('/desa-cantik/output', [DesaCantikController::class, 'storeOutput'])->name('desa-cantik.store-output');
    Route::put('/desa-cantik/output/{id}', [DesaCantikController::class, 'updateOutput'])->name('desa-cantik.update-output'); // Perbaikan: PUT
    Route::delete('/desa-cantik/output/{id}', [DesaCantikController::class, 'deleteOutput'])->name('desa-cantik.delete-output');
    
    // --- INFORMASI PUBLIK ---
    Route::get('/informasi-publik', [InformasiPublikController::class, 'index'])->name('informasi-publik.index');
    Route::get('/informasi-publik/create', [InformasiPublikController::class, 'create'])->name('informasi-publik.create');
    Route::post('/informasi-publik', [InformasiPublikController::class, 'store'])->name('informasi-publik.store');
    Route::get('/informasi-publik/{id}/edit', [InformasiPublikController::class, 'edit'])->name('informasi-publik.edit');
    Route::put('/informasi-publik/{id}', [InformasiPublikController::class, 'update'])->name('informasi-publik.update');
    Route::delete('/informasi-publik/{id}', [InformasiPublikController::class, 'destroy'])->name('informasi-publik.destroy');
    
    // --- PRESTASI ---
    Route::resource('prestasi', PrestasiController::class)->except(['show']); 
    
    // --- DATA LURAH ---
    Route::get('/data-lurah', [DataLurahController::class, 'index'])->name('data-lurah.index');
    Route::get('/data-lurah/api', [DataLurahController::class, 'getData'])->name('data-lurah.api');
    Route::post('/data-lurah/update', [DataLurahController::class, 'update'])->name('data-lurah.update');
    
    // --- ADMIN ---
    Route::resource('admin', AdminController::class)->except(['show']); 
    
    // --- LAYANAN ---
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');
    
    // --- BERITA ---
    Route::resource('berita', BeritaController::class); 
    Route::post('/berita/{berita}/toggle-publish', [BeritaController::class, 'togglePublish'])->name('berita.toggle-publish');
    Route::get('/berita/{berita}/edit-data', [BeritaController::class, 'getEditData'])->name('berita.edit-data');
    
    // --- PENGATURAN ---
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    
});