<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\SuratJalan;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    function index()
    {
        return redirect('keuangan.surat-jalan');
    }

    function suratJalan()
    {
        $masterBarangs = Barang::all();
        return view('keuangan.surat-jalan', compact('masterBarangs'));
    }

    function suratJalanStore(Request $request): RedirectResponse
    {
        SuratJalan::create($request->all());
        return redirect()->route('keuangan.pre-invoice');
    }

    function invoice()
    {
        return view('keuangan.invoice');
    }

    function preInvoice()
    {
        return view('keuangan.pre-invoice');
    }

    function generatePDF()
    {
        $pdf = FacadePdf::loadView('/invoice')->setPaper('a4', 'landscape');
        return $pdf->stream('invoice.pdf');
    }
}
