<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AgendaKegiatan;
use App\Models\InformasiPublik;

class InformasiPublikController extends Controller
{
    public function index()
    {
        $informasiPubliks = InformasiPublik::latest()->get();
        $agendaKegiatans = AgendaKegiatan::orderBy('tanggal_kegiatan', 'desc')->get();
        return view('admin.informasi-publik.index', compact('informasiPubliks', 'agendaKegiatans'));
    }

    public function create()
    {
        return view('admin.informasi-publik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sub_deskripsi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        InformasiPublik::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Informasi publik berhasil ditambahkan!',
            ]);
        }

        return redirect()->route('admin.informasi-publik.index')->with('success', 'Informasi publik berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasiPublik = InformasiPublik::findOrFail($id);
        return view('admin.informasi-publik.edit', compact('informasiPublik'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sub_deskripsi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $informasiPublik = InformasiPublik::findOrFail($id);
        $informasiPublik->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Informasi publik berhasil diperbarui!',
            ]);
        }
        
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Informasi publik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $informasiPublik = InformasiPublik::findOrFail($id);
        $informasiPublik->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Informasi publik berhasil dihapus!',
            ]);
        }
        
        return redirect()->route('admin.informasi-publik.index')->with('success', 'Informasi publik berhasil dihapus!');
    }

    public function storeAgenda(Request $request)
    {
        abort_unless(in_array($request->user()->role, ['admin', 'super_admin']), 403);

        if ($request->filled('jam_mulai') && $request->filled('jam_selesai')) {
            $request->merge([
                'jam_kegiatan' => $request->input('jam_mulai') . ' - ' . $request->input('jam_selesai') . ' WIB',
            ]);
        }

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'tempat_kegiatan' => 'required|string|max:255',
            'jam_kegiatan' => 'required|string|max:100',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'surat_pendukung' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        unset($validated['jam_mulai'], $validated['jam_selesai']);

        if ($request->hasFile('surat_pendukung')) {
            $file = $request->file('surat_pendukung');
            $filename = time() . '_surat_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
            $validated['surat_pendukung'] = $file->storeAs('surat-pendukung-kegiatan', $filename, 'public');
        }

        AgendaKegiatan::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal kegiatan berhasil ditambahkan!',
            ]);
        }

        if ($request->input('redirect_to') === 'public_agenda') {
            return redirect()
                ->route('informasi-publik.detail', 4)
                ->with('success', 'Jadwal kegiatan berhasil ditambahkan!');
        }

        return redirect()
            ->route('admin.informasi-publik.index')
            ->with('success', 'Jadwal kegiatan berhasil ditambahkan!');
    }

    public function destroyAgenda($id)
    {
        abort_unless(in_array(request()->user()->role, ['admin', 'super_admin']), 403);

        $agenda = AgendaKegiatan::findOrFail($id);

        if ($agenda->surat_pendukung && Storage::disk('public')->exists($agenda->surat_pendukung)) {
            Storage::disk('public')->delete($agenda->surat_pendukung);
        }

        $agenda->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal kegiatan berhasil dihapus!',
            ]);
        }

        if (request()->input('redirect_to') === 'public_agenda') {
            return redirect()
                ->route('informasi-publik.detail', 4)
                ->with('success', 'Jadwal kegiatan berhasil dihapus!');
        }

        return redirect()
            ->route('admin.informasi-publik.index')
            ->with('success', 'Jadwal kegiatan berhasil dihapus!');
    }

    public function updateAgenda(Request $request, $id)
    {
        abort_unless(in_array($request->user()->role, ['admin', 'super_admin']), 403);

        if ($request->filled('jam_mulai') && $request->filled('jam_selesai')) {
            $request->merge([
                'jam_kegiatan' => $request->input('jam_mulai') . ' - ' . $request->input('jam_selesai') . ' WIB',
            ]);
        }

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'tempat_kegiatan' => 'required|string|max:255',
            'jam_kegiatan' => 'required|string|max:100',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'surat_pendukung' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        unset($validated['jam_mulai'], $validated['jam_selesai']);

        $agenda = AgendaKegiatan::findOrFail($id);

        if ($request->hasFile('surat_pendukung')) {
            if ($agenda->surat_pendukung && Storage::disk('public')->exists($agenda->surat_pendukung)) {
                Storage::disk('public')->delete($agenda->surat_pendukung);
            }

            $file = $request->file('surat_pendukung');
            $filename = time() . '_surat_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
            $validated['surat_pendukung'] = $file->storeAs('surat-pendukung-kegiatan', $filename, 'public');
        }

        $agenda->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal kegiatan berhasil diperbarui!',
            ]);
        }

        if ($request->input('redirect_to') === 'public_agenda') {
            return redirect()
                ->route('informasi-publik.detail', 4)
                ->with('success', 'Jadwal kegiatan berhasil diperbarui!');
        }

        return redirect()
            ->route('admin.informasi-publik.index')
            ->with('success', 'Jadwal kegiatan berhasil diperbarui!');
    }
}
