<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NSFP;
use App\Models\SuratJalan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class InvoiceController extends Controller
{
    public function dataTable()
    {
        $data = SuratJalan::query()->whereNull('invoice');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<form method=' . 'GET' . ' action = ' . route('keuangan.invoice.draf', $row) . '><button class="btn btn-xs btn-success" type=submit>Ambil</button></form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function ambil(Request $request)
    {

        $suratJalan = SuratJalan::find($request->id);
        // $suratJalan->status = 'tarik';

        // // mengubah nomor surat jalan menjadi nomor invoice
        // $nomor = str_replace(' ', '', $suratJalan->nomor_surat);
        // $noExplode = explode('/', $nomor);
        // $one = $noExplode[0];
        // $two = str_replace('SJ', 'INV', $noExplode[1]);
        // $three = str_replace('-', '/', $noExplode[2]);
        // $four = $noExplode[3];
        // $nomorInvoice = $one . '/' . $two . '/' . $three . '/' . $four;
        // $suratJalan->invoice = $nomorInvoice;

        // //tanggal current
        // $suratJalan->tgl_invoice = Carbon::now();

        // // update table nsfp
        // $nsfp = NSFP::where('available', '1')->first();
        // $nsfp->invoice = $nomorInvoice;
        // $nsfp->available = 0;
        // // dd($nsfp);

        // // save
        // $suratJalan->save();
        // $nsfp->save();

        return redirect()->route('keuangan.invoice');
    }
}
