<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StrukturOrganisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $struktur = StrukturOrganisasi::latest()->get();
        return view('admin.struktur-organisasi.index', compact('struktur'));
    }

    private function respond(Request $request, string $status, string $message, int $code = 200, ?string $redirectRoute = null)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ], $code);
        }

        $redirect = $redirectRoute
            ? redirect()->route($redirectRoute)
            : redirect()->back();

        return $redirect->with($status === 'success' ? 'success' : 'error', $message);
    }

    public function store(Request $request)
    {
        Log::info('=== STRUKTUR ORGANISASI STORE START ===');
        Log::info('Request data:', $request->all());

        try {
            // Check if there's already a photo
            $existingStruktur = StrukturOrganisasi::first();
            if ($existingStruktur) {
                return $this->respond(
                    $request,
                    'error',
                    'Hanya dapat menambahkan satu foto! Silakan edit atau hapus foto yang ada terlebih dahulu.',
                    422,
                    'admin.struktur-organisasi.index'
                );
            }

            $validator = Validator::make($request->all(), [
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            ]);

            if ($validator->fails()) {
                return $this->respond($request, 'error', $validator->errors()->first(), 422);
            }

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                if ($file->isValid()) {
                    $filename = time() . '_struktur_' . $file->getClientOriginalName();
                    $path = $file->storeAs('struktur-organisasi', $filename, 'public');

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
                    StrukturOrganisasi::create([
                        'gambar' => $path,
                    ]);

                    return $this->respond(
                        $request,
                        'success',
                        'Gambar struktur organisasi berhasil ditambahkan!',
                        200,
                        'admin.struktur-organisasi.index'
                    );
                }
            }

            return $this->respond($request, 'error', 'Tidak ada file yang diupload', 422);

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return $this->respond($request, 'error', 'Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('=== STRUKTUR ORGANISASI UPDATE START ===');
        Log::info('ID: ' . $id);

        try {
            $struktur = StrukturOrganisasi::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            ]);

            if ($validator->fails()) {
                return $this->respond($request, 'error', $validator->errors()->first(), 422);
            }

            $data = [];

            // Handle file upload if new file is provided
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                if ($file->isValid()) {
                    // Delete old file
                    if ($struktur->gambar) {
                        $oldPath = public_path('storage/' . $struktur->gambar);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                        $oldAppPath = storage_path('app/public/' . $struktur->gambar);
                        if (file_exists($oldAppPath)) {
                            unlink($oldAppPath);
                        }
                    }

                    $filename = time() . '_struktur_' . $file->getClientOriginalName();
                    $path = $file->storeAs('struktur-organisasi', $filename, 'public');

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

            $struktur->update($data);

            return $this->respond(
                $request,
                'success',
                'Gambar struktur organisasi berhasil diupdate!',
                200,
                'admin.struktur-organisasi.index'
            );

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return $this->respond($request, 'error', 'Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        Log::info('=== STRUKTUR ORGANISASI DELETE START ===');
        Log::info('ID: ' . $id);

        try {
            $struktur = StrukturOrganisasi::findOrFail($id);

            // Delete file from storage
            if ($struktur->gambar) {
                $filePath = public_path('storage/' . $struktur->gambar);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $appFilePath = storage_path('app/public/' . $struktur->gambar);
                if (file_exists($appFilePath)) {
                    unlink($appFilePath);
                }
            }

            $struktur->delete();

            return $this->respond(
                request(),
                'success',
                'Gambar struktur organisasi berhasil dihapus!',
                200,
                'admin.struktur-organisasi.index'
            );

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return $this->respond(request(), 'error', 'Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }
}
