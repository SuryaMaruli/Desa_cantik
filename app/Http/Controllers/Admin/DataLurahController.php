<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataLurah;

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
        try {
            $dataLurah = DataLurah::first();
            
            if (!$dataLurah) {
                $dataLurah = new DataLurah();
            }

            $dataLurah->nama_lurah = $request->namaLurah;
            $dataLurah->nip = $request->nipLurah;
            $dataLurah->pangkat = $request->pangkatLurah;
            $dataLurah->golongan = $request->golonganLurah;
            $dataLurah->jabatan = $request->jabatanLurah;
            $dataLurah->sambutan_lurah = $request->sambutanLurah;
            
            // Handle foto upload
            if ($request->hasFile('fotoLurah')) {
                $file = $request->file('fotoLurah');
                
                // Delete old photo if exists
                if ($dataLurah->foto_lurah && file_exists(public_path('storage/foto-lurah/' . $dataLurah->foto_lurah))) {
                    unlink(public_path('storage/foto-lurah/' . $dataLurah->foto_lurah));
                }
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Move file to storage
                $file->move(public_path('storage/foto-lurah'), $filename);
                
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
}
