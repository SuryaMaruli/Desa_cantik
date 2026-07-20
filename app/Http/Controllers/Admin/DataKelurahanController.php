<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKelurahanStatistik;
use Illuminate\Http\Request;

class DataKelurahanController extends Controller
{
    public function index()
    {
        $subjects = config('data_kelurahan.subjects', []);
        $values = DataKelurahanStatistik::query()
            ->get()
            ->keyBy('dataset_key');

        return view('admin.data-kelurahan.index', compact('subjects', 'values'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'values' => ['nullable', 'array'],
            'values.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $definitions = $this->flattenDatasets();
        $values = $validated['values'] ?? [];

        foreach ($definitions as $key => $definition) {
            $rawValue = $values[$key] ?? null;
            $value = $rawValue === '' || $rawValue === null ? null : $rawValue;

            DataKelurahanStatistik::updateOrCreate(
                [
                    'village_id' => app()->bound('currentVillageId') ? app('currentVillageId') : null,
                    'dataset_key' => $key,
                ],
                [
                    'subject_key' => $definition['subject_key'],
                    'parent_key' => $definition['parent_key'],
                    'label' => $definition['name'],
                    'value' => $value,
                ]
            );
        }

        return redirect()
            ->route('admin.data-kelurahan.index')
            ->with('success', 'Data kelurahan berhasil disimpan.');
    }

    public function update(Request $request, string $id)
    {
        $definitions = $this->flattenDatasets();
        abort_unless(array_key_exists($id, $definitions), 404);

        $validated = $request->validate([
            'value' => ['nullable', 'numeric', 'min:0'],
        ]);

        $definition = $definitions[$id];

        DataKelurahanStatistik::updateOrCreate(
            [
                'village_id' => app()->bound('currentVillageId') ? app('currentVillageId') : null,
                'dataset_key' => $id,
            ],
            [
                'subject_key' => $definition['subject_key'],
                'parent_key' => $definition['parent_key'],
                'label' => $definition['name'],
                'value' => $validated['value'] ?? null,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Data kelurahan berhasil diperbarui.',
        ]);
    }

    public function destroy(string $id)
    {
        DataKelurahanStatistik::where('dataset_key', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data kelurahan berhasil dikosongkan.',
        ]);
    }

    private function flattenDatasets(): array
    {
        $datasets = [];

        foreach (config('data_kelurahan.subjects', []) as $subject) {
            foreach ($subject['datasets'] ?? [] as $dataset) {
                $datasets[$dataset['key']] = [
                    'subject_key' => $subject['key'],
                    'parent_key' => null,
                    'name' => $dataset['name'],
                ];

                foreach ($dataset['children'] ?? [] as $child) {
                    $datasets[$child['key']] = [
                        'subject_key' => $subject['key'],
                        'parent_key' => $dataset['key'],
                        'name' => $child['name'],
                    ];
                }
            }
        }

        return $datasets;
    }
}
