<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLurah;

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
        return view('dashboard.index', compact('dataLurah'));
    }
}
