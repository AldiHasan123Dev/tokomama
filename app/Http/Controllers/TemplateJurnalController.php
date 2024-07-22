<?php

namespace App\Http\Controllers;

use App\Models\TemplateJurnal;
use Illuminate\Http\Request;

class TemplateJurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jurnal.template-jurnal');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurnal.create-jurnal-template');
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
    public function show(TemplateJurnal $templateJurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TemplateJurnal $templateJurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TemplateJurnal $templateJurnal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemplateJurnal $templateJurnal)
    {
        //
    }
}
