<?php

namespace App\Exports;

use App\Http\Resources\SuratJalanResource;
use App\Models\Invoice;
use App\Models\SuratJalan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPpnExport implements FromView
{
    private $start;
    private $end;
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        $invoices = Invoice::whereBetween("tgl_invoice", [$this->start, $this->end])->groupBy('invoice')->get();
        // $invoices_of = Invoice::whereBetween("tgl_invoice", [$this->start, $this->end])->groupBy('invoice')->groupBy('id_transaksi')->get();
        // dd($invoices);
        return view('export.laporan-ppn', compact('invoices'));
        // return SuratJalan::all();
    }
}
