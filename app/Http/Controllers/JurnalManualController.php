<?php

namespace App\Http\Controllers;

use App\Models\TipeJurnal;
use Illuminate\Http\Request;

class JurnalManualController extends Controller
{
    function index() {
        return view('jurnal.jurnal-manual', compact('tipe_jurnal'));
    }
}
