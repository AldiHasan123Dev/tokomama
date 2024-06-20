<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    function index() {
        return to_route('keuangan.surat-jalan');
    }

    function suratJalan() {
        return view('keuangan.surat-jalan');
    }

    function invoice() {
        return view('keuangan.invoice');
    }
}
