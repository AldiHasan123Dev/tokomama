<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    function index()
    {
        return view('jurnal.coa');
    }

    function dataTable()
    {
        $data = Coa::query();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('#', function ($row) {
                return '<input type="checkbox" name="' . $row->id . '" id="id" value="' . $row->id . '">';
            })
            ->rawColumns(['#'])
            ->make(true);
    }

    function statusCoa(Request $request)
    {
        for ($i = 0; $i < count($request->all()); $i++) {
            echo "test";
        }
    }
}
