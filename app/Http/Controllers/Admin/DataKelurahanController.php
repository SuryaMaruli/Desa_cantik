<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;

class DataKelurahanController extends Controller
{
    /**
     * Display data kelurahan page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data penduduk dari database
        $pendudukData = Penduduk::orderBy('rw')->orderBy('nama')->get();
        
        // Hitung statistik
        $totalPenduduk = $pendudukData->count();
        $lakiLaki = $pendudukData->where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = $pendudukData->where('jenis_kelamin', 'Perempuan')->count();
        
        // Hitung kepala keluarga (laki-laki yang sudah menikah)
        $kepalaKeluarga = $pendudukData->where('jenis_kelamin', 'Laki-laki')
            ->where('status', 'Menikah')
            ->count();
        
        // Hitung data per RW
        $rws = [];
        for ($i = 1; $i <= 10; $i++) {
            $rwNo = str_pad($i, 2, '0', STR_PAD_LEFT);
            $jumlahRw = $pendudukData->where('rw', $rwNo)->count();
            $rws[] = [
                'no' => $rwNo,
                'jumlah' => number_format($jumlahRw, 0, ',', '.'),
                'persentase' => $totalPenduduk > 0 ? round(($jumlahRw / $totalPenduduk) * 100) : 0
            ];
        }

        // Format data penduduk untuk view
        $pendudukFormatted = $pendudukData->map(function ($item, $index) {
            return [
                'id' => $item->id,  // Tambahkan ID database
                'no' => $index + 1,  // Nomor urut untuk tampilan
                'nama' => $item->nama,
                'jenis_kelamin' => $item->jenis_kelamin,
                'status' => $item->status,
                'rw' => $item->rw,
                'is_kepala_keluarga' => $item->jenis_kelamin === 'Laki-laki' && $item->status === 'Menikah'
            ];
        })->toArray();

        $data = [
            'total_penduduk' => number_format($totalPenduduk, 0, ',', '.'),
            'laki_laki' => number_format($lakiLaki, 0, ',', '.'),
            'perempuan' => number_format($perempuan, 0, ',', '.'),
            'kepala_keluarga' => number_format($kepalaKeluarga, 0, ',', '.'),
            'rws' => $rws,
            'penduduk' => $pendudukFormatted
        ];

        return view('admin.data-kelurahan.index', compact('data'));
    }

    /**
     * Store new penduduk data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:Menikah,Belum Menikah',
            'rw' => 'required|string|max:2'
        ]);

        try {
            // Simpan data ke database
            Penduduk::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Data penduduk berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update existing penduduk data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|in:Menikah,Belum Menikah',
            'rw' => 'required|string|max:2'
        ]);

        try {
            // Cari dan update data
            $penduduk = Penduduk::findOrFail($id);
            $penduduk->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Data penduduk berhasil diupdate!'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data penduduk tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete penduduk data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Cari dan hapus data
            $penduduk = Penduduk::findOrFail($id);
            $penduduk->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data penduduk berhasil dihapus!'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data penduduk tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
