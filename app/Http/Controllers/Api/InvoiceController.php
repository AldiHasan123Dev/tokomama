<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function dataTable() {
        $data = SuratJalan::query();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<a href='.route('nsfp.data').'>Ambil</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
