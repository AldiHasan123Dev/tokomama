<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\SuratJalan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    function index() {
        return to_route('keuangan.surat-jalan');
    }

    function suratJalan() {
        $masterBarangs = Barang::all();
        return view('keuangan.surat-jalan', compact('masterBarangs'));
    }

    function suratJalanStore(Request $request) : RedirectResponse {
        SuratJalan::create($request->all());
        return to_route('keuangan.invoice');
    }

    function invoice() {
        return view('keuangan.invoice');
    }

    function preInvoice() {
        return view('keuangan.pre-invoice');
    }
}
