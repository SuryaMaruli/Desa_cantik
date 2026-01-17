<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLurah;
use App\Models\Beranda;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dataLurah = DataLurah::first();
        $beranda = Beranda::first();
        return view('dashboard.index', compact('dataLurah', 'beranda'));
    }
}
