<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurnalManualController extends Controller
{
    function index() {
        return view('jurnal.jurnal-manual');
    }
}
