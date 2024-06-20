<?php

use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('keuangan')->controller(KeuanganController::class)->middleware('auth')->group(function () {
    Route::get('', 'index')->name('keuangan');
    Route::get('surat-jalan', 'suratJalan')->name('keuangan.surat-jalan');
    Route::get('invoice', 'invoice')->name('keuangan.invoice');
});

Route::prefix('pajak')->middleware('auth')->group(function() {
    Route::get('nsfp', [PajakController::class, 'index'])->name('pajak.nsfp');
    Route::get('laporan-ppn', [PajakController::class, 'lapPpn'])->name('pajak.laporan-ppn');
    // Route::get('/pajak/ppn')
});

require __DIR__.'/auth.php';
