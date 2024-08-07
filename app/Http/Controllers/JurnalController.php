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
        if(isset($_GET['tipe']) && isset($_GET['month']) && isset($_GET['year'])){
            $data = Jurnal::whereMonth('tgl', $_GET['month'])->whereYear('tgl', $_GET['year'])->where('tipe', $_GET['tipe'])->join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')->get();
        } elseif (isset($_GET['month']) && isset($_GET['year'])) {
            $data = Jurnal::whereMonth('tgl', $_GET['month'])->whereYear('tgl', $_GET['year'])->join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')->get();
        } else {
            $data = Jurnal::join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')->get();
        }
        // dd($data);
        return view('jurnal.jurnal', compact('data'));
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
        session(['jurnal_edit_url' => url()->full()]);
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
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        // dd($request->all());

        //query customer, supplier, barang
        $invoice = $request->invoice;
        $invoices = Invoice::where('invoice', $invoice)->with(['transaksi.suratJalan.customer', 'transaksi.barang'])->get();

        $barang = $invoices[0]->transaksi->barang->nama;
        $supplier = $invoices[0]->transaksi->suppliers->nama;
        $customer = $invoices[0]->transaksi->suratJalan->customer->nama;
        
        if (str_contains($request->keterangan, '[1]')) {
            $keterangan = str_replace('[1]', $customer, $request->keterangan);
        } else if (str_contains($request->keterangan, '[2]')) {
            $keterangan = str_replace('[2]', $supplier, $request->keterangan);
        } else if (str_contains($request->keterangan, '[3]')) {
            $keterangan = str_replace('[3]', $barang, $request->keterangan);
        } else {
            $keterangan = $request->keterangan;
        }

        $tipe = explode('-',explode('/', $request->nomor)[1])[0];

        $no = str_replace(' ', '', explode('-', explode('/', $request->nomor)[0])[1]);
        // dd($no);
        $data = Jurnal::find($request->id);
        $data->nomor = $request->nomor;
        $data->debit = $request->debit;
        $data->kredit = $request->kredit;
        $data->keterangan = $keterangan;
        $data->invoice_external = $request->invoice_external;
        $data->nopol = $request->nopol;
        $data->tipe = $tipe;
        $data->coa_id = $request->coa_id;

        if ($data->save()) {
            $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
            return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
        } else {
            $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
            return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
        }

        return redirect()->route('jurnal.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        $data = Jurnal::destroy(request('id'));
        $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
        return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil dihapus!');
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

    public function tglUpdate(Request $request)
    {
        // dd($request->all());
        $data = Jurnal::where('nomor', $request->nomor_jurnal_input)->update([
            'tgl' => $request->tgl_input
        ]);
        $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
        return redirect($redirectUrl)->with('success', 'Tanggal Jurnal berhasil diubah!');

    }
}
