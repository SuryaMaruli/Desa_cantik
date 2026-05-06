<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TentangDesa;
use App\Models\MetadataStatistik;
use App\Models\OutputProgram;
use Illuminate\Support\Facades\Storage; // WAJIB ADA

class DesaCantikController extends Controller
{
    public function index()
    {
        $tentang = TentangDesa::first();
        $metadata = MetadataStatistik::all();
        $outputPrograms = OutputProgram::all();
        
        return view('admin.desa-cantik.index', compact('tentang', 'metadata', 'outputPrograms'));
    }

    // Update Tentang (Deskripsi)
    public function updateTentang(Request $request)
    {
        $request->validate(['deskripsi' => 'required|string']);

        $tentang = TentangDesa::first();
        if ($tentang) {
            $tentang->update(['deskripsi' => $request->deskripsi]);
        } else {
            TentangDesa::create(['deskripsi' => $request->deskripsi]);
        }

        return redirect()->back()->with('success', 'Deskripsi berhasil diperbarui!');
    }

    // --- METADATA STATISTIK ---

    public function storeMetadata(Request $request)
    {
        $request->validate([
            'nama_metadata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'link' => 'nullable|url|max:255',
        ]);

        $data = $request->except('file_pdf');

        // Upload PDF jika ada
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke folder khusus pdf_metadata
            $file->storeAs('pdf_metadata', $filename, 'public');
            $data['file_pdf'] = 'pdf_metadata/' . $filename;
        }

        MetadataStatistik::create($data);
        return redirect()->back()->with('success', 'Metadata berhasil ditambahkan!');
    }

    public function updateMetadata(Request $request, $id)
    {
        $request->validate([
            'nama_metadata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'link' => 'nullable|url|max:255',
        ]);

        $metadata = MetadataStatistik::findOrFail($id);
        $data = $request->except('file_pdf');

        // Handle upload PDF baru
        if ($request->hasFile('file_pdf')) {
            // Hapus PDF lama jika ada
            if ($metadata->file_pdf && Storage::exists('public/' . $metadata->file_pdf)) {
                Storage::delete('public/' . $metadata->file_pdf);
            }

            // Upload PDF baru
            $file = $request->file('file_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke folder khusus pdf_metadata
            $file->storeAs('pdf_metadata', $filename, 'public');
            $data['file_pdf'] = 'pdf_metadata/' . $filename;
        }

        $metadata->update($data);
        return redirect()->back()->with('success', 'Metadata berhasil diperbarui!');
    }

    public function deleteMetadata($id)
    {
        $metadata = MetadataStatistik::findOrFail($id);
        
        // Hapus file PDF jika ada
        if ($metadata->file_pdf && Storage::exists('public/' . $metadata->file_pdf)) {
            Storage::delete('public/' . $metadata->file_pdf);
        }
        
        $metadata->delete();
        return redirect()->back()->with('success', 'Metadata berhasil dihapus!');
    }

    // --- OUTPUT PROGRAM ---

    public function storeOutput(Request $request)
    {
        $request->validate([
            'judul_program' => 'required|string|max:255',
            'deskripsi_program' => 'required|string',
            'informasi_tambahan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar');

        // Upload Gambar Baru
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke folder public agar bisa diakses via web
            $file->storeAs('output', $filename,'public');
            $data['gambar'] = 'output/' . $filename;
        }

        OutputProgram::create($data);
        return redirect()->back()->with('success', 'Output Program berhasil ditambahkan!');
    }

    public function updateOutput(Request $request, $id)
    {
        $request->validate([
            'judul_program' => 'required|string|max:255',
            'deskripsi_program' => 'required|string',
            'informasi_tambahan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $output = OutputProgram::findOrFail($id);
        $data = $request->except('gambar');

        // Handle Ganti Gambar
        if ($request->hasFile('gambar')) {
            // 1. Hapus gambar lama jika ada
            if ($output->gambar && Storage::exists($output->gambar)) {
                Storage::disk('public')->delete($output->gambar);
            }

            // 2. Upload gambar baru
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('output', $filename, 'public');
            $data['gambar'] = 'output/' . $filename;
        }

        $output->update($data);
        return redirect()->back()->with('success', 'Output Program berhasil diperbarui!');
    }

    public function deleteOutput($id)
    {
        $output = OutputProgram::findOrFail($id);
        
        // Hapus file fisik gambar
        if ($output->gambar && Storage::disk('public')->exists($output->gambar)) {
            Storage::disk('public')->delete($output->gambar);
        }

        $output->delete();
        return redirect()->back()->with('success', 'Output Program berhasil dihapus!');
    }

    // --- PUBLIC PAGES ---
    public function showOutput($id)
    {
        $program = OutputProgram::findOrFail($id);
        return view('desa-cantik-detail', compact('program'));
    }
}