<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/test-pdf', function() {
    return response()->json(['message' => 'PDF API working']);
});

Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    
    $fileInfo = pathinfo($fullPath);
    $extension = strtolower($fileInfo['extension'] ?? '');
    
    if ($extension === 'pdf') {
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"'
        ]);
    }
    
    return response()->file($fullPath);
})->where('path', '.*');
