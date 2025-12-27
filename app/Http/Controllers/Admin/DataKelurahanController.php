<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataKelurahanController extends Controller
{
    /**
     * Display the data kelurahan page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'total_penduduk' => '15,847',
            'laki_laki' => '8,123',
            'perempuan' => '7,724',
            'kepala_keluarga' => '4,256',
            'rws' => [
                ['no' => '01', 'jumlah' => '1,842', 'persentase' => 85],
                ['no' => '02', 'jumlah' => '1,654', 'persentase' => 78],
                ['no' => '03', 'jumlah' => '1,923', 'persentase' => 90],
                ['no' => '04', 'jumlah' => '1,456', 'persentase' => 65],
                ['no' => '05', 'jumlah' => '1,789', 'persentase' => 80],
                ['no' => '06', 'jumlah' => '1,567', 'persentase' => 72],
                ['no' => '07', 'jumlah' => '1,834', 'persentase' => 84],
                ['no' => '08', 'jumlah' => '1,691', 'persentase' => 79],
                ['no' => '09', 'jumlah' => '1,524', 'persentase' => 70],
                ['no' => '10', 'jumlah' => '1,567', 'persentase' => 72],
            ]
        ];

        return view('admin.data-kelurahan.index', compact('data'));
    }
}
