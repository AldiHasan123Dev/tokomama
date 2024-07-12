<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Barang;
use App\Models\Invoice;
use App\Models\NSFP;
use App\Models\SuratJalan;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KeuanganController extends Controller
{
    function index()
    {
        return redirect('keuangan.surat-jalan');
    }

    function suratJalan()
    {
        $masterBarangs = Barang::all();
        $no = SuratJalan::whereYear('created_at', date('Y'))->max('no') + 1;
        $roman_numerals = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // daftar angka Romawi
        $month_number = date("n", strtotime(date('Y-m-d'))); // mengambil nomor bulan dari tanggal
        $month_roman = $roman_numerals[$month_number];
        $nomor = sprintf('%03d', $no) . '/SJ/SB-' . $month_roman . '/' . date('Y');
        return view('keuangan.surat-jalan', compact('masterBarangs', 'nomor', 'no'));
    }

    function suratJalanStore(Request $request): RedirectResponse
    {
        SuratJalan::create($request->all());
        return redirect()->route('keuangan.pre-invoice');
    }

    function invoice()
    {
        return view('keuangan.invoice');
    }

    function preInvoice()
    {
        return view('keuangan.pre-invoice');
    }

    function invoiceDraf(SuratJalan $surat_jalan)
    {
        return view('keuangan.draf_invoice', compact('surat_jalan'));
    }

    public function submitInvoice(SuratJalan $surat_jalan)
    {
        $nsfp = NSFP::where('available', '1')->orderBy('nomor')->first();
        if (!$nsfp) {
            return back()->with('error', 'NSFP Belum Tersedia, pastikan nomor NSFP tersedia.');
        }
        $data['invoice'] = str_replace('/SJ/', '/INV/', $surat_jalan->nomor_surat);
        $data['tgl_invoice'] = date('Y-m-d');
        $data['id_nsfp'] = $nsfp->id;
        $data['ppn'] = floatval(request('total')) * 0.1;
        $data['subtotal'] = floatval(request('total'));
        $data['total'] = floatval(request('total')) + $data['ppn'];
        $surat_jalan->update($data);
        $nsfp->update(['available' => '0', 'invoice' => $data['invoice']]);
        return redirect()->route('keuangan.invoice.cetak', $surat_jalan);
    }

    public function cetakInvoice()
    {
        $invoice = request('invoice');
        $data = Invoice::where('invoice', request('invoice'))->get();
        $pdf = Pdf::loadView('keuangan/invoice_pdf', compact('data','invoice'))->setPaper('a4', 'landscape');
        return $pdf->stream('invoice_pdf.pdf');
    }

    function generatePDF($id)
    {
        $surat_jalan = SuratJalan::where('id', $id)->get();
        $pdf = Pdf::loadView('keuangan/invoice_pdf', compact('surat_jalan'))->setPaper('a4', 'landscape');
        return $pdf->stream('invoice_pdf.pdf');
    }

    public function dataTable()
    {
        // $query = Transaction::get();
        // $data = TransactionResource::collection($data);
        $data  = Invoice::get()->groupBy('invoice');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nsfp', function ($row) {
                return $row->first()->nsfp->nomor ?? '-';
            })
            ->addColumn('invoice', function ($row) {
                return $row->first()->invoice ?? '-';
            })
            ->addColumn('subtotal', function ($row) {
                return number_format($row->sum('subtotal'));
            })
            ->addColumn('ppn', function ($row) {
                return number_format($row->sum('subtotal') * 0.11);
            })
            ->addColumn('total', function ($row) {
                return number_format(($row->sum('subtotal') * 0.11) + $row->sum('subtotal'));
            })
            ->make();

        // $query = SuratJalan::query();
        // if (request('invoice')) {
        //     $query->whereNotNull('invoice');
        // }
        // $data = $query->orderBy('nomor_surat', 'desc');
        // return DataTables::of($data)
        //     ->addIndexColumn()
        //     ->addColumn('aksi', function ($row) {
        //         return '<div class="flex gap-3 mt-2">
        //                         <a target="_blank" href="' . route('surat-jalan.cetak', $row) . '" class="text-green-500 font-semibold mb-3 self-end"><i class="fa-solid fa-print mt-2"></i></a>
        //                         <button onclick="getData(' . $row->id . ', \'' . addslashes($row->invoice) . '\', \'' . addslashes($row->nomor_surat) . '\', \'' . addslashes($row->kepada) . '\', \'' . addslashes($row->jumlah) . '\', \'' . addslashes($row->satuan) . '\', \'' . addslashes($row->jenis_barang) . '\', \'' . addslashes($row->nama_kapal) . '\', \'' . addslashes($row->no_cont) . '\', \'' . addslashes($row->no_seal) . '\', \'' . addslashes($row->no_pol) . '\', \'' . addslashes($row->no_job) . '\')"   id="edit" class="text-yellow-400 font-semibold mb-3 self-end"><i class="fa-solid fa-pencil"></i></button>
        //                         <button onclick="deleteData(' . $row->id . ')"  id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end"><i class="fa-solid fa-trash"></i></button>
        //                     </div>';
        //     })
        //     ->rawColumns(['aksi'])
        //     ->make();
    }
}
