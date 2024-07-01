<?php

use App\Http\Resources\SuratJalanCollection;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Route;

Route::post('/surat_jalan', function () {
    return new SuratJalanCollection(SuratJalan::all()); 
})->name('suratJalan.data');
