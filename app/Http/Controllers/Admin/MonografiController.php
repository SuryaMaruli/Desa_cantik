<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Monografi;
use Illuminate\Support\Facades\Storage;

class MonografiController extends Controller
{
    // =================================================================
    // 1. MENAMPILKAN DATA (INDEX)
    // =================================================================
    public function index()
    {
        // Mengambil data urut dari terbaru
        $monografis = Monografi::latest()->get();
        
        // Memastikan URL gambar siap dipakai di View
        foreach ($monografis as $item) {
            // Kita panggil accessor yang sudah dibuat di Model
            $item->gambar_mono_url = $item->gambar_mono_url;
            $item->gambar_struktur_url = $item->gambar_struktur_url;
        }

        return view('admin.monografi.index', compact('monografis'));
    }

    // =================================================================
    // 2. MENYIMPAN DATA BARU (STORE)
    // =================================================================
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'gambar_mono'     => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
            'gambar_struktur' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            // Upload File
            $pathMono = $request->file('gambar_mono')->store('monografi', 'public');
            $pathStruktur = $request->file('gambar_struktur')->store('monografi', 'public');

            // Simpan ke Database
            // Create aman digunakan karena fieldnya jelas
            Monografi::create([
                'gambar_mono'     => $pathMono,
                'gambar_struktur' => $pathStruktur,
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Data Monografi berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    // =================================================================
    // 3. MENGAMBIL DATA UNTUK EDIT (EDIT)
    // =================================================================
    public function edit($id)
    {
        // PENTING: Gunakan where('id_monografi', ...) bukan find(...)
        $monografi = Monografi::where('id_monografi', $id)->first();

        if (!$monografi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // Pastikan URL gambar ter-generate
        $monografi->gambar_mono_url = $monografi->gambar_mono_url;
        $monografi->gambar_struktur_url = $monografi->gambar_struktur_url;

        return response()->json([
            'success' => true, 
            'data' => $monografi
        ]);
    }

    // =================================================================
    // 4. UPDATE DATA (UPDATE) - FIX UTAMA DISINI
    // =================================================================
    public function update(Request $request, $id)
    {
        // 1. Cari data lama untuk keperluan hapus file
        $monografiLama = Monografi::where('id_monografi', $id)->first();

        if (!$monografiLama) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // 2. Validasi (Nullable karena user mungkin tidak ganti gambar)
        $request->validate([
            'gambar_mono'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gambar_struktur' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            // Array penampung data yang akan diupdate
            $dataToUpdate = [];

            // A. Cek Update Gambar Monografi
            if ($request->hasFile('gambar_mono')) {
                // Hapus file fisik lama
                if ($monografiLama->gambar_mono && Storage::disk('public')->exists($monografiLama->gambar_mono)) {
                    Storage::disk('public')->delete($monografiLama->gambar_mono);
                }
                // Upload baru & masukkan path ke array update
                $dataToUpdate['gambar_mono'] = $request->file('gambar_mono')->store('monografi', 'public');
            }

            // B. Cek Update Gambar Struktur
            if ($request->hasFile('gambar_struktur')) {
                // Hapus file fisik lama
                if ($monografiLama->gambar_struktur && Storage::disk('public')->exists($monografiLama->gambar_struktur)) {
                    Storage::disk('public')->delete($monografiLama->gambar_struktur);
                }
                // Upload baru & masukkan path ke array update
                $dataToUpdate['gambar_struktur'] = $request->file('gambar_struktur')->store('monografi', 'public');
            }

            // C. Eksekusi Update ke Database
            // Jika ada file yang berubah, kita update database
            if (!empty($dataToUpdate)) {
                // PENTING: Gunakan update() pada Query Builder agar tidak mencari kolom 'id'
                Monografi::where('id_monografi', $id)->update($dataToUpdate);
            }

            return response()->json([
                'success' => true, 
                'message' => 'Data Monografi berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal update data: ' . $e->getMessage()
            ], 500);
        }
    }

    // =================================================================
    // 5. HAPUS DATA (DESTROY) - FIX UTAMA DISINI
    // =================================================================
    public function destroy($id)
    {
        // 1. Cari data dulu
        $monografi = Monografi::where('id_monografi', $id)->first();

        if (!$monografi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        try {
            // 2. Hapus File Fisik
            if ($monografi->gambar_mono && Storage::disk('public')->exists($monografi->gambar_mono)) {
                Storage::disk('public')->delete($monografi->gambar_mono);
            }
            if ($monografi->gambar_struktur && Storage::disk('public')->exists($monografi->gambar_struktur)) {
                Storage::disk('public')->delete($monografi->gambar_struktur);
            }

            // 3. Hapus Record Database
            // Gunakan delete() pada Query Builder agar aman dari error ID
            Monografi::where('id_monografi', $id)->delete();

            return response()->json([
                'success' => true, 
                'message' => 'Data Monografi berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}