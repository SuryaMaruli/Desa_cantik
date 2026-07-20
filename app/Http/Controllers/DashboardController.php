<?php

namespace App\Http\Controllers;

use App\Models\AgendaKegiatan;
use App\Models\Beranda;
use App\Models\DataLurah;
use App\Models\Prestasi;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        $dataLurah = DataLurah::first();
        $beranda = Beranda::first();
        $prestasi = Prestasi::with('fotos')->latest()->take(6)->get();
        $agendaKegiatans = AgendaKegiatan::orderBy('tanggal_kegiatan')->get();

        return view('dashboard.index', compact('dataLurah', 'beranda', 'prestasi', 'agendaKegiatans'));
    }

    /**
     * Display kata sambutan page.
     *
     * @return \Illuminate\View\View
     */
    public function kataSambutan()
    {
        $dataLurah = DataLurah::first();

        return view('kata-sambutan', compact('dataLurah'));
    }
}