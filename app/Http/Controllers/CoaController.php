<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    function index()
    {
        $coa = Coa::all();
        return view('jurnal.coa', compact('coa'));
    }

    function dataTable()
    {
        return DataTables::of(Coa::query())
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


        for ($i = 3; $i < count($request->all()); $i++) {
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
