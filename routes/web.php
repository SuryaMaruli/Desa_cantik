<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// --- CONTROLLERS IMPORT ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataKelurahanController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfilKelurahanController;
use App\Http\Controllers\Admin\DesaCantikController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\DataLurahController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\InformasiPublikController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\MaklumatPelayanananController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\MonografiController;
use App\Http\Controllers\BatasWilayahController;

// --- MODELS IMPORT (Untuk Public Routes) ---
use App\Models\Layanan;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\TentangDesa;
use App\Models\MetadataStatistik;
use App\Models\OutputProgram;
use App\Models\Prestasi;
use App\Models\Penduduk;
use App\Models\DataKelurahanStatistik;
use App\Models\ProfilKelurahan;
use App\Models\Monografi;

$rawRequestCookies = function (Request $request): array {
    $cookieHeader = (string) $request->server->get('HTTP_COOKIE', '');

    if ($cookieHeader === '') {
        return $request->cookies->all();
    }

    $cookies = [];

    foreach (explode(';', $cookieHeader) as $cookie) {
        [$name, $value] = array_pad(explode('=', trim($cookie), 2), 2, '');

        if ($name !== '') {
            $cookies[urldecode($name)] = urldecode($value);
        }
    }

    return $cookies ?: $request->cookies->all();
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES (Frontend)
// =========================================================================

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/kata-sambutan', [DashboardController::class, 'kataSambutan'])->name('kata-sambutan');

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
    $subjects = config('data_kelurahan.subjects', []);
    $values = DataKelurahanStatistik::query()
        ->get()
        ->keyBy('dataset_key');

    return view('data', compact('subjects', 'values'));
});

Route::get('/cek-login', function () {
    return [
        'url' => request()->fullUrl(),
        'check' => auth()->check(),
        'user' => auth()->user()?->email,
        'session_id' => session()->getId(),
    ];
})->middleware('web');

Route::get('/desa-cantik', function () {
    $tentang = TentangDesa::first();
    $metadata = MetadataStatistik::all();
    $outputPrograms = OutputProgram::all();
    $prestasi = Prestasi::latest()->get();
    return view('desa-cantik', compact('tentang', 'metadata', 'outputPrograms', 'prestasi'));
});
Route::get('/desa-cantik/output/{id}', [DesaCantikController::class, 'showOutput'])->name('desa-cantik.show-output');

Route::get('/galeri-kegiatan', function () {
    $allPhotos = Galeri::orderBy('position', 'asc')
        ->orderBy('grup_order', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

    $groupedGaleri = [];
    $processedGroups = [];

    foreach ($allPhotos as $photo) {
        $groupId = $photo->grup_id ?? 'single_' . $photo->id_galeri;

        if (!in_array($groupId, $processedGroups)) {
            $processedGroups[] = $groupId;

            if ($photo->grup_id) {
                $groupPhotos = $allPhotos->where('grup_id', $photo->grup_id)
                    ->sortBy('grup_order')
                    ->values();
            } else {
                $groupPhotos = collect([$photo]);
            }

            $utama = $groupPhotos->firstWhere('is_grup_utama', true) ?? $groupPhotos->first();

            $groupedGaleri[] = (object) [
                'id' => $utama->id_galeri,
                'id_galeri' => $utama->id_galeri,
                'grup_id' => $photo->grup_id,
                'position' => $utama->position,
                'judul_foto' => $utama->judul_foto,
                'deskripsi' => $utama->deskripsi,
                'kategori' => $utama->kategori,
                'tanggal_kegiatan' => $utama->tanggal_kegiatan,
                'foto' => $utama->foto,
                'is_group' => $photo->grup_id !== null,
                'photo_count' => $groupPhotos->count(),
                'group_photos' => $groupPhotos,
                'utama' => $utama,
            ];
        }
    }

    usort($groupedGaleri, function ($a, $b) {
        return $a->position - $b->position;
    });

    $galeri = collect($groupedGaleri);

    return view('galeri-kegiatan', compact('galeri'));
})->name('galeri-kegiatan');

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/berita', function () {
    $kategori = request('kategori');

    $beritaUtama = Berita::where('is_published', true)
        ->where('is_utama', true)
        ->first();

    $query = Berita::where('is_published', true)->orderBy('tanggal_publikasi', 'desc');

    if ($beritaUtama) {
        $query->where('id', '!=', $beritaUtama->id);
    }

    if ($kategori && $kategori !== 'Semua') {
        $query->where('kategori', $kategori);
    }

    $berita = $query->get();

    $kategoriList = Berita::where('is_published', true)
        ->whereNotNull('kategori')
        ->distinct()
        ->pluck('kategori')
        ->sort()
        ->values();

    return view('berita', compact('berita', 'kategori', 'kategoriList', 'beritaUtama'));
});

