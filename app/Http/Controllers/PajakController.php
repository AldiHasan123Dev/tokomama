<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PajakController extends Controller
{
    public function index() {
        return view('pajak.nsfp');
    }

    public function lapPpn() {
        return view('pajak.laporan-ppn');
    }
}
