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

class JurnalManualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = TemplateJurnal::all();
        $nopol = Nopol::where('status', 'aktif')->get();
        $coa = Coa::where('status', 'aktif')->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $noJNL = Jurnal::where('tipe', 'JNL')->whereMonth('tgl', $currentMonth)->orderBy('no', 'desc')->first() ?? 0;
        $no_JNL =  $noJNL ? $noJNL->no + 1 : 1;
        $noBKK = Jurnal::where('tipe', 'BKK')->whereYear('tgl', $currentYear)->orderBy('no', 'desc')->first() ?? 0;
        $no_BKK = $noBKK ? $noBKK->no + 1 : 1;
        $noBKM = Jurnal::where('tipe', 'BKM')->whereYear('tgl', $currentYear)->orderBy('no', 'desc')->first() ?? 0;
        $no_BKM =  $noBKM ? $noBKM->no + 1 : 1;
        $noBBK = Jurnal::where('tipe', 'BBK')->whereYear('tgl', $currentYear)->orderBy('no', 'desc')->first() ?? 0;
        $no_BBK =  $noBBK ? $noBBK->no + 1 : 1;
        $noBBM = Jurnal::where('tipe', 'BBM')->whereYear('tgl', $currentYear)->orderBy('no', 'desc')->first() ?? 0;
        $no_BBM =  $noBBM ? $noBBM->no + 1 : 1;

        $invoices = Invoice::all();
        $processedInvoices = [];
        $invoiceCounts = [];
        foreach ($invoices as $invoice) {
            $invoiceNumber = $invoice->invoice;
            if (!isset($invoiceCounts[$invoiceNumber])) {
                $invoiceCounts[$invoiceNumber] = 0;
            }
            $invoiceCounts[$invoiceNumber]++;

            $processedInvoiceNumber = $invoiceNumber . '_' . $invoiceCounts[$invoiceNumber];
            $processedInvoices[] = $processedInvoiceNumber;
        }

        $transaksi = Transaction::whereNotNull('invoice_external')->get();
        $procTransactions = [];
        $transactionCounts = [];
        foreach ($transaksi as $transaction) {
            $invoiceNumber = $transaction->invoice_external;
            if (!isset($transactionCounts[$invoiceNumber])) {
                $transactionCounts[$invoiceNumber] = 0;
            }
            $transactionCounts[$invoiceNumber]++;

            $procTransactionNumber = $invoiceNumber . '_' . $transactionCounts[$invoiceNumber];
            $procTransactions[] = $procTransactionNumber;
        }

        // dd($procTransactions);
        return view('jurnal.jurnal-manual', compact('templates', 'nopol', 'coa', 'no_JNL', 'no_BKK', 'no_BKM', 'no_BBK', 'no_BBM', 'invoices', 'processedInvoices', 'procTransactions', 'transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = TemplateJurnal::get();
        $coa = Coa::where('status', 'aktif')->get();
        $nopol = Nopol::where('status', 'aktif')->get();
        return view('jurnal.jurnal-manual', compact('templates', 'coa', 'nopol'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nomor = $request->tipe;
        $data_nomor = explode('/', $request->tipe)[1];
        $tipe = explode('-', $data_nomor)[0];
        $noCounter = explode('-', $nomor)[1];
        $no = str_replace(' ', '', explode('/', $noCounter)[0]);

        $tgl = $request->tanggal_jurnal;
        $bulan = date('m', strtotime($tgl));
        $bulanNow = date('m');

        //pemecahan nomor jurnal
        $jurnalsort = Jurnal::whereMonth('tgl', $bulan)->where('tipe', 'JNL')->get();
        $nomorArray = $jurnalsort->pluck('no')->toArray();
        if ($nomorArray == []) {
            $nomorArray = [0];
        }
        $maxNomor = max($nomorArray); // max nmor pada bulan yang diinputkan user

        // penggabungan nomor jurnal untuk kondisi jurnal yang diinputkan bulannya tidak sama dengan bulan sekarang
        $breakdown = explode('/', $request->tipe);
        $sec2 = $breakdown[1];
        $sec3 = $breakdown[2];
        $title = str_replace(' ', '', explode('-', $breakdown[0])[0]);
        $newNoJurnal = $title . ' - ' . $maxNomor + 1 . '/' . $sec2 . '/' . $sec3;

        $keteranganList = [];

        for ($i = 0; $i < $request->counter; $i++) {
            $keterangan = $request->keterangan[$i];
            if (str_contains($request->keterangan[$i], '[1]')) {
                $keterangan = str_replace('[1]', $request->param1[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[2]')) {
                $keterangan = str_replace('[2]', $request->param2[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[3]')) {
                $keterangan = str_replace('[3]', $request->param3[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[4]')) {
                $keterangan = str_replace('[4]', $request->param4[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[5]')) {
                $keterangan = str_replace('[5]', $request->param5[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[6]')) {
                $keterangan = str_replace('[6]', $request->param6[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[7]')) {
                $keterangan = str_replace('[7]', $request->param7[$i], $keterangan);
            }
            if (str_contains($request->keterangan[$i], '[8]')) {
                $keterangan = str_replace('[8]', $request->param8[$i], $keterangan);
            }

            $keteranganList[$i] = $keterangan;
        }

        for ($i = 0; $i < $request->counter; $i++) {
            if ($request->check[$i] == 1) {
                if ($tipe == 'JNL') {
                    if ($bulan < $bulanNow) {
                        DB::transaction(
                            function () use ($request, $i, $tipe, $keteranganList, $maxNomor, $newNoJurnal) {
                                if ($request->akun_debet[$i] != 0) {
                                    Jurnal::create([
                                        'coa_id' => $request->akun_debet[$i],
                                        'nomor' => $newNoJurnal,
                                        'tgl' => $request->tanggal_jurnal,
                                        'keterangan' => $keteranganList[$i],
                                        'debit' => $request->nominal[$i],
                                        'invoice' => $request->invoice ? explode('_', $request->invoice[$i])[0] : null,
                                        'invoice_external' => $request->invoice_external ? explode('_', $request->invoice_external[$i])[0] : null,
                                        'nopol' => $request->nopol[$i] ?? null,
                                        'tipe' => $tipe,
                                        'no' => $maxNomor + 1
                                    ]);
                                }

                                if ($request->akun_kredit[$i] != 0) {
                                    Jurnal::create([
                                        'coa_id' => $request->akun_kredit[$i],
                                        'nomor' => $newNoJurnal,
                                        'tgl' => $request->tanggal_jurnal,
                                        'keterangan' => $keteranganList[$i],
                                        'kredit' => $request->nominal[$i],
                                        'invoice' => $request->invoice ? explode('_', $request->invoice[$i])[0] : null,
                                        'invoice_external' => $request->invoice_external ? explode('_', $request->invoice_external[$i])[0] : null,
                                        'nopol' => $request->nopol[$i] ?? null,
                                        'tipe' => $tipe,
                                        'no' => $maxNomor + 1
                                    ]);
                                }
                            }
                        );
                    } else {
                        DB::transaction(
                            function () use ($request, $i, $nomor, $tipe, $no, $keteranganList) {
                                if ($request->akun_debet[$i] != 0) {
                                    Jurnal::create([
                                        'coa_id' => $request->akun_debet[$i],
                                        'nomor' => $nomor,
                                        'tgl' => $request->tanggal_jurnal,
                                        'keterangan' => $keteranganList[$i],
                                        'debit' => $request->nominal[$i],
                                        'invoice' => $request->invoice ? explode('_', $request->invoice[$i])[0] : null,
                                        'invoice_external' => $request->invoice_external ? explode('_', $request->invoice_external[$i])[0] : null,
                                        'nopol' => $request->nopol[$i] ?? null,
                                        'tipe' => $tipe,
                                        'no' => $no
                                    ]);
                                }

                                if ($request->akun_kredit[$i] != 0) {
                                    Jurnal::create([
                                        'coa_id' => $request->akun_kredit[$i],
                                        'nomor' => $nomor,
                                        'tgl' => $request->tanggal_jurnal,
                                        'keterangan' => $keteranganList[$i],
                                        'kredit' => $request->nominal[$i],
                                        'invoice' => $request->invoice ? explode('_', $request->invoice[$i])[0] : null,
                                        'invoice_external' => $request->invoice_external ? explode('_', $request->invoice_external[$i])[0] : null,
                                        'nopol' => $request->nopol[$i] ?? null,
                                        'tipe' => $tipe,
                                        'no' => $no
                                    ]);
                                }
                            }

                        );
                    }
                } else {
                    DB::transaction(
                        function () use ($request, $i, $nomor, $tipe, $no, $keteranganList) {
                            if ($request->akun_debet[$i] != 0) {
                                Jurnal::create([
                                    'coa_id' => $request->akun_debet[$i],
                                    'nomor' => $nomor,
                                    'tgl' => $request->tanggal_jurnal,
                                    'keterangan' => $keteranganList[$i],
                                    'debit' => $request->nominal[$i],
                                    'invoice' => $request->invoice ? explode('_', $request->invoice[$i])[0] : null,
                                    'invoice_external' => $request->invoice_external ? explode('_', $request->invoice_external[$i])[0] : null,
                                    'nopol' => $request->nopol[$i] ?? null,
                                    'tipe' => $tipe,
                                    'no' => $no
                                ]);
                            }

                            if ($request->akun_kredit[$i] != 0) {
                                Jurnal::create([
                                    'coa_id' => $request->akun_kredit[$i],
                                    'nomor' => $nomor,
                                    'tgl' => $request->tanggal_jurnal,
                                    'keterangan' => $keteranganList[$i],
                                    'kredit' => $request->nominal[$i],
                                    'invoice' => $request->invoice ? explode('_', $request->invoice[$i])[0] : null,
                                    'invoice_external' => $request->invoice_external ? explode('_', $request->invoice_external[$i])[0] : null,
                                    'nopol' => $request->nopol[$i] ?? null,
                                    'tipe' => $tipe,
                                    'no' => $no
                                ]);
                            }
                        }

                    );
                }
            }
        }

        return redirect()->route('jurnal.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }

    public function getInvoiceWhereNoInv()
    {
        // dd(request('invoice'));
        $invoices = Invoice::with([
            'transaksi.suppliers',
            'transaksi.barang',
            'transaksi.suratJalan.customer',
        ])
            ->where('invoice', request('invoice'))
            ->get();

        $dataCust = [];
        $dataSup = [];
        $dataBar = [];
        $dataQty = [];
        $dataSat = [];
        $dataHarsBel = [];
        $dataHarsJul = [];
        $dataKet = [];

        if ($invoices->isNotEmpty()) {
            foreach ($invoices as $invoice) {
                $dataCust[] = $invoice->transaksi->suratJalan->customer->nama;
                $dataSup[] = $invoice->transaksi->suppliers->nama;
                $dataBar[] = $invoice->transaksi->barang->nama;
                $dataQty[] = $invoice->transaksi->jumlah_jual;
                $dataSat[] = $invoice->transaksi->satuan_jual;
                $dataHarsBel[] = $invoice->transaksi->harga_beli;
                $dataHarsJul[] = $invoice->transaksi->harga_jual;
                $dataKet[] = $invoice->transaksi->keterangan;
            }
        } else {
            return response()->json(['error' => 'No invoices found'], 404);
        }

        // dd($suratJalans);

        return response()->json([
            'customer' => $dataCust,
            'supplier' => $dataSup,
            'barang' => $dataBar,
            'quantity' => $dataQty,
            'satuan' => $dataSat,
            'harsat_beli' => $dataHarsBel,
            'harsat_jual' => $dataHarsJul,
            'keterangan' => $dataKet
        ]);
    }

    public function getInvoiceWhereNoInvExt()
    {
        // dd(request('invoice_ext'));
        $invoiceExt = Transaction::where('invoice_external', request('invoice_ext'))
            ->with(['suratJalan.customer', 'barang', 'suppliers'])
            ->get();

        $dataCust = [];
        $dataSup = [];
        $dataBar = [];
        $dataQty = [];
        $dataSat = [];
        $dataHarsBel = [];
        $dataHarsJul = [];
        $dataKet = [];

        if ($invoiceExt->isNotEmpty()) {
            foreach ($invoiceExt as $item) {
                $dataCust[] = $item->suratJalan->customer->nama;
                $dataSup[] = $item->suppliers->nama;
                $dataBar[] = $item->barang->nama;
                $dataQty[] = $item->jumlah_jual;
                $dataSat[] = $item->satuan_jual;
                $dataHarsBel[] = $item->harga_beli;
                $dataHarsJul[] = $item->harga_jual;
                $dataKet[] = $item->keterangan;
            }
        } else {
            return response()->json(['error' => 'No invoices found'], 404);
        }

        return response()->json([
            'customer' => $dataCust,
            'supplier' => $dataSup,
            'barang' => $dataBar,
            'quantity' => $dataQty,
            'satuan' => $dataSat,
            'harsat_beli' => $dataHarsBel,
            'harsat_jual' => $dataHarsJul,
            'keterangan' => $dataKet
        ]);
    }
}
