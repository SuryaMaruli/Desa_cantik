<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GaleriController extends Controller
{
public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get all galeri items ordered by position, then grup_order
        $allPhotos = Galeri::orderBy('position', 'asc')
            ->orderBy('grup_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Group by grup_id or id_galeri for non-grouped items
        $groupedGaleri = [];
        $processedGroups = [];
        
        foreach ($allPhotos as $photo) {
            $groupId = $photo->grup_id ?? 'single_' . $photo->id_galeri;
            
            if (!in_array($groupId, $processedGroups)) {
                $processedGroups[] = $groupId;
                
                // Get all photos in this group
                if ($photo->grup_id) {
                    $groupPhotos = $allPhotos->where('grup_id', $photo->grup_id)
                        ->sortBy('grup_order')
                        ->values();
                } else {
                    // Single photo - no group
                    $groupPhotos = collect([$photo]);
                }
                
                // Get the main (utama) photo
                $utama = $groupPhotos->firstWhere('is_grup_utama', true) ?? $groupPhotos->first();
                
$groupedGaleri[] = (object) [
                    'id' => $utama->id_galeri,
                    'id_galeri' => $utama->id_galeri,
                    'grup_id' => $photo->grup_id,
                    'position' => $utama->position,
                    'judul_foto' => $utama->judul_foto,
                    'deskripsi' => $utama->deskripsi,
                    'kategori' => $utama->kategori,
                    'tanggal_kegiatan' => $utama->tanggal_kegiatan,
                    'foto' => $utama->foto,
                    'is_group' => $photo->grup_id !== null,
                    'photo_count' => $groupPhotos->count(),
                    'group_photos' => $groupPhotos,
                    'utama' => $utama,
                ];
            }
        }
        
        // Re-sort by position
        usort($groupedGaleri, function($a, $b) {
            return $a->position - $b->position;
        });
        
        $galeri = collect($groupedGaleri);
        
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        Log::info('=== GALERI STORE START ===');
        Log::info('Method: ' . $request->method());
        Log::info('Request data:', $request->all());
        
        // Check if this is actually a POST request
        if (!$request->isMethod('post')) {
            Log::error('Not a POST request');
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        // Check if this is an AJAX request expecting JSON
        $expectsJson = $request->expectsJson() || $request->header('Accept') === 'application/json';

        try {
            // Handle multiple photos upload
            $photos = $request->file('fotos');
            $judul_base = $request->judul_foto ?? 'Foto Galeri';
            $deskripsi = $request->deskripsi ?? '';
            $kategori = $request->kategori;
            
            // Get max position
            $maxPosition = Galeri::max('position') ?? 0;
            
            $createdCount = 0;
            
            if ($photos && is_array($photos) && count($photos) > 0) {
                // Multiple file upload - create a group
                $totalPhotos = count($photos);
                
                // Generate unique group ID for this batch
                $grupId = 'GRUP_' . time();
                
                // Determine main photo index from form (or default to 0)
                $mainPhotoIndex = (int) $request->input('foto_utama_index', 0);
                
                foreach ($photos as $index => $file) {
                    if ($file && $file->isValid()) {
                        $filename = time() . '_' . ($index + 1) . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('galeri', $filename, 'public');
                        
                        Log::info('File uploaded: ' . $path);
                        
Galeri::create([
                            'judul_foto' => $judul_base,
                            'deskripsi' => $deskripsi,
                            'kategori' => $kategori,
                            'tanggal_kegiatan' => $request->input('tanggal_kegiatan') ?: date('Y-m-d'),
                            'foto' => $path,
                            'position' => $maxPosition + 1, // All photos in the group have same position
                            'grup_id' => $grupId,
                            'grup_order' => $index + 1,
                            'is_grup_utama' => ($index === $mainPhotoIndex),
                        ]);
                        
                        $createdCount++;
                    }
                }
            } elseif ($request->hasFile('foto')) {
                // Single file upload (backward compatibility)
                $file = $request->file('foto');
                
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('galeri', $filename, 'public');
                    
                    Log::info('File uploaded: ' . $path);
                    
Galeri::create([
                        'judul_foto' => $judul_base,
                        'deskripsi' => $deskripsi,
                        'kategori' => $kategori,
                        'tanggal_kegiatan' => $request->input('tanggal_kegiatan') ?: date('Y-m-d'),
                        'foto' => $path,
                        'position' => $maxPosition + 1,
                        'grup_id' => null,
                        'grup_order' => 0,
                        'is_grup_utama' => true,
                    ]);
                    
                    $createdCount++;
                }
            }
            
            if ($createdCount > 0) {
                $message = $createdCount > 1 ? "$createdCount foto berhasil ditambahkan sebagai satu grup!" : "Foto berhasil ditambahkan!";
                Log::info('Success: ' . $message);
                
                if ($expectsJson) {
                    return response()->json(['success' => true, 'message' => $message]);
                }
                
                return redirect()->route('admin.galeri.index')
                    ->with('success', $message);
            } else {
                Log::error('No files uploaded');
                
                if ($expectsJson) {
                    return response()->json(['success' => false, 'message' => 'Tidak ada file yang diupload']);
                }
                
                return redirect()->back()
                    ->with('error', 'Tidak ada file yang diupload')
                    ->withInput();
            }
            
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            
            if ($expectsJson) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.show', compact('galeri'));
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        Log::info('=== GALERI UPDATE START ===');
        Log::info('ID: ' . $id);
        Log::info('Request data:', $request->all());
        
        try {
            $galeri = Galeri::findOrFail($id);
            
$request->validate([
                'judul_foto' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'required|string',
                'tanggal_kegiatan' => 'required|date',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            Log::info('Update validation passed');

            $data = [
                'judul_foto' => $request->judul_foto,
                'deskripsi' => $request->deskripsi ?? '',
                'kategori' => $request->kategori,
                'tanggal_kegiatan' => $request->input('tanggal_kegiatan') ?: date('Y-m-d'),
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('galeri', $filename, 'public');
                    
                    Log::info('New file uploaded: ' . $path);
                    $data['foto'] = $path;
                }
            }

            $galeri->update($data);
            Log::info('Galeri updated successfully');

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Foto berhasil diupdate!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Update validation error: ' . json_encode($e->errors()));
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Update general error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        Log::info('=== GALERI DELETE START ===');
        Log::info('ID: ' . $id);
        
        try {
            $galeri = Galeri::findOrFail($id);
            
            // If this photo is part of a group, delete the entire group
            if ($galeri->grup_id) {
                $groupPhotos = Galeri::where('grup_id', $galeri->grup_id)->get();
                foreach ($groupPhotos as $photo) {
                    // Delete files
                    $filePath = public_path('storage/' . $photo->foto);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        Log::info('File deleted: ' . $filePath);
                    }
                    $appFilePath = storage_path('app/public/' . $photo->foto);
                    if (file_exists($appFilePath)) {
                        unlink($appFilePath);
                        Log::info('App storage file deleted: ' . $appFilePath);
                    }
                    $photo->delete();
                }
                Log::info('Group deleted successfully');
            } else {
                // Single photo delete
                // Delete file from storage
                $filePath = public_path('storage/' . $galeri->foto);
                if (file_exists($filePath)) {
                    unlink($filePath);
                    Log::info('File deleted: ' . $filePath);
                }
                
                // Delete from app storage
                $appFilePath = storage_path('app/public/' . $galeri->foto);
                if (file_exists($appFilePath)) {
                    unlink($appFilePath);
                    Log::info('App storage file deleted: ' . $appFilePath);
                }
                
                $galeri->delete();
                Log::info('Galeri deleted successfully');
            }

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Foto berhasil dihapus!');
                
        } catch (\Exception $e) {
            Log::error('Delete error: ' . $e->getMessage());
            return redirect()->route('admin.galeri.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Update photo positions (AJAX for drag and drop)
     */
    public function updatePosition(Request $request)
    {
        try {
            $positions = $request->input('positions', []);
            
            if (empty($positions)) {
                return response()->json(['error' => 'No positions provided'], 400);
            }
            
            // Get all galeri records to understand the group structure
            foreach ($positions as $index => $galeriId) {
                $galeri = Galeri::find($galeriId);
                if ($galeri) {
                    if ($galeri->grup_id) {
                        // If part of a group, update the position of the entire group
                        Galeri::where('grup_id', $galeri->grup_id)->update(['position' => $index + 1]);
                    } else {
                        // Single photo
                        $galeri->update(['position' => $index + 1]);
                    }
                }
            }
            
            Log::info('Positions updated successfully');
            return response()->json(['success' => true, 'message' => 'Posisi foto berhasil diperbarui!']);
            
        } catch (\Exception $e) {
            Log::error('Update position error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Bulk delete photos (AJAX)
     */
    public function bulkDestroy(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada foto yang dipilih'
                ], 400);
            }
            
            $deleteCount = 0;
            $processedGroups = [];
            
            // First, collect all photos to delete including groups
            $galeris = Galeri::whereIn('id_galeri', $ids)->get();
            $idsToDelete = [];
            
            foreach ($galeris as $galeri) {
                if ($galeri->grup_id && !in_array($galeri->grup_id, $processedGroups)) {
                    // Get all photos in the group
                    $groupPhotos = Galeri::where('grup_id', $galeri->grup_id)->get();
                    foreach ($groupPhotos as $photo) {
                        $idsToDelete[] = $photo->id_galeri;
                    }
                    $processedGroups[] = $galeri->grup_id;
                } else {
                    $idsToDelete[] = $galeri->id_galeri;
                }
            }
            
            // Now delete all collected photos
            $photosToDelete = Galeri::whereIn('id_galeri', $idsToDelete)->get();
            
            foreach ($photosToDelete as $galeri) {
                // Delete files
                $filePath = public_path('storage/' . $galeri->foto);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $appFilePath = storage_path('app/public/' . $galeri->foto);
                if (file_exists($appFilePath)) {
                    unlink($appFilePath);
                }
                
                $galeri->delete();
                $deleteCount++;
            }
            
            Log::info("Bulk deleted $deleteCount photos");
            
            $message = $deleteCount > 1 ? "$deleteCount foto berhasil dihapus!" : "Foto berhasil dihapus!";
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'deleted_count' => $deleteCount
            ]);
                
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
