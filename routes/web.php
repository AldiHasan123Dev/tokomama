<?php

use App\Http\Controllers\Api\NSFPController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\BukuBesarPembantuController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\JurnalManualController;
use App\Http\Controllers\NSFPController as nsfp;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NopolController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\TemplateJurnalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Resources\DatatableResource;
use App\Http\Resources\SuratJalanResource;
use App\Models\Customer;
use App\Models\Jurnal;
use App\Models\NSFP as ModelsNSFP;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('login');
});
// Route::get('test', function () {
//     $data1 = SuratJalan::get();
//     $data = SuratJalanResource::collection($data1);
//     $res = $data->toArray(request());
//     return response($data);
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/surat-jalan-cetak/{surat_jalan}', [SuratJalanController::class, 'cetak'])->name('surat-jalan.cetak');
    Route::get('/surat-jalan-tarif-barang', [SuratJalanController::class, 'tarif'])->name('surat-jalan.barang');
    Route::post('/surat-jalan-data', [SuratJalanController::class, 'dataTable'])->name('surat-jalan.data');
    Route::post('/surat-jalan-edit', [SuratJalanController::class, 'update'])->name('surat-jalan.data.edit');
    Route::post('/surat-jalan-delete', [SuratJalanController::class, 'destroy'])->name('surat-jalan.data.delete');
    Route::resource('surat-jalan', SuratJalanController::class);
    Route::resource('invoice-transaksi', InvoiceController::class);
    Route::resource('jurnal', JurnalController::class);
    Route::post('ekspedisi-data', [EkspedisiController::class, 'dataTable'])->name('ekspedisi.data');
    Route::post('transaction-data', [TransactionController::class, 'dataTable'])->name('transaksi.data');
    Route::put('transaction-update', [TransactionController::class, 'update'])->name('transaksi.update');
    Route::get('coa', [CoaController::class,'index'])->name('jurnal.coa');
    Route::post('coa', [CoaController::class,'statusCoa'])->name('jurnal.coa');
    Route::get('template-jurnal', [TemplateJurnalController::class,'index'])->name('jurnal.template-jurnal');
    Route::get('template-jurnal-create', [TemplateJurnalController::class,'create'])->name('jurnal.template-jurnal.create');
    Route::post('/omzet-data', [KeuanganController::class, 'dataTableOmzet'])->name('keuangan.omzet.data');
    Route::resource('buku-besar', BukuBesarController::class);
    Route::resource('buku-besar-pembantu', BukuBesarPembantuController::class);
});

Route::prefix('keuangan')->controller(KeuanganController::class)->middleware('auth')->group(function () {
    Route::get('', 'index')->name('keuangan');
    Route::get('surat-jalan', 'suratJalan')->name('keuangan.surat-jalan');
    Route::post('surat-jalan', 'suratJalanStore')->name('keuangan.surat-jalan');
    Route::get('invoice', 'invoice')->name('keuangan.invoice');
    Route::get('pre-invoice', 'preInvoice')->name('keuangan.pre-invoice');
    Route::post('draf-invoice/{surat_jalan}', 'submitInvoice')->name('keuangan.invoice.submit');
    Route::get('draf-invoice/{surat_jalan}', 'invoiceDraf')->name('keuangan.invoice.draf');
    Route::get('cetak-invoice', 'cetakInvoice')->name('keuangan.invoice.cetak');
    Route::get('omzet', 'omzet')->name('keuangan.omzet');
    Route::get('omzet-list', 'dataTableOmzet')->name('keuangan.omzet.datatable');
    Route::post('omzet-export', 'OmzetExportExcel')->name('keuangan.omzet.exportexcel');
});

