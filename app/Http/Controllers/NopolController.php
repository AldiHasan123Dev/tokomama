<?php

namespace App\Http\Controllers;

use App\Models\Nopol;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NopolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.nopol');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Nopol::create($request->all());
        return redirect()->route('master.nopol', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nopol $nopol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nopol $nopol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = Nopol::find($request->id);
        $data->nopol = $request->nopol;
        $data->save();
        return redirect()->route('master.nopol');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nopol $nopol)
    {
        Nopol::destroy(request('id'));
        return route('master.nopol');
    }

    public function datatable()
    {
        $data = Nopol::query()->orderBy('id', 'desc');

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            return '<div class="flex gap-3 mt-2">
            <button onclick="getData(' . $row->id . ', \'' . addslashes($row->nopol) . '\')" id="delete-faktur-all" class="text-yellow-300 font-semibold mb-3 self-end" ><i class="fa-solid fa-pencil"></i></button> |
            <button onclick="deleteData('. $row->id .')" id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end" ><i class="fa-solid fa-trash"></i></button>
            </div>';
        })
        ->rawColumns(['aksi'])
        ->make();
    }
}
