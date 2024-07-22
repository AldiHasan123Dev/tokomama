<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\NSFP;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ids = explode(',', request('id_transaksi'));
        $transaksi = Transaction::whereIn('id', $ids)->get();
        $count = $transaksi->groupBy('suratJalan.id_customer');
        if($count->count()>1){
            return back()->with('error', 'Invoice hanya bisa dibuat untuk 1 customer');
        }
        $invoice_count = request('invoice_count');
        $nsfp = NSFP::where('available', '1')->orderBy('nomor')->take($invoice_count)->get();
        if($nsfp->count() < $invoice_count) {
            return back()->with('error', 'NSFP Belum Tersedia, pastikan nomor NSFP tersedia.');
        }
        $array_jumlah = [];
        foreach ($transaksi as $item) {
            $array_jumlah[$item->id] = $item->jumlah_jual;
        }
        $array_jumlah = json_encode($array_jumlah);
        $invoice_count = request('invoice_count');
        return view('invoice.index', compact('transaksi','ids','invoice_count','array_jumlah'));
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
        // dd($request->all());
        // dd(date("n"));
        $tgl_inv = $request->tgl_invoice;
        $monthNumber = (int) substr($tgl_inv, 5, 2);
        // dd($monthNumber);
        $data = array();
        $array_invoice = array();
        $invoice_count = $request->invoice_count;
        $nsfp = NSFP::where('available', '1')->orderBy('nomor')->take($invoice_count)->get();
        if($nsfp->count() < $invoice_count) {
            return back()->with('error', 'NSFP Belum Tersedia, pastikan nomor NSFP tersedia.');
        }

        $no = Invoice::whereYear('created_at', date('Y'))->max('no') + 1;
        foreach ($nsfp as $item) {
            $roman_numerals = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $month_number = $monthNumber;
            $month_roman = $roman_numerals[$month_number];
            $inv= sprintf('%03d', $no) . '/INV/SB-' . $month_roman . '/' . date('Y');
            array_push($array_invoice, [
                'id_nsfp' => $item->id,
                'invoice' => $inv,
                'no' => $no
            ]);
            $no++;
        }


        foreach ($request->invoice as $id_transaksi => $invoice) {
            foreach ($invoice as $idx => $item) {
                $data[$id_transaksi]['invoice'][$idx] = $item;
            }
        }
        foreach ($request->jumlah as $id_transaksi => $jumlah) {
            foreach ($jumlah as $idx => $item) {
                $data[$id_transaksi]['jumlah'][$idx] = $item;
            }
        }

        

        DB::transaction(function () use($data, $array_invoice, $request) {
            foreach ($data as $id_transaksi => $array_data) {
                // dd($request->tgl_invoice);
                for ($i=0; $i < count($array_data['invoice']); $i++) {
                    if ((int)$array_data['jumlah'][$i] > 0) {
                        $trx = Transaction::find($id_transaksi);

                        Invoice::create([
                            'id_transaksi' => $id_transaksi,
                            'id_nsfp' => $array_invoice[(int)$array_data['invoice'][$i]]['id_nsfp'],
                            'invoice' => $array_invoice[(int)$array_data['invoice'][$i]]['invoice'],
                            'harga' => $trx->harga_jual,
                            'jumlah' => $array_data['jumlah'][$i],
                            'subtotal' => $array_data['jumlah'][$i] * $trx->harga_jual,
                            'no' => $array_invoice[(int)$array_data['invoice'][$i]]['no'],
                            'tgl_invoice' => $request->tgl_invoice,
                        ]);
                        $trx->update([
                            'sisa' => $trx->sisa - $array_data['jumlah'][$i]
                        ]);
                        NSFP::find($array_invoice[(int)$array_data['invoice'][$i]]['id_nsfp'])->update([
                            'available' => 0,
                            'invoice' => $array_invoice[(int)$array_data['invoice'][$i]]['invoice'],
                        ]);
                    }
                }
            }
        });

        return to_route('keuangan.invoice')->with('success', 'Invoice Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
