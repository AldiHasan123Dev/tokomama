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
        if (isset($_GET['tipe']) && isset($_GET['month']) && isset($_GET['year'])) {
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
        Jurnal::where('nomor', $request->jurnal_awal)->update([
            'nomor' => $tujuan->nomor,
            'no' => $tujuan->no,
            'tipe' => $tujuan->tipe,
            'tgl' => $tujuan->tgl
        ]);

        return to_route('jurnal.index')->with('success', 'Merge No. Jurnal berhasil');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        dd($request->all());

        if ($request->invoice != null || $request->invoice != '-') {
            if (str_contains($request->invoice, '_')) {
                $inv = explode('_', $request->invoice)[0];
                $index = explode('_', $request->invoice)[1];
                $invoices = Invoice::with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                ])
                    ->where('invoice', $inv)
                    ->get();

                $barang = $invoices[$index]->transaksi->barang->nama;
                $supplier = $invoices[$index]->transaksi->suppliers->nama;
                $customer = $invoices[$index]->transaksi->suratJalan->customer->nama;
                $quantity = $invoices[$index]->transaksi->jumlah_jual;
                $satuan = $invoices[$index]->transaksi->satuan_jual;
                $hargabeli = $invoices[$index]->transaksi->harga_beli;
                $hargajual = $invoices[$index]->transaksi->harga_jual;
                $ket = $invoices[$index]->transaksi->keterangan;

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
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;

                $tipe = explode('-', explode('/', $request->nomor)[1])[0];
                $no = str_replace(' ', '', explode('-', explode('/', $request->nomor)[0])[1]);
                $data = Jurnal::find($request->id);
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keteranganNow;
                $data->invoice = $inv;
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
            } else {
                $invoice = $request->invoice;
                $invoices = Invoice::where('invoice', $invoice)->with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                ])->get();

                $barang = $invoices[0]->transaksi->barang->nama;
                $supplier = $invoices[0]->transaksi->suppliers->nama;
                $customer = $invoices[0]->transaksi->suratJalan->customer->nama;
                $quantity = $invoices[0]->transaksi->jumlah_jual;
                $satuan = $invoices[0]->transaksi->satuan_jual;
                $hargabeli = $invoices[0]->transaksi->harga_beli;
                $hargajual = $invoices[0]->transaksi->harga_jual;
                $ket = $invoices[0]->transaksi->keterangan;

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
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;

                $tipe = explode('-', explode('/', $request->nomor)[1])[0];
                $no = str_replace(' ', '', explode('-', explode('/', $request->nomor)[0])[1]);
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
            }
        } else if ($request->invoice_external) {
            if (str_contains($request->invoice_external, '_')) {
                $invext = explode('_', $request->invoice_external)[0];
                $index = explode('_', $request->invoice_external)[1];

                $invoice_external = Transaction::where('invoice_external', $request->invoice_external)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();

                $barang = $invoice_external[$index]->barang->nama;
                $supplier = $invoice_external[$index]->suppliers->nama;
                $customer = $invoice_external[$index]->suratJalan->customer->nama;
                $quantity = $invoice_external[$index]->jumlah_jual;
                $satuan = $invoice_external[$index]->satuan_jual;
                $hargabeli = $invoice_external[$index]->harga_beli;
                $hargajual = $invoice_external[$index]->harga_jual;
                $ket = $invoice_external[$index]->keterangan;

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
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;

                $tipe = explode('-', explode('/', $request->nomor)[1])[0];
                $no = str_replace(' ', '', explode('-', explode('/', $request->nomor)[0])[1]);
                $data = Jurnal::find($request->id);
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keteranganNow;
                $data->invoice_external = $invext;
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
            } else {
                $invoice_external = $request->invoice_external;
                $invoiceExternal = Transaction::where('invoice_external', $request->invoice_external)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();

                $barang = $invoiceExternal[0]->barang->nama;
                $supplier = $invoiceExternal[0]->suppliers->nama;
                $customer = $invoiceExternal[0]->suratJalan->customer->nama;
                $quantity = $invoiceExternal[0]->jumlah_jual;
                $satuan = $invoiceExternal[0]->satuan_jual;
                $hargabeli = $invoiceExternal[0]->harga_beli;
                $hargajual = $invoiceExternal[0]->harga_jual;
                $ket = $invoiceExternal[0]->keterangan;

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
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;

                $tipe = explode('-', explode('/', $request->nomor)[1])[0];
                $no = str_replace(' ', '', explode('-', explode('/', $request->nomor)[0])[1]);
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
            }
        } else {
            return redirect()->back()->with('error', 'Invoice dan Invoice External kosong');
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
