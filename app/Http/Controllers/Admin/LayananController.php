<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::orderBy('kategori')->orderBy('nama_layanan')->get();
        $layananKependudukan = $layanans->where('kategori', 'kependudukan');
        $layananData = $layanans->where('kategori', 'data');
        
        return view('admin.layanan.index', compact('layananKependudukan', 'layananData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|in:kependudukan,data',
            'persyaratan' => 'required|array|min:1',
            'persyaratan.*' => 'required|string|max:255',
        ]);

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'kategori' => $request->kategori,
            // array_filter menghapus nilai kosong/null dari array
            'persyaratan' => array_values(array_filter($request->persyaratan)),
        ]);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::find($id);
        
        if (!$layanan) {
            return redirect()->route('admin.layanan.index')
                ->with('error', 'Layanan tidak ditemukan!');
        }

        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|in:kependudukan,data',
            'persyaratan' => 'required|array|min:1',
            'persyaratan.*' => 'required|string|max:255',
        ]);

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'kategori' => $request->kategori,
            'persyaratan' => array_values(array_filter($request->persyaratan)),
        ]);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $layanan = Layanan::find($id);

        if (!$layanan) {
            return redirect()->route('admin.layanan.index')
                ->with('error', 'Layanan tidak ditemukan!');
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}