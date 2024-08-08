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

        $invoices = Invoice::all();
        $invProc = [];
        $invoiceCounts = [];
        foreach ($invoices as $invoice) {
            $invoiceNumber = $invoice->invoice;
            if (!isset($invoiceCounts[$invoiceNumber])) {
                $invoiceCounts[$invoiceNumber] = 0;
            }
            $invoiceCounts[$invoiceNumber]++;

            $processedInvoiceNumber = $invoiceNumber . '_' . $invoiceCounts[$invoiceNumber];
            $invProc[] = $processedInvoiceNumber;
        }


        $invext = Transaction::whereNot('invoice_external', null)->get();
        $invExtProc = [];
        $transactionCounts = [];
        foreach ($invext as $transaction) {
            $invoiceNumber = $transaction->invoice_external;
            if (!isset($transactionCounts[$invoiceNumber])) {
                $transactionCounts[$invoiceNumber] = 0;
            }
            $transactionCounts[$invoiceNumber]++;

            $procTransactionNumber = $invoiceNumber . '_' . $transactionCounts[$invoiceNumber];
            $invExtProc[] = $procTransactionNumber;
        }

        session(['jurnal_edit_url' => url()->full()]);
        return view('jurnal.edit-jurnal', compact('data', 'tgl', 'coa', 'nopol', 'invProc', 'invExtProc'));
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
        dd($request->all());

        if($request->invoice != null || $request->invoice != '-') {
            if(str_contains($request->invoice, '_')) {
                $inv = explode('_', $request->invoice)[0];
                $no = explode('_', $request->invoice)[1];
                $invoices = Invoice::with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                ])
                    ->where('invoice', $inv)
                    ->get();

                $barang = $invoices[$no]->transaksi->barang->nama;
                $supplier = $invoices[$no]->transaksi->suppliers->nama;
                $customer = $invoices[$no]->transaksi->suratJalan->customer->nama;
                $quantity = $invoices[$no]->transaksi->jumlah_jual;
                $satuan = $invoices[$no]->transaksi->satuan_jual;
                $hargabeli = $invoices[$no]->transaksi->harga_beli;
                $hargajual = $invoices[$no]->transaksi->harga_jual;
                $ket = $invoices[$no]->transaksi->keterangan;

            } else {

            }
        } else if($request->invoice_external) {
            
        } else {
            return redirect()->back()->with('error', 'Invoice dan Invoice External kosong');
        }

        //query customer, supplier, barang
        $invoice = $request->invoice;
        $invoices = Invoice::where('invoice', $invoice)->with(['transaksi.suratJalan.customer', 'transaksi.barang'])->get();

        $barang = $invoices[0]->transaksi->barang->nama;
        $supplier = $invoices[0]->transaksi->suppliers->nama;
        $customer = $invoices[0]->transaksi->suratJalan->customer->nama;
        
        
        $keterangan = $request->keterangan;

        if (str_contains($request->keterangan, '[1]')) {
            $keterangan = str_replace('[1]', $customer, $keterangan);
        } 
        if (str_contains($request->keterangan, '[2]')) {
            $keterangan = str_replace('[2]', $supplier, $keterangan);
        }
        if (str_contains($request->keterangan, '[3]')) {
            $keterangan = str_replace('[3]', $barang, $keterangan);
        }
        if (str_contains($request->keterangan, '[4]')) {
            $keterangan = str_replace('[4]', $request->param4, $keterangan);
        }
        if (str_contains($request->keterangan, '[5]')) {
            $keterangan = str_replace('[5]', $request->param5, $keterangan);
        }
        if (str_contains($request->keterangan, '[6]')) {
            $keterangan = str_replace('[6]', $request->param6, $keterangan);
        }
        if (str_contains($request->keterangan, '[7]')) {
            $keterangan = str_replace('[7]', $request->param7, $keterangan);
        }
        if (str_contains($request->keterangan, '[8]')) {
            $keterangan = str_replace('[8]', $request->param8, $keterangan);
        }

        $keteranganNow = $keterangan;


        $tipe = explode('-',explode('/', $request->nomor)[1])[0];

        $no = str_replace(' ', '', explode('-', explode('/', $request->nomor)[0])[1]);
        // dd($no);
        $data = Jurnal::find($request->id);
        $data->nomor = $request->nomor;
        $data->debit = $request->debit;
        $data->kredit = $request->kredit;
        $data->keterangan = $keteranganNow;
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
