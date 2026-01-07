<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestasi = Prestasi::latest()->get();
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
        ]);

        Prestasi::create($request->all());

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
        ]);

        $prestasi->update($request->all());

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
            $prestasi->delete();
        }

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus!');
    }
}
