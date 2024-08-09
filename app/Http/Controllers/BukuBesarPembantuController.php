<?php

namespace App\Http\Controllers;

use App\Models\BukuBesarPembantu;
use App\Models\Coa;
use App\Models\Nopol;
use App\Models\TemplateJurnal;
use App\Models\Transaction;
use App\Models\Jurnal;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\SuratJalan;
use App\Models\Transaksi;
use App\Models\Invoice;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BukuBesarPembantuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Ambil data COA yang aktif
    $coa = Coa::where('status', 'aktif')->get();

    // Dapatkan tahun dan bulan yang dipilih
    $selectedYear = $request->input('year', date('Y'));
    $selectedMonth = $request->input('month', date('m'));
    $selectedCoaId = $request->input('coa_id', 8);
    $selectedState = $request->input('state', 'customer'); // Dapatkan state (customer/supplier)
  
   
    // Rentang tanggal
    $startDate = '2023-01-01';
    $endDate = Carbon::create($selectedYear, $selectedMonth)->endOfMonth()->toDateString();

    // Inisialisasi variabel untuk customer dan supplier
    $customers = [];
    $suppliers = [];

    // Logika untuk pelanggan (customers)
    if ($selectedState == 'customer') {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            $suratJalan = SuratJalan::where('id_customer', $customer->id)->get();

            $debitTotal = 0;
            $kreditTotal = 0;

            foreach ($suratJalan as $sj) {
                $transaksi = Transaction::where('id_surat_jalan', $sj->id)->get();
                $processedInvoices = [];

                foreach ($transaksi as $tr) {
                    $invoices = Invoice::where('id_transaksi', $tr->id)->get();

                    foreach ($invoices as $inv) {
                        if (in_array($inv->invoice, $processedInvoices)) {
                            continue;
                        }

                        $jurnals = Jurnal::where('invoice', $inv->invoice)
                            ->where('coa_id', $selectedCoaId)
                            ->whereBetween('tgl', [$startDate, $endDate])
                            ->get();

                        foreach ($jurnals as $j) {
                            if ($j->debit > 0 || $j->kredit > 0) {
                                $debitTotal += $j->debit;
                                $kreditTotal += $j->kredit;
                            }
                        }

                        $processedInvoices[] = $inv->invoice;
                    }
                }
            }

            $customer->debit = $debitTotal;
            $customer->kredit = $kreditTotal;
        }
    }

    // Logika untuk pemasok (suppliers)
    if ($selectedState == 'supplier') {
        $suppliers = Supplier::all();
    
        foreach ($suppliers as $supplier) {
            $debitTotal = 0;
            $kreditTotal = 0;
    
            // Ambil semua jurnal untuk supplier berdasarkan invoice_external
            $jurnals = Jurnal::where('coa_id', $selectedCoaId)
                ->whereBetween('tgl', [$startDate, $endDate])
                ->whereNotNull('invoice_external') // Menambahkan kondisi ini
                ->get();
    
            foreach ($jurnals as $j) {
                $transaksi = Transaction::where('invoice_external', $j->invoice_external)
                    ->where('id_supplier', $supplier->id)
                    ->first();
    
                if ($transaksi && ($j->debit > 0 || $j->kredit > 0)) {
                  
                    $debitTotal += $j->debit;
                    $kreditTotal += $j->kredit;
                }
            }
    
            $supplier->debit = $debitTotal;
            $supplier->kredit = $kreditTotal;
        }
    }
    

    // Tentukan tipe (tipe) untuk perhitungan saldo
    $akun = Coa::where('id', $selectedCoaId)
        ->orWhere('no_akun', $selectedCoaId)
        ->get();
    
    $tipe = 'D';
    foreach ($akun as $item) {
        if (in_array(substr($item->no_akun, 0, 1), ['2', '3', '5'])) {
            $tipe = 'K';
        }
    }

    return view('jurnal.buku-besar-pembantu', compact('customers', 'suppliers', 'coa', 'selectedYear', 'selectedMonth', 'selectedCoaId', 'tipe', 'selectedState'));
}




public function showDetail($id, Request $request)
{
    $selectedYear = $request->input('year', date('Y'));
    $selectedMonth = $request->input('month', date('m'));
    $selectedCoaId = $request->input('coa_id', 8);
    $selectedState = $request->input('state', 'customer'); 

    $startDate = '2023-01-01';
    $endDate = Carbon::create($selectedYear, $selectedMonth)->endOfMonth()->toDateString();
    
    $suratJalan = SuratJalan::where('id_customer', $id)->get();

    $details = [];
    $coa = Coa::findOrFail($selectedCoaId);
    $totalDebit = 0;
    $totalKredit = 0;

    if ($selectedState == 'customer') {
        $entity = Customer::findOrFail($id);
        $suratJalan = SuratJalan::where('id_customer', $id)->get();

        foreach ($suratJalan as $sj) {
            $transaksi = Transaction::where('id_surat_jalan', $sj->id)->get();
            $processedInvoices = [];

            foreach ($transaksi as $tr) {
                $invoices = Invoice::where('id_transaksi', $tr->id)->get();

                foreach ($invoices as $inv) {
                    if (in_array($inv->invoice, $processedInvoices)) {
                        continue;
                    }

                    $jurnals = Jurnal::where('invoice', $inv->invoice)
                        ->where('coa_id', $selectedCoaId)
                        ->whereBetween('tgl', [$startDate, $endDate])
                        ->get();

                    foreach ($jurnals as $j) {
                        if ($j->debit > 0 || $j->kredit > 0) {
                            $details[] = [
                                'tgl' => $j->tgl,
                                'invoice' => $inv->invoice,
                                'debit' => $j->debit,
                                'kredit' => $j->kredit,
                                'keterangan' => $j->keterangan // Menambahkan keterangan
                            ];
                            $totalDebit += $j->debit;
                            $totalKredit += $j->kredit;
                        }
                    }

                    $processedInvoices[] = $inv->invoice;
                }
            }
        }
        $entityName = $entity->nama;
    } elseif ($selectedState == 'supplier') {
        $entity = Supplier::findOrFail($id);

        $jurnals = Jurnal::where('coa_id', $selectedCoaId)
            ->whereBetween('tgl', [$startDate, $endDate])
            ->whereNotNull('invoice_external')
            ->get();

        foreach ($jurnals as $j) {
            $transaksi = Transaction::where('invoice_external', $j->invoice_external)
                ->where('id_supplier', $entity->id)
                ->first();

            if ($transaksi && ($j->debit > 0 || $j->kredit > 0)) {
                $details[] = [
                    'tgl' => $j->tgl,
                    'invoice_external' => $j->invoice_external,
                    'debit' => $j->debit,
                    'kredit' => $j->kredit,
                    'keterangan' => $j->keterangan // Menambahkan keterangan
                ];
                $totalDebit += $j->debit;
                $totalKredit += $j->kredit;
            }
        }
        $entityName = $entity->nama;
    }

    // Calculate balance (saldo)
    $view_total = ($coa->tipe == 'K') ? $totalKredit - $totalDebit : $totalDebit - $totalKredit;

    return response()->json([
        'entity' => $entity,
        'details' => $details,
        'coa' => $coa,
        'totalDebit' => $totalDebit,
        'totalKredit' => $totalKredit,
        'view_total' => $view_total, // Pass view_total to the view
        'entityName' => $entityName
    ]);
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
