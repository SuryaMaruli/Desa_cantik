<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaFoto;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword', '');
        
        $query = Berita::with(['fotoUtama']);
        
        if (!empty($keyword)) {
            // Search in judul (title) and konten (content) fields
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('konten', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        $beritas = $query->latest()->paginate(10)->appends($request->query());
        
        return view('admin.berita.index', compact('beritas', 'keyword'));
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
                'tanggal_publikasi' => 'required|date',
                'fotos' => 'required|array|min:1',
                'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'foto_utama_index' => 'required|integer|min:0',
            ]);

            $data = $request->only([
                'judul',
                'excerpt',
                'konten',
                'kategori',
                'penulis',
                'tanggal_publikasi',
            ]);

            $data['is_published'] = ($request->input('is_published') == '1');

            $berita = Berita::create($data);

            $files = $request->file('fotos', []);
            $fotoUtamaIndex = (int) $request->input('foto_utama_index', 0);

            if (!isset($files[$fotoUtamaIndex])) {
                throw new \Exception('Foto utama wajib dipilih.');
            }

            $fotoUtamaFilename = null;

            foreach ($files as $index => $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berita', $filename, 'public');

                $isUtama = ((int) $index === $fotoUtamaIndex);

                BeritaFoto::create([
                    'berita_id' => $berita->id,
                    'foto' => $filename,
                    'urutan' => $index,
                    'is_utama' => $isUtama,
                ]);

                if ($isUtama) {
                    $fotoUtamaFilename = $filename;
                }
            }

            if ($fotoUtamaFilename) {
                $berita->update(['gambar' => $fotoUtamaFilename]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil ditambahkan!',
                    'data' => $berita->load('fotos')
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
                'berita' => $berita->load(['fotos'])
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
                'tanggal_publikasi' => 'required|date',
                'fotos' => 'nullable|array',
                'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'foto_utama_id' => 'nullable|integer',
                'delete_foto_ids' => 'nullable|array',
                'delete_foto_ids.*' => 'integer',
            ]);

            $berita = Berita::with('fotos')->find($id);

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

            $data = $request->only([
                'judul',
                'excerpt',
                'konten',
                'kategori',
                'penulis',
                'tanggal_publikasi',
            ]);

            $data['is_published'] = ($request->input('is_published') == '1');

            $berita->update($data);

            $deleteIds = $request->input('delete_foto_ids', []);
            if (!empty($deleteIds)) {
                $fotosToDelete = $berita->fotos()->whereIn('id', $deleteIds)->get();
                foreach ($fotosToDelete as $foto) {
                    Storage::disk('public')->delete('berita/' . $foto->foto);
                    $foto->delete();
                }
            }

            $newFiles = $request->file('fotos', []);
            $lastUrutan = (int) ($berita->fotos()->max('urutan') ?? -1);
            foreach ($newFiles as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('berita', $filename, 'public');

                $lastUrutan++;
                BeritaFoto::create([
                    'berita_id' => $berita->id,
                    'foto' => $filename,
                    'urutan' => $lastUrutan,
                    'is_utama' => false,
                ]);
            }

            $orderPayload = $request->input('foto_orders');
            if ($orderPayload) {
                $decoded = is_array($orderPayload) ? $orderPayload : json_decode($orderPayload, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $idx => $fotoId) {
                        $berita->fotos()->where('id', (int) $fotoId)->update(['urutan' => $idx]);
                    }
                }
            }

            $berita->fotos()->update(['is_utama' => false]);
            $fotoUtamaId = $request->input('foto_utama_id');

            if ($fotoUtamaId) {
                $utama = $berita->fotos()->where('id', $fotoUtamaId)->first();
                if ($utama) {
                    $utama->is_utama = true;
                    $utama->save();
                    $berita->gambar = $utama->foto;
                }
            } else {
                $firstFoto = $berita->fotos()->orderBy('urutan')->first();
                if ($firstFoto) {
                    $firstFoto->is_utama = true;
                    $firstFoto->save();
                    $berita->gambar = $firstFoto->foto;
                } else {
                    $berita->gambar = null;
                }
            }

            if (!$berita->fotos()->exists()) {
                throw new \Exception('Minimal harus ada 1 foto utama.');
            }

            $berita->save();

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
            $berita = Berita::with('fotos')->find($id);

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

            foreach ($berita->fotos as $foto) {
                Storage::disk('public')->delete('berita/' . $foto->foto);
            }
            if ($berita->gambar) {
                Storage::disk('public')->delete('berita/' . $berita->gambar);
            }

            $deleted = $berita->delete();

            if (!$deleted) {
                throw new \Exception('Failed to delete berita from database');
            }

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
public function togglePublish(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            $berita->is_published = !$berita->is_published;
            $berita->save();

            $status = $berita->is_published ? 'dipublikasikan' : 'disimpan sebagai draft';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Berita berhasil {$status}!",
                    'is_published' => $berita->is_published
                ]);
            }

            return redirect()->route('admin.berita.index')
                ->with('success', "Berita berhasil {$status}!");
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.berita.index')
                ->with('error', 'Gagal mengubah status!');
        }
    }

    /**
     * Set or unset berita utama
     */
    public function setUtama(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            // Toggle: if currently utama, unset it; otherwise set it as utama
            $newStatus = !$berita->is_utama;
            
            // If setting as utama, first unset all others
            if ($newStatus) {
                Berita::where('is_utama', true)->update(['is_utama' => false]);
            }
            
            $berita->is_utama = $newStatus;
            $berita->save();

            $status = $berita->is_utama ? 'dijadikan berita utama' : 'dibatalkan dari berita utama';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Berita berhasil {$status}!",
                    'is_utama' => $berita->is_utama
                ]);
            }

            return redirect()->route('admin.berita.index')
                ->with('success', "Berita berhasil {$status}!");
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status utama: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.berita.index')
                ->with('error', 'Gagal mengubah status utama!');
        }
    }

    /**
     * AJAX search for berita
     */
    public function search(Request $request)
    {
        $keyword = $request->query('keyword', '');
        
        $query = Berita::with(['fotoUtama']);
        
        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('konten', 'LIKE', '%' . $keyword . '%');
            });
        }
        
        $beritas = $query->latest()->paginate(10);
        
        return response()->json([
            'success' => true,
            'beritas' => $beritas->items(),
            'current_page' => $beritas->currentPage(),
            'last_page' => $beritas->lastPage(),
            'total' => $beritas->total(),
            'keyword' => $keyword
        ]);
    }
}
