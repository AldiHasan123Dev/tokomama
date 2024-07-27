<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\Nopol;
use App\Models\SuratJalan;
use App\Models\TemplateJurnal;
use App\Models\TipeJurnal;
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
        $tipe_jurnal_jnl = TipeJurnal::where('tipe_jurnal', 'JNL')->orderBy('no', 'desc')->first();
        $tipe_jurnal_bkk = TipeJurnal::where('tipe_jurnal', 'BKK')->orderBy('no', 'desc')->first();
        $tipe_jurnal_bkm = TipeJurnal::where('tipe_jurnal', 'BKM')->orderBy('no', 'desc')->first();
        $tipe_jurnal_bbk = TipeJurnal::where('tipe_jurnal', 'BBK')->orderBy('no', 'desc')->first();
        $tipe_jurnal_bbm = TipeJurnal::where('tipe_jurnal', 'BBM')->orderBy('no', 'desc')->first();
        $surat_jalan = SuratJalan::all();
        return view('jurnal.jurnal-manual', compact('templates', 'nopol', 'coa', 'tipe_jurnal_jnl', 'tipe_jurnal_bkk', 'tipe_jurnal_bkm', 'tipe_jurnal_bbk', 'tipe_jurnal_bbm', 'surat_jalan'));
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

    public function getSuratJalanWhereJob()
    {
        // dd(request('job'));
        $surat_jalan = SuratJalan::with(['customer', 'transactions'])
                            ->where('no_job', request('job'))
                            ->get();
                            // dd($surat_jalan);
        return response()->json($surat_jalan);
    }
}
