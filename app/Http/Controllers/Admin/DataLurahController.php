<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataLurah;
use Illuminate\Support\Facades\Storage;

class DataLurahController extends Controller
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
     * Display the data lurah page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dataLurah = DataLurah::first();
        return view('admin.data-lurah.index', compact('dataLurah'));
    }

    /**
     * Update data lurah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'namaLurah' => 'nullable|string|max:255',
            'nipLurah' => 'nullable|string|max:100',
            'pangkatLurah' => 'nullable|string|max:100',
            'golonganLurah' => 'nullable|string|max:100',
            'jabatanLurah' => 'nullable|string|max:150',
            'sambutanLurah' => 'nullable|string',
            'fotoLurah' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $dataLurah = DataLurah::first();
            
            if (!$dataLurah) {
                $dataLurah = new DataLurah();
            }

            $dataLurah->nama_lurah = $validated['namaLurah'] ?? null;
            $dataLurah->nip = $validated['nipLurah'] ?? null;
            $dataLurah->pangkat = $validated['pangkatLurah'] ?? null;
            $dataLurah->golongan = $validated['golonganLurah'] ?? null;
            $dataLurah->jabatan = $validated['jabatanLurah'] ?? null;
            $dataLurah->sambutan_lurah = $validated['sambutanLurah'] ?? null;
            
            // Handle foto upload
            if ($request->hasFile('fotoLurah')) {
                $file = $request->file('fotoLurah');
                
                // Delete old photo if exists
                if ($dataLurah->foto_lurah && Storage::disk('public')->exists('foto-lurah/' . $dataLurah->foto_lurah)) {
                    Storage::disk('public')->delete('foto-lurah/' . $dataLurah->foto_lurah);
                }
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store file through Laravel's public disk for hosting-safe permissions.
                $file->storeAs('foto-lurah', $filename, 'public');
                
                $dataLurah->foto_lurah = $filename;
            }
            
            $dataLurah->save();

            return response()->json([
                'success' => true,
                'message' => 'Data lurah berhasil diperbarui!',
                'data' => $dataLurah,
                'foto_url' => $dataLurah->foto_lurah ? asset('storage/foto-lurah/' . $dataLurah->foto_lurah) : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data lurah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data lurah for API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        try {
            $dataLurah = DataLurah::first();
            
            if (!$dataLurah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data lurah tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $dataLurah
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lurah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus konten kata sambutan + foto lurah (record tetap ada).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySambutan()
    {
        try {
            $dataLurah = DataLurah::first();

            if (!$dataLurah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data lurah tidak ditemukan'
                ], 404);
            }

            if ($dataLurah->foto_lurah && Storage::disk('public')->exists('foto-lurah/' . $dataLurah->foto_lurah)) {
                Storage::disk('public')->delete('foto-lurah/' . $dataLurah->foto_lurah);
            }

            $dataLurah->foto_lurah = null;
            $dataLurah->sambutan_lurah = null;
            $dataLurah->save();

            return response()->json([
                'success' => true,
                'message' => 'Kata sambutan dan foto lurah berhasil dihapus.',
                'data' => $dataLurah
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kata sambutan: ' . $e->getMessage()
            ], 500);
        }
    }
}
