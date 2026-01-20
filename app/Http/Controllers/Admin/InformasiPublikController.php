<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPublik;

class InformasiPublikController extends Controller
{
    public function index()
    {
        $informasiPubliks = InformasiPublik::latest()->get();
        return view('admin.informasi-publik.index', compact('informasiPubliks'));
    }

    public function create()
    {
        return view('admin.informasi-publik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'sub_deskripsi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        InformasiPublik::create($request->all());
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Informasi publik berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasiPublik = InformasiPublik::findOrFail($id);
        return view('admin.informasi-publik.edit', compact('informasiPublik'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'sub_deskripsi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $informasiPublik = InformasiPublik::findOrFail($id);
        $informasiPublik->update($request->all());
        
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Informasi publik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $informasiPublik = InformasiPublik::findOrFail($id);
        $informasiPublik->delete();
        
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Informasi publik berhasil dihapus!');
    }
}
