<?php

namespace App\Http\Controllers;

use App\Models\BukuBesarPembantu;
use App\Models\Coa;
use App\Models\Nopol;
use App\Models\TemplateJurnal;
use App\Models\Transaction;
use App\Models\Jurnal;
use App\Models\Customer;
use App\Models\SuratJalan;
use App\Models\Transaksi;
use App\Models\Invoice;
use Illuminate\Http\Request;
use DB;
class BukuBesarPembantuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $templates = TemplateJurnal::all();
    $nopol = Nopol::where('status', 'aktif')->get();
    $coa = Coa::where('status', 'aktif')->get();
    
    // Ambil semua customer
    $customers = Customer::all();

    // Menghitung debit dan kredit untuk setiap customer
    foreach ($customers as $customer) {
        // Ambil semua surat jalan untuk customer ini
        $suratJalan = SuratJalan::where('id_customer', $customer->id)->get();
    
        $debitTotal = 0;
        $kreditTotal = 0;

        foreach ($suratJalan as $sj) {
            // Ambil semua transaksi yang terkait dengan surat jalan
            $transaksi = Transaction::where('id_surat_jalan', $sj->id)->get();
    
            // Simpan ID invoice yang sudah dihitung untuk menghindari duplikasi
            $processedInvoices = [];

            foreach ($transaksi as $tr) {
                // Ambil semua invoice berdasarkan ID transaksi
                $invoices = Invoice::where('id_transaksi', $tr->id)->get();
    
                foreach ($invoices as $inv) {
                    // Cek apakah invoice sudah diproses
                    if (in_array($inv->invoice, $processedInvoices)) {
                        continue; // Lewati jika sudah diproses
                    }

                    // Ambil semua jurnal berdasarkan invoice
                    $jurnals = Jurnal::where('invoice', $inv->invoice)->get(); 

                    // Hitung total debit dan kredit dari jurnal
                    foreach ($jurnals as $j) {
                        // Pastikan untuk hanya menghitung yang tidak 0
                        if ($j->debit > 0 || $j->kredit > 0) {
                            \Log::info("Customer: {$customer->nama}, Jurnal ID: {$j->id}, Debit: {$j->debit}, Kredit: {$j->kredit}");
                           
                            $debitTotal += $j->debit;
                            $kreditTotal += $j->kredit;
                        }
                    }

                    // Tandai invoice ini sebagai sudah diproses
                    $processedInvoices[] = $inv->invoice;
                }
            }
        }
    
        // Set nilai debit dan kredit ke customer
        $customer->debit = $debitTotal;
        $customer->kredit = $kreditTotal;

        // Log total debit dan kredit setelah dihitung
        \Log::info("Customer: {$customer->nama}, Total Debit: {$debitTotal}, Total Kredit: {$kreditTotal}");
    }

    // Kirim data ke view
    return view('jurnal.buku-besar-pembantu', compact('customers', 'coa', 'templates', 'nopol'));
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
    public function show(BukuBesarPembantu $bukuBesarPembantu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BukuBesarPembantu $bukuBesarPembantu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BukuBesarPembantu $bukuBesarPembantu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BukuBesarPembantu $bukuBesarPembantu)
    {
        //
    }
}
