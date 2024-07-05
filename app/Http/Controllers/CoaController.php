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
                return '<input type="checkbox" name="id' . $row->id . '" id="id" value="' . $row->id . '">';
            })
            ->rawColumns(['#'])
            ->make(true);
    }

    function statusCoa(Request $request)
    {
        $newArrayV = array_values($request->all());

        for ($i = 2; $i < count($request->all()); $i++) {
            $getStatusById = Coa::where('id', $newArrayV[$i])->first();

            if ($getStatusById->status == "non-aktif") {
                Coa::find($newArrayV[$i])->update(['status' => "aktif"]);
            } else {
                Coa::find($newArrayV[$i])->update(['status' => "non-aktif"]);
            }
        }

        return redirect()->route('jurnal.coa');
    }
}
