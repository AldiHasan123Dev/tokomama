<?php

namespace App\Exports;

use App\Http\Resources\SuratJalanResource;
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
        $surat_jalan = SuratJalan::whereBetween('tgl_invoice', [$this->start, $this->end])->orderBy('tgl_invoice')->get();
        // dd($surat_jalan);
        return view('export.laporan-ppn', compact('surat_jalan'));
        // return SuratJalan::all();
    }
}
