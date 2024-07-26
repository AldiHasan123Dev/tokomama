<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\JurnalTemplate;
use App\Models\TemplateJurnal;
use App\Models\TemplateJurnalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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

        // dd($request->keterangan);
        DB::transaction(function () use ($request) {
            $result = TemplateJurnal::create([
                'nama' => $request->nama
            ]);
            $idTemplateJurnal = TemplateJurnal::latest('id')->first();

            if ($result) {
                for ($i = 0; $i < $request->counter; $i++) {
                    //  dd($request->keterangan[$i]);
                    TemplateJurnalItem::create([
                        'template_jurnal_id' => $idTemplateJurnal->id,
                        'coa_debit_id' => $request->coa_debit_id[$i],
                        'coa_kredit_id' => $request->coa_kredit_id[$i],
                        'keterangan' => $request->keterangan[$i]
                    ]);
                }
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
        $jurnalTemplate = TemplateJurnalItem::where('template_jurnal_id', request('id'))->get();
        // dd($jurnalTemplate);
        return view('jurnal.edit-jurnal-template', compact('jurnalTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TemplateJurnal $templateJurnal)
    {
        $data = TemplateJurnal::find($request->id);
        $data->nama = $request->nama;
        if ($data->save()) {
            return redirect()->route('jurnal.template-jurnal')->with('success', 'Nama Template Jurnal berhasil diubah!');
        } else {
            return redirect()->route('jurnal.template-jurnal')->with('error', 'Nama Template Jurnal gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemplateJurnal $templateJurnal)
    {
        // $result = TemplateJurnalItem::where('template_jurnal_id', request('id'));
        TemplateJurnal::destroy(request('id'));
        return route('jurnal.template-jurnal');
    }

    public function datatable()
    {
        $data = TemplateJurnal::get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<div class="flex gap-3 mt-2">
            <button onclick="getData(' . $row->id . ', \'' . addslashes($row->nama) . '\')" id="delete-faktur-all" class="text-yellow-300 font-semibold mb-3 self-end" ><i class="fa-solid fa-pencil"></i></button> |
            <button onclick="deleteData(' . $row->id . ')"  id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end"><i class="fa-solid fa-trash"></i></button>
        </div>';
            })
            ->rawColumns(['aksi'])
            ->make();
    }
}