Route::get('/berita/{id}', function ($id) {
    $berita = Berita::where('id', $id)->where('is_published', true)->first();
    if (!$berita) abort(404);

    $berita->increment('views');

    return view('berita-detail', compact('berita'));
});

Route::get('/maklumat-pelayananan', function () {
    return view('maklumat-pelayananan');
});

Route::get('/struktur-organisasi', function () {
    return view('struktur-organisasi');
});

Route::get('/api/batas-wilayah', [BatasWilayahController::class, 'getVillageBoundaries'])->name('api.batas-wilayah');

Route::get('/{village}/{path?}', function (Request $request, string $village, ?string $path = null) use ($rawRequestCookies) {
    abort_unless(array_key_exists($village, config('villages.items', [])), 404);

    $targetPath = '/' . ltrim($path ?? '', '/');
    $server = $request->server->all();
    $server['CURRENT_VILLAGE_SLUG'] = $village;
    $server['REQUEST_URI'] = $targetPath . ($request->server->get('QUERY_STRING') ? '?' . $request->server->get('QUERY_STRING') : '');
    $server['PATH_INFO'] = $targetPath;

    $forwardedRequest = Request::create(
        $targetPath,
        'GET',
        $request->query->all(),
        $rawRequestCookies($request),
        [],
        $server
    );

    if ($request->hasSession()) {
        $forwardedRequest->setLaravelSession($request->session());
    }

    return app()->handle($forwardedRequest);
})->where('village', implode('|', array_map('preg_quote', array_keys(config('villages.items', [])))))
  ->where('path', '.*');

// =========================================================================
// 2. AUTHENTICATION ROUTES
// =========================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

Route::get('/admin/switch-village/{village}', function (Request $request, string $village) {
    abort_unless(auth()->user()?->role === 'super_admin', 403);
    abort_unless(array_key_exists($village, config('villages.items', [])), 404);

    $request->session()->put('admin_active_village', $village);

    $redirect = trim((string) $request->query('redirect', 'dashboard'), '/');
    $redirect = $redirect === '' ? 'dashboard' : $redirect;

    if (str_starts_with($redirect, 'admin/')) {
        $redirect = trim(substr($redirect, strlen('admin/')), '/');
    }

    return redirect('/admin/' . $redirect);
})->middleware('auth')->name('admin.switch-village');

Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], '/admin/{village}/{path?}', function (Request $request, string $village, ?string $path = null) {
    abort_unless(array_key_exists($village, config('villages.items', [])), 404);

    $adminPath = trim((string) ($path ?? 'dashboard'), '/');
    $adminPath = $adminPath === '' ? 'dashboard' : $adminPath;

    if (auth()->user()?->role === 'super_admin') {
        $request->session()->put('admin_active_village', $village);

        return redirect('/admin/' . $adminPath);
    }

    $userVillage = auth()->user()?->village;

    if ($userVillage && $village !== $userVillage->slug) {
        return redirect('/admin/dashboard')
            ->with('error', 'Anda hanya dapat mengelola website ' . ($userVillage->official_name ?? 'kelurahan Anda') . '.');
    }

    return redirect('/admin/' . $adminPath);
})->where('village', implode('|', array_map('preg_quote', array_keys(config('villages.items', [])))))
  ->where('path', '.*')
  ->middleware('auth');

