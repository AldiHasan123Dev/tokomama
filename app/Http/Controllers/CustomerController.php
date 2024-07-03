<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.customer');
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
        $data = Customer::create($request->all());
        return redirect()->route('master.customer', $data);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // dd($request);
        $data = Customer::find($request->id);
        $data->nama = $request->nama;
        $data->npwp = $request->npwp;
        $data->email = $request->email;
        $data->no_telp = $request->no_telp;
        $data->alamat = $request->alamat;
        $data->alamat_npwp = $request->alamat_npwp;
        $data->save();
        
        return redirect()->route('master.customer');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // dd(request('id'));
        Customer::destroy(request('id'));
        return route('master.customer');

    }


    public function datatable()
    {
        $data = Customer::query()->orderBy('id', 'desc');

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            return '<div class="flex gap-3 mt-2">
            <button onclick="getData(' . $row->id . ', \'' . addslashes($row->nama) . '\', \'' . addslashes($row->npwp) . '\', \'' . addslashes($row->email) . '\', \'' . addslashes($row->no_telp) . '\', \'' . addslashes($row->alamat) . '\', \'' . addslashes($row->alamat_npwp) . '\')" id="delete-faktur-all" class="text-yellow-300 font-semibold mb-3 self-end" ><i class="fa-solid fa-pencil"></i></button> |
            <button onclick="deleteData('. $row->id .')" id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end" ><i class="fa-solid fa-trash"></i></button>
            </div>';
        })
        ->rawColumns(['aksi'])
        ->make();
    }
}
