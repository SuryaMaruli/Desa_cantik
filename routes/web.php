<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Berita & Informasi
    Route::get('/berita', [\App\Http\Controllers\Admin\BeritaController::class, 'index'])->name('berita.index');
    
    // Data Kelurahan
    Route::get('/data-kelurahan', [\App\Http\Controllers\Admin\DataKelurahanController::class, 'index'])->name('data-kelurahan.index');
    
    // Add more admin routes here
    // Example:
    // Route::resource('users', UserController::class);
    // Route::resource('roles', RoleController::class);
});
