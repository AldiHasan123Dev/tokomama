<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use function Laravel\Prompts\alert;

class InvoiceController extends Controller
{
    public function dataTable()
    {
        $data = SuratJalan::query()->where('status', 'pre');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<form method=' . 'post' . ' action = ' . route('invoice.pre-invoice.ambil') . '><input type=hidden name=id value='. $row->id .'><button type=submit>ambil</button></form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function ambil(Request $request)
    {
        
        
        // alert("hello");
        // $data = SuratJalan::query();
    }
}
