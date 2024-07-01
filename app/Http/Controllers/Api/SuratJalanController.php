<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SuratJalanController extends Controller
{
    public function dataTable()
    {
        $data = SuratJalan::query();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
