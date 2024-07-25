<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\Nopol;
use App\Models\TemplateJurnal;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = TemplateJurnal::all();
        $nopol = Nopol::where('status', 'aktif')->get();
        $coa = Coa::where('status', 'aktif')->get();
        return view('jurnal.jurnal-manual', compact('templates', 'nopol', 'coa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = TemplateJurnal::get();
        $coa = Coa::where('status', 'aktif')->get();
        $nopol = Nopol::where('status', 'aktif')->get();
        return view('jurnal.jurnal-manual', compact('templates','coa','nopol'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }
}
