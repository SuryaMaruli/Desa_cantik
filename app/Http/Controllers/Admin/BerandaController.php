<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beranda;
use Illuminate\Support\Facades\Storage;

class BerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beranda = Beranda::first();
        return view('admin.beranda.index', compact('beranda'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gambar_header' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except(['gambar_header', 'logo']);

        // Handle gambar header upload
        if ($request->hasFile('gambar_header')) {
            $gambarHeader = $request->file('gambar_header');
            $gambarHeaderPath = $gambarHeader->store('beranda', 'public');
            $data['gambar_header'] = $gambarHeaderPath;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('beranda', 'public');
            $data['logo'] = $logoPath;
        }

        Beranda::create($data);

        return redirect()->route('admin.beranda.index')
            ->with('success', 'Data beranda berhasil disimpan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gambar_header' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $beranda = Beranda::findOrFail($id);
        $data = $request->except(['gambar_header', 'logo']);

        // Handle gambar header removal
        if ($request->has('remove_gambar_header') && $beranda->gambar_header) {
            Storage::disk('public')->delete($beranda->gambar_header);
            $data['gambar_header'] = null;
        }

        // Handle logo removal
        if ($request->has('remove_logo') && $beranda->logo) {
            Storage::disk('public')->delete($beranda->logo);
            $data['logo'] = null;
        }

        // Handle gambar header upload
        if ($request->hasFile('gambar_header')) {
            // Delete old image
            if ($beranda->gambar_header) {
                Storage::disk('public')->delete($beranda->gambar_header);
            }
            
            $gambarHeader = $request->file('gambar_header');
            $gambarHeaderPath = $gambarHeader->store('beranda', 'public');
            $data['gambar_header'] = $gambarHeaderPath;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old image
            if ($beranda->logo) {
                Storage::disk('public')->delete($beranda->logo);
            }
            
            $logo = $request->file('logo');
            $logoPath = $logo->store('beranda', 'public');
            $data['logo'] = $logoPath;
        }

        $beranda->update($data);

        return redirect()->route('admin.beranda.index')
            ->with('success', 'Data beranda berhasil diperbarui!');
    }
}
