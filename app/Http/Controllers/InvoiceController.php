<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\NSFP;
use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ids = explode(',', request('id_transaksi'));
        $transaksi = Transaction::whereIn('id', $ids)->get();
        return view('invoice.index', compact('transaksi','ids'));
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
        $data = array();
        $array_invoice = array();
        $invoice_count = (int)$request->invoice_count;
        for ($i=0; $i < $invoice_count; $i++) { 
            $nsfp = NSFP::where('available', '1')->orderBy('nomor')->first();
            if(!$nsfp) {
                return back()->with('error', 'NSFP Belum Tersedia, pastikan nomor NSFP tersedia.');
            }
            $inv = 'INV/' . date('Y') . '/' . sprintf('%03d', $i);
            array_push($array_invoice, [
                'id_nsfp' => $nsfp->id,
                'invoice' => $inv,
            ]);
            $nsfp->available = 0;
            $nsfp->save();
        }

        // dd($array_invoice);
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
        foreach ($data as $id_transaksi => $array_data) {
            for ($i=0; $i < count($array_data['invoice']); $i++) {
                if ((int)$array_data['jumlah'][$i] > 0) {
                    $trx = Transaction::find($id_transaksi); 

                    Invoice::create([
                        'id_transaksi' => $id_transaksi,
                        'id_nsfp' => $array_invoice[(int)$array_data['invoice'] - 1]['id_nsfp'],
                        'invoice' => $array_invoice[(int)$array_data['invoice'] - 1]['invoice'],
                        'harga' => $trx->harga_jual,
                        'jumlah' => $array_data['jumlah'][$i],
                        'subtotal' => $array_data['jumlah'][$i] * $trx->harga_jual
                    ]);
                    $trx->update([
                        'sisa' => $trx->sisa - $array_data['jumlah'][$i]
                    ]);
                }
            }
        }

        return back();
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
