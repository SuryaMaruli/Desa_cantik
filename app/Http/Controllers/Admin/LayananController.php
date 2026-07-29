<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\VillageSetting;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::orderBy('kategori')->orderBy('nama_layanan')->get();
        $layananKependudukan = $layanans->where('kategori', 'kependudukan');
        $layananData = $layanans->where('kategori', 'data');
        
        $serviceInfo = $this->serviceInfo();

        return view('admin.layanan.index', compact('layananKependudukan', 'layananData', 'serviceInfo'));
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


    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'service_info' => ['required', 'array'],
            'service_info.office_location' => ['nullable', 'string', 'max:1000'],
            'service_info.service_hours' => ['nullable', 'string', 'max:1000'],
            'service_info.contact' => ['nullable', 'string', 'max:1000'],
        ]);

        $settings = $validated['service_info'];
        $villageId = app()->bound('currentVillageId') ? app('currentVillageId') : null;

        foreach ($this->serviceInfoDefaults() as $key => $defaultValue) {
            VillageSetting::updateOrCreate(
                [
                    'village_id' => $villageId,
                    'key' => 'service_info.' . $key,
                ],
                [
                    'value' => $settings[$key] ?? '',
                ]
            );
        }

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Informasi pelayanan berhasil diperbarui!');
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
    private function serviceInfo(): array
    {
        $settings = VillageSetting::query()
            ->whereIn('key', array_map(fn ($key) => 'service_info.' . $key, array_keys($this->serviceInfoDefaults())))
            ->pluck('value', 'key');

        $serviceInfo = [];

        foreach ($this->serviceInfoDefaults() as $key => $defaultValue) {
            $serviceInfo[$key] = $settings->get('service_info.' . $key, $defaultValue);
        }

        return $serviceInfo;
    }

    private function serviceInfoDefaults(): array
    {
        $currentVillage = app()->bound('currentVillage') ? app('currentVillage') : [];
        $officialName = $currentVillage['official_name'] ?? 'Kantor Kelurahan Gunung Sugih';
        $address = $currentVillage['address'] ?? 'Jl. Raya Gunung Sugih No. 123';
        $city = $currentVillage['city'] ?? 'Kota Cilegon';
        $province = $currentVillage['province'] ?? 'Banten';
        $postalCode = $currentVillage['postal_code'] ?? '42447';
        $phone = $currentVillage['phone'] ?? '(0254) 123-4567';
        $email = $currentVillage['email'] ?? 'kelurahan@gunungsugih.go.id';

        return [
            'office_location' => $officialName . "\n" . $address . "\n" . $city . ', ' . $province . ' ' . $postalCode,
            'service_hours' => "Senin - Jumat\n08.00 - 15.00 WIB\nTutup pada hari libur nasional",
            'contact' => 'Telepon: ' . $phone . "\nEmail: " . $email,
        ];
    }
}
