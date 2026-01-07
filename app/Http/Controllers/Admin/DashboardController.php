<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Penduduk;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data statistik dari database
        $totalBerita = Berita::count();
        $totalBeritaPublished = Berita::where('is_published', true)->count();
        $totalPenduduk = Penduduk::count();
        
        // Hitung statistik penduduk
        $totalLakiLaki = Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Penduduk::where('jenis_kelamin', 'Perempuan')->count();
        $totalKepalaKeluarga = Penduduk::where('jenis_kelamin', 'Laki-laki')
                                    ->where('status', 'Menikah')
                                    ->count();
        
        // Ambil berita terbaru
        $recentBerita = Berita::orderBy('tanggal_publikasi', 'desc')
                              ->take(5)
                              ->get();
        
        // Hitung berita bulan ini
        $beritaBulanIni = Berita::whereMonth('tanggal_publikasi', now()->month)
                                ->whereYear('tanggal_publikasi', now()->year)
                                ->count();
        
        // Hitung penduduk bulan ini (asumsi ada created_at)
        $pendudukBulanIni = Penduduk::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count();

        return view('admin.dashboard', compact(
            'totalBerita',
            'totalBeritaPublished',
            'totalPenduduk',
            'totalLakiLaki',
            'totalPerempuan',
            'totalKepalaKeluarga',
            'recentBerita',
            'beritaBulanIni',
            'pendudukBulanIni'
        ));
    }
}
