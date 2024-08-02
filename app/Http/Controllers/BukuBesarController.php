<?php

namespace App\Http\Controllers;

use App\Models\BukuBesar;
use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\Nopol;
use App\Models\TemplateJurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        $coa_id = $_GET['coa'] ?? 1;
        $coa_by_id = Coa::find($coa_id)->first();

        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $year = $_GET['year'] ?? date('Y');

        $saldo = array();

        foreach ($months as $idx => $item) {
            $bln = $idx + 1;
            $c = new Carbon($year.'-'.sprintf('%02d',$bln).'-01');
            $now = $c->startOfMonth()->format('Y-m-d');
            $last = $c->endOfMonth()->format('Y-m-d');
            $start = $c->subMonth()->startOfMonth()->format('Y-m-d');
            // $start = '2022-12-01';
            $des = $c->endOfMonth()->format('Y-m-d');
            // dd($start,$des,$last);
            if($idx==0){
                $saldo_awal = Jurnal::where('coa_id', $coa_id)->whereBetween('tgl',['2023-12-01',$des])->sum('debit') - Jurnal::where('coa_id',$coa_id)->whereBetween('tgl',['2023-12-01',$des])->sum('kredit');
            } else {
                $start = $now;
                $saldo_awal =  $saldo['saldo_akhir'][$idx-1];
            }
            $debit = Jurnal::where('coa_id',$coa_id)->whereBetween('tgl',[$now,$last])->sum('debit');
            $credit = Jurnal::where('coa_id',$coa_id)->whereBetween('tgl',[$now,$last])->sum('kredit');
            $saldo['saldo_awal'][$idx] = $saldo_awal;
            $saldo['saldo_akhir'][$idx] = ($debit + $saldo_awal ) - $credit;
            $saldo['debit'][$idx] = $debit;
            $saldo['kredit'][$idx] = $credit;
        }

        return view('jurnal.buku-besar', compact('templates','nopol', 'coa', 'months', 'saldo','saldo_awal', 'coa', 'coa_id', 'year', 'coa_by_id'));
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
