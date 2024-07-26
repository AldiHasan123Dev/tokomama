<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\JurnalTemplate;
use App\Models\TemplateJurnal;
use App\Models\TemplateJurnalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $coa = Coa::where('status', 'aktif')->get();
        return view('jurnal.create-jurnal-template', compact('coa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $result = TemplateJurnal::create([
                'nama' => $request->nama
            ]);

            if($result){
                $idTemplateJurnal = TemplateJurnal::latest('id')->first();
                TemplateJurnalItem::create([
                    'template_jurnal_id' => $idTemplateJurnal->id,
                    'coa_debit_id' => $request->coa_debit_id,
                    'coa_kredit_id' => $request->coa_kredit_id,
                    'keterangan' => $request->keterangan,
                ]);
            }
        });
        
        return to_route('jurnal.template-jurnal.create')->with('success', 'Data berhasil tambahkan');

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
