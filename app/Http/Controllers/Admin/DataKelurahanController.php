<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKelurahanStatistik;
use Illuminate\Http\Request;

class DataKelurahanController extends Controller
{
    public function index(Request $request)
    {
        $subjects = config('data_kelurahan.subjects', []);
        $availableYears = $this->availableYears();
        $selectedYear = $this->resolveYear($request->query('year'), $availableYears);

        $values = DataKelurahanStatistik::query()
            ->where('year', $selectedYear)
            ->get()
            ->keyBy('dataset_key');

        return view('admin.data-kelurahan.index', compact('subjects', 'values', 'availableYears', 'selectedYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2100'],
            'values' => ['nullable', 'array'],
            'values.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $definitions = $this->flattenDatasets();
        $values = $validated['values'] ?? [];
        $year = (int) $validated['year'];

        foreach ($definitions as $key => $definition) {
            $rawValue = $values[$key] ?? null;
            $value = $rawValue === '' || $rawValue === null ? null : $rawValue;

            DataKelurahanStatistik::updateOrCreate(
                [
                    'village_id' => app()->bound('currentVillageId') ? app('currentVillageId') : null,
                    'dataset_key' => $key,
                    'year' => $year,
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
            ->route('admin.data-kelurahan.index', ['year' => $year])
            ->with('success', 'Data kelurahan tahun ' . $year . ' berhasil disimpan.');
    }

    public function update(Request $request, string $id)
    {
        $definitions = $this->flattenDatasets();
        abort_unless(array_key_exists($id, $definitions), 404);

        $validated = $request->validate([
            'year' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2100'],
            'value' => ['nullable', 'numeric', 'min:0'],
        ]);

        $definition = $definitions[$id];
        $year = (int) $validated['year'];

        DataKelurahanStatistik::updateOrCreate(
            [
                'village_id' => app()->bound('currentVillageId') ? app('currentVillageId') : null,
                'dataset_key' => $id,
                'year' => $year,
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
            'message' => 'Data kelurahan tahun ' . $year . ' berhasil diperbarui.',
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2100'],
        ]);

        DataKelurahanStatistik::where('dataset_key', $id)
            ->where('year', (int) $validated['year'])
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data kelurahan berhasil dikosongkan.',
        ]);
    }

    private function availableYears(): array
    {
        $years = DataKelurahanStatistik::query()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn ($year) => (int) $year)
            ->all();

        $currentYear = (int) date('Y');

        if (!in_array($currentYear, $years, true)) {
            array_unshift($years, $currentYear);
        }

        return array_values(array_unique($years));
    }

    private function resolveYear($requestedYear, array $availableYears): int
    {
        if (is_numeric($requestedYear)) {
            $year = (int) $requestedYear;

            if ($year >= 2000 && $year <= 2100) {
                return $year;
            }
        }

        return $availableYears[0] ?? (int) date('Y');
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