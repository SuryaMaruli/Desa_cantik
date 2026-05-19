<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Monografi;
use Illuminate\Support\Facades\Storage;

class MonografiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $monografis = Monografi::latest()->get();
        return view('admin.monografi.index', compact('monografis'));
    }

/**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if there's already a photo
        $existingMonografi = Monografi::first();
        if ($existingMonografi) {
            return redirect()->route('admin.monografi.index')
                ->with('error', 'Hanya dapat menambahkan satu foto! Silakan edit atau hapus foto yang ada terlebih dahulu.');
        }

        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            // Upload File
            $file = $request->file('gambar');
            $path = $file->store('monografi', 'public');

            // Copy to public storage for immediate access
            $sourcePath = storage_path('app/public/' . $path);
            $destPath = public_path('storage/' . $path);
            $destDir = dirname($destPath);

            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            copy($sourcePath, $destPath);

            // Simpan ke Database
            Monografi::create([
                'gambar_mono' => $path,
            ]);

            return redirect()->route('admin.monografi.index')->with('success', 'Gambar Monografi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.monografi.index')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

/**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $monografi = Monografi::where('id_monografi', $id)->firstOrFail();

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            // Jika ada file baru, hapus yang lama dan upload yang baru
            if ($request->hasFile('gambar')) {
                // Hapus file fisik lama dari kedua lokasi
                if ($monografi->gambar_mono) {
                    // Hapus dari storage/app/public/
                    if (Storage::disk('public')->exists($monografi->gambar_mono)) {
                        Storage::disk('public')->delete($monografi->gambar_mono);
                    }
                    // Hapus dari public/storage/
                    $oldPublicPath = public_path('storage/' . $monografi->gambar_mono);
                    if (file_exists($oldPublicPath)) {
                        unlink($oldPublicPath);
                    }
                }

                // Upload baru
                $file = $request->file('gambar');
                $path = $file->store('monografi', 'public');

                // Copy to public storage for immediate access
                $sourcePath = storage_path('app/public/' . $path);
                $destPath = public_path('storage/' . $path);
                $destDir = dirname($destPath);

                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                copy($sourcePath, $destPath);

                $monografi->gambar_mono = $path;
                $monografi->save();
            }

            return redirect()->route('admin.monografi.index')->with('success', 'Gambar Monografi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.monografi.index')->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

/**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $monografi = Monografi::where('id_monografi', $id)->firstOrFail();

        try {
            // Hapus File Fisik dari kedua lokasi
            if ($monografi->gambar_mono) {
                // Hapus dari storage/app/public/
                if (Storage::disk('public')->exists($monografi->gambar_mono)) {
                    Storage::disk('public')->delete($monografi->gambar_mono);
                }
                // Hapus dari public/storage/
                $oldPublicPath = public_path('storage/' . $monografi->gambar_mono);
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
                }
            }

            // Hapus Record Database
            $monografi->delete();

            return redirect()->route('admin.monografi.index')->with('success', 'Gambar Monografi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.monografi.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
