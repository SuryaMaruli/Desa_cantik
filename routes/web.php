<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataKelurahanController;
use App\Models\Berita;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Route untuk halaman lainnya
Route::get('/profil', function () {
    return view('profil');
});

Route::get('/layanan', function () {
    return view('layanan');
});

Route::get('/layanan-kependudukan', function () {
    return view('layanan-kependudukan');
});

Route::get('/layanan-data', function () {
    return view('layanan-data');
});

Route::get('/data', function () {
    return view('data');
});

Route::get('/desa-cantik', function () {
    return view('desa-cantik');
});

Route::get('/berita', function () {
    return view('berita');
});

Route::get('/kontak', function () {
    return view('kontak');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Berita & Informasi
    Route::get('/berita', [\App\Http\Controllers\Admin\BeritaController::class, 'index'])->name('berita.index');
    
    // Data Kelurahan
    Route::get('/data-kelurahan', [DataKelurahanController::class, 'index'])->name('data-kelurahan.index');
    
    // Galeri
    Route::get('/galeri', [\App\Http\Controllers\Admin\GaleriController::class, 'index'])->name('galeri.index');
    
    // Layanan
    Route::get('/layanan', [\App\Http\Controllers\Admin\LayananController::class, 'index'])->name('layanan.index');
    
    // Profil Kelurahan
    Route::get('/profil-kelurahan', [\App\Http\Controllers\Admin\ProfilKelurahanController::class, 'index'])->name('profil-kelurahan.index');
    
    // Desa Cantik
    Route::get('/desa-cantik', [\App\Http\Controllers\Admin\DesaCantikController::class, 'index'])->name('desa-cantik.index');
    
    // Data Lurah
    Route::get('/data-lurah', [\App\Http\Controllers\Admin\DataLurahController::class, 'index'])->name('data-lurah.index');
    Route::get('/data-lurah/api', [\App\Http\Controllers\Admin\DataLurahController::class, 'getData'])->name('data-lurah.api');
    Route::post('/data-lurah/update', [\App\Http\Controllers\Admin\DataLurahController::class, 'update'])->name('data-lurah.update');
    
    // Berita
    Route::resource('berita', \App\Http\Controllers\Admin\BeritaController::class);
    Route::post('/berita/{berita}/toggle-publish', [\App\Http\Controllers\Admin\BeritaController::class, 'togglePublish'])->name('berita.toggle-publish');
    Route::get('/berita/{berita}/edit-data', [\App\Http\Controllers\Admin\BeritaController::class, 'getEditData'])->name('berita.edit-data');
    
    // Pengaturan
    Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
    
    // Add more admin routes here
    // Example:
    // Route::resource('users', UserController::class);
    // Route::resource('roles', RoleController::class);
});
