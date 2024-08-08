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
use Carbon\Carbon;
class BukuBesarPembantuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $templates = TemplateJurnal::all();
    $nopol = Nopol::where('status', 'aktif')->get();
    $coa = Coa::where('status', 'aktif')->get();

    // Get selected month and year or use current month and year as default
    $selectedYear = $request->input('year', date('Y'));
    $selectedMonth = $request->input('month', date('m'));
    
    // Get selected coa_id or use default coa_id 63
    $selectedCoaId = $request->input('coa_id', 63);

    // Set start date to January 2023
    $startDate = '2023-01-01';
    // Set end date based on selected month and year
    $endDate = Carbon::create($selectedYear, $selectedMonth)->endOfMonth()->toDateString();

    // Get all customers
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
                        ->where('coa_id', $selectedCoaId) // Filter by coa_id
                        ->whereBetween('tgl', [$startDate, $endDate]) // Filter by date
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

    return view('jurnal.buku-besar-pembantu', compact('customers', 'coa', 'templates', 'nopol', 'selectedYear', 'selectedMonth', 'selectedCoaId'));
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
