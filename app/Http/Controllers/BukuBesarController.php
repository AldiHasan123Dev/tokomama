<?php

namespace App\Http\Controllers;

use App\Models\BukuBesar;
use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\Nopol;
use App\Models\TemplateJurnal;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BukuBesarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = TemplateJurnal::all();
        $nopol = Nopol::where('status', 'aktif')->get();
        $coa = Coa::where('status', 'aktif')->get();
        return view('jurnal.buku-besar', compact('templates', 'nopol', 'coa'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BukuBesar $bukuBesar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BukuBesar $bukuBesar)
    {
        //
    }

    public function datatable($month, $year, $coa)
    {
        $data = Jurnal::whereMonth('tgl', $month)
        ->whereYear('tgl', $year)
        ->where('coa_id', $coa)
        ->orderBy('created_at')
        ->get();

        $totalDebit = $data->sum('debit');
        $totalKredit = $data->sum('kredit');
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('no_akun', function ($row) {
            return $row->Coa->no_akun ?? '-';
        })
        ->addColumn('akun', function ($row) {
            return $row->Coa->nama_akun ?? '-';
        })
        ->addColumn('saldo', function($row) use ($totalKredit) {
            return $totalKredit;
        })
        ->make();
    }

    public function datatableDefault($month, $year)
    {
        $data = Jurnal::whereMonth('tgl', $month)
        ->whereYear('tgl', $year)
        ->orderBy('created_at')
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('no_akun', function ($row) {
            return $row->Coa->no_akun ?? '-';
        })
        ->addColumn('akun', function ($row) {
            return $row->Coa->nama_akun ?? '-';
        })
        ->addColumn('saldo', function($row) {
            return $row->sum('debit') - $row->sum('kredit');
        })
        ->make();
    }
}
