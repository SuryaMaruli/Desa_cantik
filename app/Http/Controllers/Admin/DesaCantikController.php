<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TentangDesa;
use App\Models\MetadataStatistik;
use App\Models\OutputProgram;

class DesaCantikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tentang = TentangDesa::first();
        $metadata = MetadataStatistik::all();
        $outputPrograms = OutputProgram::all();
        
        return view('admin.desa-cantik.index', compact('tentang', 'metadata', 'outputPrograms'));
    }

    /**
     * Update Tentang Desa
     */
    public function updateTentang(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        $tentang = TentangDesa::first();
        if ($tentang) {
            $tentang->update(['deskripsi' => $request->deskripsi]);
        } else {
            TentangDesa::create(['deskripsi' => $request->deskripsi]);
        }

        return redirect()->back()->with('success', 'Tentang Program Desa Cantik berhasil diperbarui!');
    }

    /**
     * Update Metadata Statistik
     */
    public function updateMetadata(Request $request, $id)
    {
        $request->validate([
            'nama_metadata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|string|max:255',
        ]);

        $metadata = MetadataStatistik::findOrFail($id);
        $metadata->update($request->all());

        return redirect()->back()->with('success', 'Metadata Statistik berhasil diperbarui!');
    }

    /**
     * Update Output Program
     */
    public function updateOutput(Request $request, $id)
    {
        $request->validate([
            'judul_program' => 'required|string|max:255',
            'deskripsi_program' => 'required|string',
        ]);

        $output = OutputProgram::findOrFail($id);
        $output->update($request->all());

        return redirect()->back()->with('success', 'Output Program berhasil diperbarui!');
    }

    /**
     * Store new Output Program
     */
    public function storeOutput(Request $request)
    {
        $request->validate([
            'judul_program' => 'required|string|max:255',
            'deskripsi_program' => 'required|string',
        ]);

        OutputProgram::create($request->all());

        return redirect()->back()->with('success', 'Output Program baru berhasil ditambahkan!');
    }

    /**
     * Store new Metadata
     */
    public function storeMetadata(Request $request)
    {
        $request->validate([
            'nama_metadata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|string|max:255',
        ]);

        MetadataStatistik::create($request->all());

        return redirect()->back()->with('success', 'Metadata baru berhasil ditambahkan!');
    }

    /**
     * Delete Metadata
     */
    public function deleteMetadata($id)
    {
        $metadata = MetadataStatistik::findOrFail($id);
        $metadata->delete();

        return redirect()->back()->with('success', 'Metadata Statistik berhasil dihapus!');
    }

    /**
     * Delete Output Program
     */
    public function deleteOutput($id)
    {
        $output = OutputProgram::findOrFail($id);
        $output->delete();

        return redirect()->back()->with('success', 'Output Program berhasil dihapus!');
    }
}
