<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GeoJSON\GeoJson;

class BatasWilayahController extends Controller
{
    /**
     * Get GeoJSON boundary data for village visualization
     */
    public function getGeoJSON()
    {
        try {
            $shpPath = storage_path('app/shapefile/BATAS_DESA_DESEMBER_2019_DUKCAPIL_BANTEN.shp');
            
            // Alternative path in resources
            if (!file_exists($shpPath)) {
                $shpPath = resource_path('views/BATAS_DESA_DESEMBER_2019_DUKCAPIL_BANTEN.shp');
            }
            
            if (!file_exists($shpPath)) {
                return response()->json([
                    'error' => 'Shapefile not found',
                    'paths_checked' => [
                        $shpPath,
                        resource_path('views/BATAS_DESA_DESEMBER_2019_DUKCAPIL_BANTEN.shp')
                    ]
                ], 404);
            }
            
            // Read shapefile using Python script
            $pythonScript = resource_path('views/BatasWilayah.py');
            $outputFile = storage_path('app/shapefile/wilayah_bulakan.geojson');
            
            // Ensure output directory exists
            if (!file_exists(storage_path('app/shapefile'))) {
                mkdir(storage_path('app/shapefile'), 0755, true);
            }
            
            // Run Python script to generate GeoJSON
            $command = sprintf(
                'python "%s" 2>&1',
                $pythonScript
            );
            
            $output = shell_exec($command);
            
            // Check if Python script generated the output
            if (file_exists($outputFile)) {
                $geojson = file_get_contents($outputFile);
                return response()->json(json_decode($geojson));
            }
            
            // Fallback: Try to read directly using ogr or return error
            return response()->json([
                'error' => 'Could not process shapefile',
                'python_output' => $output
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
}
    
/**
     * Get village boundary data as GeoJSON with proper processing
     * This version uses pre-generated GeoJSON for better performance
     */
    public function getVillageBoundaries()
    {
        try {
            // Check for cached GeoJSON first
            $geojsonPath = storage_path('app/shapefile/bulakan_boundaries.geojson');
            
            if (file_exists($geojsonPath)) {
                $geojson = file_get_contents($geojsonPath);
                return response()->json(json_decode($geojson));
            }
            
            // Read from pre-generated HTML file in resources/views
            $htmlGeoJSONPath = resource_path('views/peta_batas_wilayah_bulakan.html');
            
            if (!file_exists($htmlGeoJSONPath)) {
                return response()->json([
                    'error' => 'Boundary data file not found',
                    'path' => $htmlGeoJSONPath
                ], 404);
            }
            
            $htmlContent = file_get_contents($htmlGeoJSONPath);
            
            // Define village data to extract (id => [name, color, batas_direction, kecamatan])
            $villages = [
                'geo_json_839ea5eba30299f74736676182436a8c' => [
                    'name' => 'KARANGASEM', 
                    'color' => 'green', 
                    'direction' => 'Timur',
                    'kecamatan' => 'CIWANDAN',
                    'kab_kota' => 'KOTA CILEGON'
                ],
                'geo_json_cec97c609cce24353cf7d89ccc52be08' => [
                    'name' => 'KOSAMBIRONYOK', 
                    'color' => 'orange', 
                    'direction' => 'Selatan',
                    'kecamatan' => 'ANYAR',
                    'kab_kota' => 'SERANG'
                ],
                'geo_json_0ad582e32b76b47d0309eb49425dfa82' => [
                    'name' => 'ANYAR', 
                    'color' => 'purple', 
                    'direction' => 'Barat',
                    'kecamatan' => 'ANYAR',
                    'kab_kota' => 'SERANG'
                ],
                'geo_json_79b6f20bdc89596e008810ac6bbd0c0f' => [
                    'name' => 'GUNUNG SUGIH', 
                    'color' => 'red', 
                    'direction' => 'Pusat',
                    'kecamatan' => 'CIWANDAN',
                    'kab_kota' => 'KOTA CILEGON'
                ]
            ];
            
            $features = [];
            
            foreach ($villages as $geoJsonId => $villageInfo) {
                // Fixed pattern to match: geo_json_HASH_add({"features": [...]});
                // The actual format in the HTML file is: geo_json_HASH_add({"features": [{"geometry": {...}, "id": "0", "type": "Feature"}], "type": "FeatureCollection"});
                $pattern = '/' . preg_quote($geoJsonId, '/') . '_add\(\(\{"features":\s*\[.*?\]\}\)\);/s';
                
                if (preg_match($pattern, $htmlContent, $match)) {
                    $jsonStr = '{"features": ' . $match[1] . '}';
                    $data = json_decode($jsonStr, true);
                    
                    if ($data && isset($data['features'])) {
                        foreach ($data['features'] as $feature) {
                            $features[] = [
                                'type' => 'Feature',
                                'properties' => [
                                    'DESA' => $villageInfo['name'],
                                    'KECAMATAN' => $villageInfo['kecamatan'],
                                    'KAB_KOTA' => $villageInfo['kab_kota'],
                                    'BATAS' => $villageInfo['direction'],
                                    'COLOR' => $villageInfo['color']
                                ],
                                'geometry' => $feature['geometry']
                            ];
                        }
                    }
                }
            }
            
            // If no features found with first pattern, try alternative extraction
            if (empty($features)) {
                foreach ($villages as $geoJsonId => $villageInfo) {
                    // Try alternative pattern without escaping
                    $pattern = '/' . $geoJsonId . '_add\(\(' . '({"features":.*?})\)' . '\);/s';
                    
                    if (preg_match($pattern, $htmlContent, $match)) {
                        $jsonStr = '{"features": ' . $match[1] . '}';
                        $data = json_decode($jsonStr, true);
                        
                        if ($data && isset($data['features'])) {
                            foreach ($data['features'] as $feature) {
                                $features[] = [
                                    'type' => 'Feature',
                                    'properties' => [
                                        'DESA' => $villageInfo['name'],
                                        'KECAMATAN' => $villageInfo['kecamatan'],
                                        'KAB_KOTA' => $villageInfo['kab_kota'],
                                        'BATAS' => $villageInfo['direction'],
                                        'COLOR' => $villageInfo['color']
                                    ],
                                    'geometry' => $feature['geometry']
                                ];
                            }
                        }
                    }
                }
            }
            
            if (!empty($features)) {
                return response()->json([
                    'type' => 'FeatureCollection',
                    'features' => $features
                ]);
            }
            
            // Return error if no features found
            return response()->json([
                'error' => 'No boundary features found in source file',
                'features_found' => count($features)
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}

