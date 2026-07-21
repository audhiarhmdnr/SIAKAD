<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('jadwal.grid');
});

Route::resource('dosen', DosenController::class)->except(['show']);
Route::resource('mata-kuliah', MataKuliahController::class)->except(['show']);
Route::resource('ruangan', RuanganController::class)->except(['show']);
Route::resource('jadwal', JadwalController::class)->except(['show']);

Route::get('jadwal-grid', [JadwalController::class, 'grid'])->name('jadwal.grid');
Route::get('jadwal-export', [JadwalController::class, 'exportCsv'])->name('jadwal.export');
