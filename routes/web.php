<?php

use App\Http\Controllers\Api\NSFPController;
use App\Http\Controllers\NSFPController as nsfp;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Resources\DatatableResource;
use App\Models\NSFP as ModelsNSFP;
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
    Route::get('/surat-jalan-cetak/{surat_jalan}', [SuratJalanController::class, 'cetak'])->name('surat-jalan.cetak');
    Route::post('/surat-jalan-data', [SuratJalanController::class, 'dataTable'])->name('surat-jalan.data');
    Route::resource('surat-jalan', SuratJalanController::class);
});

Route::prefix('keuangan')->controller(KeuanganController::class)->middleware('auth')->group(function () {
    Route::get('', 'index')->name('keuangan');
    Route::get('surat-jalan', 'suratJalan')->name('keuangan.surat-jalan');
    Route::post('surat-jalan', 'suratJalanStore')->name('keuangan.surat-jalan');
    Route::get('invoice', 'invoice')->name('keuangan.invoice');
    Route::get('pre-invoice', 'preInvoice')->name('keuangan.pre-invoice');
});

Route::prefix('pajak')->middleware('auth')->group(function () {
    Route::get('nsfp', [PajakController::class, 'index'])->name('pajak.nsfp');
    Route::get('laporan-ppn', [PajakController::class, 'lapPpn'])->name('pajak.laporan-ppn');
});

Route::prefix('masters')->controller(MasterController::class)->middleware('auth')->group(function() {
    Route::get('customer', 'index')->name('master.customer');
});

Route::get('/invoice', function () {
    return view('invoice');
});

Route::get('/invoice_pdf', [KeuanganController::class, 'generatePDF'])->name('invoice.print');


require __DIR__ . '/auth.php';
