<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\PrestasiFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = Prestasi::with('fotos')->latest()->get();
        return view('admin.prestasi.index', compact('prestasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prestasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'peringkat' => 'required|string|max:100',
            'tingkat' => 'required|string|max:100',
            'penyelenggara' => 'nullable|string|max:255',
            'tahun' => 'required|string|max:4',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $prestasi = Prestasi::create($request->only([
            'judul',
            'peringkat',
            'tingkat',
            'penyelenggara',
            'tahun',
            'deskripsi',
            'tanggal',
        ]));

        $this->storeUploadedPhotos($prestasi, $request->file('fotos', []));

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestasi $prestasi)
    {
        return view('admin.prestasi.edit', compact('prestasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $prestasi = Prestasi::find($id);
        
        if (!$prestasi) {
            return redirect()->route('admin.prestasi.index')
                ->with('error', 'Prestasi tidak ditemukan!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'peringkat' => 'required|string|max:100',
            'tingkat' => 'required|string|max:100',
            'penyelenggara' => 'nullable|string|max:255',
            'tahun' => 'required|string|max:4',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'existing_photo_order' => 'nullable|string',
            'new_fotos' => 'nullable|array',
            'new_fotos.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $prestasi->update($request->only([
            'judul',
            'peringkat',
            'tingkat',
            'penyelenggara',
            'tahun',
            'deskripsi',
            'tanggal',
        ]));

        $nextPosition = $this->updateExistingPhotoOrder($prestasi, $request->input('existing_photo_order'));
        $this->storeUploadedPhotos($prestasi, $request->file('new_fotos', []), $nextPosition);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prestasi = Prestasi::find($id);
        
        if ($prestasi) {
            $prestasi->load('fotos');
            foreach ($prestasi->fotos as $foto) {
                Storage::disk('public')->delete($foto->foto);
            }
            $prestasi->delete();
        }

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus!');
    }

    private function storeUploadedPhotos(Prestasi $prestasi, array $photos, int $startPosition = 1): void
    {
        foreach ($photos as $index => $photo) {
            if (!$photo || !$photo->isValid()) {
                continue;
            }

            $filename = time() . '_' . ($startPosition + $index) . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('prestasi', $filename, 'public');

            PrestasiFoto::create([
                'prestasi_id' => $prestasi->id,
                'foto' => $path,
                'position' => $startPosition + $index,
            ]);
        }
    }

    private function updateExistingPhotoOrder(Prestasi $prestasi, ?string $orderJson): int
    {
        $ids = json_decode($orderJson ?: '[]', true);

        if (!is_array($ids) || empty($ids)) {
            return ((int) $prestasi->fotos()->max('position')) + 1;
        }

        $position = 1;
        foreach ($ids as $id) {
            $prestasi->fotos()
                ->where('id', $id)
                ->update(['position' => $position]);
            $position++;
        }

        return $position;
    }
}
