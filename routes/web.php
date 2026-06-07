<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

// Halaman Landing Page Utama
Route::get('/', function () {
    return view('welcome');
});

// Jalur Autentikasi (Hanya untuk Guest / Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Jalur Proteksi (Hanya untuk User yang Sudah Login)
Route::middleware('auth')->group(function () {
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Manajemen Proyek CollabFlow (Route Dashboard Duplikat Sudah Dihapus)
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/projects/join', [ProjectController::class, 'join'])->name('projects.join');
    
    // Manajemen Tugas / Tasks
    Route::post('/projects/{id}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
});