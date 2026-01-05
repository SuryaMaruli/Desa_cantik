<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'excerpt' => 'nullable|string',
                'konten' => 'required|string',
                'kategori' => 'required|string',
                'penulis' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'tanggal_publikasi' => 'required|date',
            ]);

            $data = $request->all();
            
            // Handle gambar upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                
                // Create directory if not exists
                $uploadPath = public_path('storage/berita');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['gambar'] = $filename;
            }

            // Handle is_published checkbox - convert to boolean
            $data['is_published'] = ($request->input('is_published') == '1');

            $berita = Berita::create($data);

            // Check if request wants JSON response (for AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil ditambahkan!',
                    'data' => $berita
                ]);
            }

            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil ditambahkan!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan berita: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan berita: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Get edit data for AJAX request
     */
    public function getEditData(Berita $berita)
    {
        try {
            return response()->json([
                'success' => true,
                'berita' => $berita
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data berita: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'excerpt' => 'nullable|string',
                'konten' => 'required|string',
                'kategori' => 'required|string',
                'penulis' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'tanggal_publikasi' => 'required|date',
            ]);

            // Find the berita manually
            $berita = Berita::find($id);
            
            if (!$berita) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Berita tidak ditemukan'
                    ], 404);
                }
                
                return redirect()->route('admin.berita.index')
                    ->with('error', 'Berita tidak ditemukan');
            }

            $data = $request->all();
            
            // Handle gambar upload
            if ($request->hasFile('gambar')) {
                // Delete old gambar if exists
                if ($berita->gambar && file_exists(public_path('storage/berita/' . $berita->gambar))) {
                    unlink(public_path('storage/berita/' . $berita->gambar));
                }
                
                $file = $request->file('gambar');
                
                // Create directory if not exists
                $uploadPath = public_path('storage/berita');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['gambar'] = $filename;
            }

            // Handle is_published checkbox - convert to boolean
            $data['is_published'] = ($request->input('is_published') == '1');

            $berita->update($data);

            // Check if request wants JSON response (for AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil diperbarui!'
                ]);
            }

            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil diperbarui!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui berita: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find the berita manually
            $berita = Berita::find($id);
            
            if (!$berita) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Berita tidak ditemukan'
                    ], 404);
                }
                
                return redirect()->route('admin.berita.index')
                    ->with('error', 'Berita tidak ditemukan');
            }
            
            // Delete gambar if exists
            if ($berita->gambar && file_exists(public_path('storage/berita/' . $berita->gambar))) {
                unlink(public_path('storage/berita/' . $berita->gambar));
            }

            $deleted = $berita->delete();

            if (!$deleted) {
                throw new \Exception('Failed to delete berita from database');
            }

            // Check if request wants JSON response (for AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil dihapus!');
                
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus berita: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.berita.index')
                ->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(Berita $berita)
    {
        $berita->is_published = !$berita->is_published;
        $berita->save();

        $status = $berita->is_published ? 'dipublikasikan' : 'disimpan sebagai draft';
        
        return redirect()->route('admin.berita.index')
            ->with('success', "Berita berhasil {$status}!");
    }
}
