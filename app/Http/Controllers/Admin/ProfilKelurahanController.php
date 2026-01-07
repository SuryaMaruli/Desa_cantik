<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilKelurahan;

class ProfilKelurahanController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika tidak ada return null agar tidak error di view
        $profilKelurahan = ProfilKelurahan::first();
        return view('admin.profil-kelurahan.index', compact('profilKelurahan'));
    }

    public function update(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'nama_kelurahan'          => 'required|string|max:255',
            'tahun_pembukaan'         => 'nullable|integer',
            'nomor_kode_wilayah'      => 'nullable|string',
            'nomor_kode_pos'          => 'nullable|string',
            'kecamatan'               => 'nullable|string',
            'kabupaten_kota'          => 'nullable|string',
            'provinsi'                => 'nullable|string',
            'dasar_hukum_pembentukan' => 'nullable|string',
            'visi'                    => 'nullable|string',
            // Validasi Misi (Array)
            'misi'                    => 'nullable|array',
            'misi.*'                  => 'nullable|string', 
            // Batas Wilayah
            'wilayah_utara'           => 'nullable|string',
            'wilayah_timur'           => 'nullable|string',
            'wilayah_selatan'         => 'nullable|string',
            'wilayah_barat'           => 'nullable|string',
        ]);

        // 2. Simpan Data
        // Kita gunakan id => 1 sebagai patokan karena ini Single Record
        // Jika belum ada, dia buat baru. Jika ada, dia update.
        try {
            $profil = ProfilKelurahan::updateOrCreate(
                ['id' => 1], // Kondisi pencarian (bisa diganti logic lain jika perlu)
                $validated   // Data yang disimpan
            );

            // 3. Return Response JSON untuk AJAX
            return response()->json([
                'status'  => 'success',
                'message' => 'Profil Kelurahan berhasil disimpan!',
                'data'    => $profil
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}