<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PajakController extends Controller
{
    public function index()
    {
        $data = DB::table('nsfp')->get();

        return view('pajak.nsfp',  ["data" => $data]);
    }

    public function lapPpn()
    {
        return view('pajak.laporan-ppn');
    }

    public function nsfpAvailable()
    {
        $data = DB::table('nsfp')->get();
        return $data;
    }
}