Route::prefix('pajak')->middleware('auth')->group(function () {
    Route::get('nsfp', [PajakController::class, 'index'])->name('pajak.nsfp');
    Route::get('laporan-ppn', [PajakController::class, 'lapPpn'])->name('pajak.laporan-ppn');
    Route::get('laporan-ppn-data', [PajakController::class, 'datatable'])->name('pajak.laporan-ppn.data');
    Route::post('export-laporan-ppn-excel', [PajakController::class, 'PPNExportExcel'])->name('pajak.export.ppnexc');
    Route::post('export-laporan-ppn-csv', [PajakController::class, 'PPNExportCsv'])->name('pajak.export.ppncsv');
});

Route::prefix('master')->controller(CustomerController::class)->middleware('auth')->group(function () {
    Route::get('customer', 'index')->name('master.customer');
    Route::get('role-menu', [MenuController::class,'index'])->name('menu.index');
    Route::get('customer_list', 'datatable')->name('master.customer.list');
    Route::post('customer', 'store')->name('master.customer.add');
    Route::post('customer_delete', 'destroy')->name('master.customer.delete');
    Route::post('costumer_edit', 'update')->name('master.customer.edit');
    Route::resource('ekspedisi', EkspedisiController::class)->only(['index','store','update','destroy']);
});

Route::prefix('master')->controller(BarangController::class)->middleware('auth')->group(function () {
    Route::get('barang', 'index')->name('master.barang');
    Route::get('barang_list', 'datatable')->name('master.barang.list');
    Route::post('barang_add', 'store')->name('master.barang.add');
    Route::post('barang_edit', 'update')->name('master.barang.edit');
    Route::post('barang_delete', 'destroy')->name('master.barang.delete');
});

Route::prefix('master')->controller(NopolController::class)->middleware('auth')->group(function () {
    Route::get('nopol', 'index')->name('master.nopol');
    Route::get('nopol_list', 'datatable')->name('master.nopol.list');
    Route::post('nopol_add', 'store')->name('master.nopol.add');
    Route::post('nopol_edit', 'update')->name('master.nopol.edit');
    Route::post('nopol_delete', 'destroy')->name('master.nopol.delete');
    Route::post('set_status', 'setStatus')->name('master.nopol.editstatus');
});

Route::prefix('master')->controller(UserController::class)->middleware('auth')->group(function () {
    Route::resource('user', UserController::class)->only(['index','store','update','destroy']);
    ROute::get('data_user_with_role', 'datatable')->name('master.user.data');
});

Route::prefix('master')->controller(SatuanController::class)->middleware('auth')->group(function () {
    Route::resource('satuan', SatuanController::class)->only(['index','store','update','destroy']);
    Route::get('stauan-data', 'dataTable')->name('master.satuan.data');
});

Route::prefix('master')->controller(RoleController::class)->middleware('auth')->group(function () {
    Route::resource('role', RoleController::class);
});

Route::prefix('master')->controller(SupplierController::class)->middleware('auth')->group(function () {
    Route::get('supplier', 'index')->name('master.supplier');
    Route::get('supplier-list', 'datatable')->name('master.supplier.datatable');
    Route::post('supplier-add', 'store')->name('master.supplier.add');
    Route::post('supplier-edit', 'update')->name('master.supplier.edit');
    Route::post('supplier-delete', 'destroy')->name('master.supplier.delete');
});

// Route::prefix('jurnal')->controller(CoaController::class)->middleware('auth')->group(function () {
//     Route::get('coa', 'index')->name('jurnal.coa');
//     Route::post('coa', 'statusCoa')->name('jurnal.coa');
// });

// Route::prefix('jurnal')->controller(TemplateJurnalController::class)->middleware('auth')->group(function () {
//     Route::get('template-jurnal', 'index')->name('jurnal.template-jurnal');
//     Route::get('template-jurnal-create', 'create')->name('jurnal.template-jurnal.create');
// });

Route::get('/invoice', function () {
    $surat_jalan = SuratJalan::all();
    return view('keuangan.invoice_pdf', compact('surat_jalan'));
});

Route::get('/invoice_pdf/{id}', [KeuanganController::class, 'generatePDF'])->name('invoice.print');


require __DIR__ . '/auth.php';
