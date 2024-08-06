<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Invoice;
use App\Models\Jurnal;
use App\Models\Nopol;
use App\Models\Supplier;
use App\Models\SuratJalan;
use App\Models\TemplateJurnal;
use App\Models\TipeJurnal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jurnal.jurnal');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // dd($_GET['tipe']);
        $data = Jurnal::where('tipe', $_GET['tipe'])->where('no', $_GET['no'])->join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')->get();
        $coa = Coa::where('status', 'aktif')->get();
        $tgl = $_GET['tgl'];
        $nopol = Nopol::where('status', 'aktif')->get();
        $invoice = Invoice::get();
        $invext = Transaction::whereNot('invoice_external', null)->get();
        return view('jurnal.edit-jurnal', compact('data', 'tgl', 'coa', 'nopol', 'invoice', 'invext'));
    }

    public function merger()
    {
        $jurnal = Jurnal::groupBy('nomor')->orderBy('nomor', 'asc')->get();
        return view('jurnal.jurnal-merger', compact('jurnal'));
    }

    function merger_store(Request $request)
    {
        $tujuan = Jurnal::where('nomor', $request->jurnal_tujuan)->first();
        Jurnal::where('nomor',$request->jurnal_awal)->update([
            'nomor' => $tujuan->nomor,
            'no' => $tujuan->no,
            'tipe' => $tujuan->tipe,
            'tgl' => $tujuan->tgl
        ]);

        return to_route('jurnal.index')->with('success','Merge No. Jurnal berhasil');
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        // dd($request->all());

        //query customer, supplier, barang
        $invoice = $request->invoice;
        $invoices = Invoice::where('invoice', $invoice)->with(['transaksi.suratJalan.customer', 'transaksi.barang'])->get();
        $customer = [];
        $supplier = [];
        $barang = [];
        $i = 0;
        foreach ($invoices as $item) {
            $customer[$i] = $item->transaksi->suratJalan->customer->nama;
            $supplier[$i] = $item->transaksi->suppliers->nama;
            $barang[$i] = $item->transaksi->barang->nama;
            $i++;
        }

        dd($barang);

        $tipe = explode('-',explode('/', $request->nomor)[1])[0];
        $data = Jurnal::find($request->id);
        $data->nomor = $request->nomor;
        $data->debit = $request->debit;
        $data->kredit = $request->kredit;
        $data->keterangan = $request->keterangan;
        $data->invoice_external = $request->invoice_external;
        $data->nopol = $request->nopol;
        $data->tipe = $tipe;
        $data->coa_id = $request->coa_id;


        if ($data->save()) {
            return redirect()->route('jurnal.edit', $data)->with('success', 'Data Jurnal berhasil diubah!');
        } else {
            return redirect()->route('jurnal.edit', $data)->with('error', 'Data Jurnal gagal diubah!');
        }

        return redirect()->route('jurnal.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }

    public function dataTable()
    {
        $jurnal = Jurnal::join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')->orderBy('tgl', 'asc')->orderBy('nomor', 'asc')->orderBy('tipe', 'asc')->get();

        return DataTables::of($jurnal)
            ->addIndexColumn()
//            ->addColumn('#', function ($row) {
//                return '<input type="checkbox" name="id' . $row->id . '" id="id" value="' . $row->id . '">';
//            })
//            ->rawColumns(['#'])
            ->make(true);
    }

    public function datatableEdit()
    {
        
    }
}
