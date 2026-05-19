<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaklumatPelayananan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaklumatPelayanananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $maklumat = MaklumatPelayananan::latest()->get();
        return view('admin.maklumat-pelayananan.index', compact('maklumat'));
    }

public function store(Request $request)
    {
        Log::info('=== MAKLUMAT PELAYANAN STORE START ===');
        Log::info('Request data:', $request->all());

        try {
            // Check if there's already a photo
            $existingMaklumat = MaklumatPelayananan::first();
            if ($existingMaklumat) {
                return redirect()->route('admin.maklumat-pelayananan.index')
                    ->with('error', 'Hanya dapat menambahkan satu foto! Silakan edit atau hapus foto yang ada terlebih dahulu.');
            }

            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            ]);

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                if ($file->isValid()) {
                    $filename = time() . '_maklumat_' . $file->getClientOriginalName();
                    $path = $file->storeAs('maklumat-pelayananan', $filename, 'public');

                    Log::info('File uploaded: ' . $path);

                    // Copy to public storage for immediate access
                    $sourcePath = storage_path('app/public/' . $path);
                    $destPath = public_path('storage/' . $path);
                    $destDir = dirname($destPath);

                    if (!is_dir($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    copy($sourcePath, $destPath);

                    // Create record
                    MaklumatPelayananan::create([
                        'gambar' => $path,
                    ]);

                    return redirect()->route('admin.maklumat-pelayananan.index')
                        ->with('success', 'Gambar maklumat berhasil ditambahkan!');
                }
            }

            return redirect()->back()
                ->with('error', 'Tidak ada file yang diupload')
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('=== MAKLUMAT PELAYANAN UPDATE START ===');
        Log::info('ID: ' . $id);

        try {
            $maklumat = MaklumatPelayananan::findOrFail($id);

            $request->validate([
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            ]);

            $data = [];

            // Handle file upload if new file is provided
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                if ($file->isValid()) {
                    // Delete old file
                    if ($maklumat->gambar) {
                        $oldPath = public_path('storage/' . $maklumat->gambar);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                        $oldAppPath = storage_path('app/public/' . $maklumat->gambar);
                        if (file_exists($oldAppPath)) {
                            unlink($oldAppPath);
                        }
                    }

                    $filename = time() . '_maklumat_' . $file->getClientOriginalName();
                    $path = $file->storeAs('maklumat-pelayananan', $filename, 'public');

                    Log::info('New file uploaded: ' . $path);

                    // Copy to public storage
                    $sourcePath = storage_path('app/public/' . $path);
                    $destPath = public_path('storage/' . $path);
                    $destDir = dirname($destPath);

                    if (!is_dir($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    copy($sourcePath, $destPath);

                    $data['gambar'] = $path;
                }
            }

            $maklumat->update($data);

            return redirect()->route('admin.maklumat-pelayananan.index')
                ->with('success', 'Gambar maklumat berhasil diupdate!');

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        Log::info('=== MAKLUMAT PELAYANAN DELETE START ===');
        Log::info('ID: ' . $id);

        try {
            $maklumat = MaklumatPelayananan::findOrFail($id);

            // Delete file from storage
            if ($maklumat->gambar) {
                $filePath = public_path('storage/' . $maklumat->gambar);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $appFilePath = storage_path('app/public/' . $maklumat->gambar);
                if (file_exists($appFilePath)) {
                    unlink($appFilePath);
                }
            }

            $maklumat->delete();

            return redirect()->route('admin.maklumat-pelayananan.index')
                ->with('success', 'Gambar maklumat berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
