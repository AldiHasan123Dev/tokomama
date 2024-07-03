<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.barang');
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
        // dd($request);
        $data = Barang::create($request->all());
        return redirect()->route('master.barang', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = Barang::find($request->id);
        $data->kode_objek = $request->kode_objek;
        $data->nama = $request->nama;
        $data->save();
        return redirect()->route('master.barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Barang::destroy(request('id'));
        return route('master.barang');
    }

    public function datatable()
    {
        $data = Barang::query()->orderBy('id', 'desc');

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            return '<div class="flex gap-3 mt-2">
            <button onclick="getData(' . $row->id . ', \'' . addslashes($row->kode_objek) . '\', \'' . addslashes($row->nama) . '\')" id="delete-faktur-all" class="text-yellow-300 font-semibold mb-3 self-end" ><i class="fa-solid fa-pencil"></i></button> |
            <button onclick="deleteData('. $row->id .')" id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end" ><i class="fa-solid fa-trash"></i></button>
            </div>';
        })
        ->rawColumns(['aksi'])
        ->make();
    }
}
