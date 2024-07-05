<?php

use App\Http\Controllers\Api\NSFPController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NSFPController as nsfp;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\NopolController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Resources\DatatableResource;
use App\Models\Customer;
use App\Models\NSFP as ModelsNSFP;
use App\Models\SuratJalan;
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
    Route::post('/surat-jalan-edit', [SuratJalanController::class, 'update'])->name('surat-jalan.data.edit');
    Route::post('/surat-jalan-delete', [SuratJalanController::class, 'destroy'])->name('surat-jalan.data.delete');
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
    Route::get('laporan-ppn-data', [PajakController::class, 'datatable'])->name('pajak.laporan-ppn.data');
});

Route::prefix('master')->controller(CustomerController::class)->middleware('auth')->group(function() {
    Route::get('customer', 'index')->name('master.customer');
    Route::get('customer_list', 'datatable')->name('master.customer.list');
    Route::post('customer', 'store')->name('master.customer.add');
    Route::post('customer_delete', 'destroy')->name('master.customer.delete');
    Route::post('costumer_edit', 'update')->name('master.customer.edit');  
});

Route::prefix('master')->controller(BarangController::class)->middleware('auth')->group(function() {
    Route::get('barang', 'index')->name('master.barang');
    Route::get('barang_list', 'datatable')->name('master.barang.list');
    Route::post('barang_add', 'store')->name('master.barang.add');
    Route::post('barang_edit', 'update')->name('master.barang.edit');
    Route::post('barang_delete', 'destroy')->name('master.barang.delete');
});

Route::prefix('master')->controller(NopolController::class)->middleware('auth')->group(function() {
    Route::get('nopol', 'index')->name('master.nopol');
    Route::get('nopol_list', 'datatable')->name('master.nopol.list');
    Route::post('nopol_add', 'store')->name('master.nopol.add');
    Route::post('nopol_edit', 'update')->name('master.nopol.edit');
    Route::post('nopol_delete', 'destroy')->name('master.nopol.delete');
});

Route::get('/invoice', function () {
    $surat_jalan = SuratJalan::all();
    return view('keuangan.invoice_pdf', compact('surat_jalan'));
});

Route::get('/invoice_pdf/{id}', [KeuanganController::class, 'generatePDF'])->name('invoice.print');


require __DIR__ . '/auth.php';
