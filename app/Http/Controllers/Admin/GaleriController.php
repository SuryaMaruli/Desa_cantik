<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GaleriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $galeri = Galeri::latest()->get();
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        // Simple debug
        Log::info('=== GALERI STORE START ===');
        Log::info('Method: ' . $request->method());
        Log::info('URL: ' . $request->fullUrl());
        Log::info('Headers:', $request->headers->all());
        Log::info('Request data:', $request->all());
        
        // Check if this is actually a POST request
        if (!$request->isMethod('post')) {
            Log::error('Not a POST request');
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        try {
            // Simple validation first
            $request->validate([
                'judul_foto' => 'required|string|max:255',
                'kategori' => 'required|string',
                'tanggal_kegiatan' => 'required|date',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            Log::info('Basic validation passed');

            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                // Check if file is valid
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('galeri', $filename, 'public');
                    
                    Log::info('File uploaded successfully: ' . $path);
                    
                    // Create galeri record
                    $galeri = Galeri::create([
                        'judul_foto' => $request->judul_foto,
                        'deskripsi' => $request->deskripsi ?? '',
                        'kategori' => $request->kategori,
                        'tanggal_kegiatan' => $request->tanggal_kegiatan,
                        'foto' => $path,
                    ]);

                    Log::info('Galeri created successfully: ' . $galeri->id_galeri);

                    return redirect()->route('admin.galeri.index')
                        ->with('success', 'Foto berhasil ditambahkan!');
                } else {
                    Log::error('File is not valid');
                    return redirect()->back()
                        ->with('error', 'File yang diupload tidak valid')
                        ->withInput();
                }
            } else {
                Log::error('No file uploaded');
                return redirect()->back()
                    ->with('error', 'Tidak ada file yang diupload')
                    ->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
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
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            Log::info('Update validation passed');

            $data = [
                'judul_foto' => $request->judul_foto,
                'deskripsi' => $request->deskripsi ?? '',
                'kategori' => $request->kategori,
                'tanggal_kegiatan' => $request->tanggal_kegiatan,
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('galeri', $filename, 'public');
                    
                    Log::info('New file uploaded: ' . $path);
                    $data['foto'] = $path;
                    
                    // Copy to public storage for immediate access
                    $sourcePath = storage_path('app/public/' . $path);
                    $destPath = public_path('storage/' . $path);
                    $destDir = dirname($destPath);
                    
                    if (!is_dir($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    copy($sourcePath, $destPath);
                } else {
                    Log::error('Uploaded file is not valid');
                    return redirect()->back()
                        ->with('error', 'File yang diupload tidak valid')
                        ->withInput();
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

            return redirect()->route('admin.galeri.index')
                ->with('success', 'Foto berhasil dihapus!');
                
        } catch (\Exception $e) {
            Log::error('Delete error: ' . $e->getMessage());
            return redirect()->route('admin.galeri.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