// =========================================================================
// 3. ADMIN ROUTES
// =========================================================================

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');
    Route::post('/beranda', [BerandaController::class, 'store'])->name('beranda.store');
    Route::put('/beranda/{id}', [BerandaController::class, 'update'])->name('beranda.update');
    Route::put('/beranda/{id}/image', [BerandaController::class, 'updateImage'])->name('beranda.update.image');
    Route::put('/beranda/{id}/logo', [BerandaController::class, 'updateLogo'])->name('beranda.update.logo');

    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    Route::get('/data-kelurahan', [DataKelurahanController::class, 'index'])->name('data-kelurahan.index');
    Route::post('/data-kelurahan/store', [DataKelurahanController::class, 'store'])->name('data-kelurahan.store');
    Route::put('/data-kelurahan/update/{id}', [DataKelurahanController::class, 'update'])->name('data-kelurahan.update');
    Route::delete('/data-kelurahan/delete/{id}', [DataKelurahanController::class, 'destroy'])->name('data-kelurahan.destroy');

    Route::resource('galeri', GaleriController::class);
    Route::post('galeri/update-position', [GaleriController::class, 'updatePosition'])->name('galeri.update-position');
    Route::post('galeri/bulk-destroy', [GaleriController::class, 'bulkDestroy'])->name('galeri.bulk-destroy');

    Route::get('/profil-kelurahan', [ProfilKelurahanController::class, 'index'])->name('profil-kelurahan.index');
    Route::put('/profil-kelurahan', [ProfilKelurahanController::class, 'update'])->name('profil-kelurahan.update');

    Route::get('/desa-cantik', [DesaCantikController::class, 'index'])->name('desa-cantik.index');
    Route::post('/desa-cantik/tentang', [DesaCantikController::class, 'updateTentang'])->name('desa-cantik.update-tentang');
    Route::post('/desa-cantik/metadata', [DesaCantikController::class, 'storeMetadata'])->name('desa-cantik.store-metadata');
    Route::put('/desa-cantik/metadata/{id}', [DesaCantikController::class, 'updateMetadata'])->name('desa-cantik.update-metadata');
    Route::delete('/desa-cantik/metadata/{id}', [DesaCantikController::class, 'deleteMetadata'])->name('desa-cantik.delete-metadata');
    Route::post('/desa-cantik/output', [DesaCantikController::class, 'storeOutput'])->name('desa-cantik.store-output');
    Route::put('/desa-cantik/output/{id}', [DesaCantikController::class, 'updateOutput'])->name('desa-cantik.update-output');
    Route::delete('/desa-cantik/output/{id}', [DesaCantikController::class, 'deleteOutput'])->name('desa-cantik.delete-output');

    Route::post('/informasi-publik/agenda', [InformasiPublikController::class, 'storeAgenda'])->name('informasi-publik.agenda.store');
    Route::put('/informasi-publik/agenda/{id}', [InformasiPublikController::class, 'updateAgenda'])->name('informasi-publik.agenda.update');
    Route::delete('/informasi-publik/agenda/{id}', [InformasiPublikController::class, 'destroyAgenda'])->name('informasi-publik.agenda.destroy');

    Route::resource('prestasi', PrestasiController::class)->except(['show']);

    Route::get('/data-lurah', [DataLurahController::class, 'index'])->name('data-lurah.index');
    Route::get('/data-lurah/api', [DataLurahController::class, 'getData'])->name('data-lurah.api');
    Route::post('/data-lurah/update', [DataLurahController::class, 'update'])->name('data-lurah.update');
    Route::delete('/data-lurah/sambutan', [DataLurahController::class, 'destroySambutan'])->name('data-lurah.destroy-sambutan');

    Route::resource('admin', AdminController::class)->except(['show']);

    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    Route::get('/berita/search', [BeritaController::class, 'search'])->name('berita.search');
    Route::resource('berita', BeritaController::class)->except(['show']);
    Route::post('/berita/{berita}/toggle-publish', [BeritaController::class, 'togglePublish'])->name('berita.toggle-publish');
    Route::post('/berita/{berita}/set-utama', [BeritaController::class, 'setUtama'])->name('berita.set-utama');
    Route::get('/berita/{berita}/edit-data', [BeritaController::class, 'getEditData'])->name('berita.edit-data');
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');

    Route::get('/maklumat-pelayananan', [MaklumatPelayanananController::class, 'index'])->name('maklumat-pelayananan.index');
    Route::post('/maklumat-pelayananan', [MaklumatPelayanananController::class, 'store'])->name('maklumat-pelayananan.store');
    Route::put('/maklumat-pelayananan/{id}', [MaklumatPelayanananController::class, 'update'])->name('maklumat-pelayananan.update');
    Route::delete('/maklumat-pelayananan/{id}', [MaklumatPelayanananController::class, 'destroy'])->name('maklumat-pelayananan.destroy');

    Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'index'])->name('struktur-organisasi.index');
    Route::post('/struktur-organisasi', [StrukturOrganisasiController::class, 'store'])->name('struktur-organisasi.store');
    Route::put('/struktur-organisasi/{id}', [StrukturOrganisasiController::class, 'update'])->name('struktur-organisasi.update');
    Route::delete('/struktur-organisasi/{id}', [StrukturOrganisasiController::class, 'destroy'])->name('struktur-organisasi.destroy');

    Route::get('/monografi', [MonografiController::class, 'index'])->name('monografi.index');
    Route::post('/monografi', [MonografiController::class, 'store'])->name('monografi.store');
    Route::put('/monografi/{id}', [MonografiController::class, 'update'])->name('monografi.update');
    Route::delete('/monografi/{id}', [MonografiController::class, 'destroy'])->name('monografi.destroy');
});
