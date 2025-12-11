<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Invoice;
use App\Models\BiayaInv;
use App\Models\Jurnal;
use App\Models\Nopol;
use App\Models\Supplier;
use App\Models\SuratJalan;
use App\Models\TemplateJurnal;
use App\Models\TipeJurnal;
use App\Models\Barang;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JurnalALLExport;
use Yajra\DataTables\Facades\DataTables;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
    
        $query = Jurnal::join('coa', 'jurnal.coa_id', '=', 'coa.id')
        ->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')
        ->whereMonth('tgl', $month)
        ->whereYear('tgl', $year)
        ->when($request->filled('tipe'), fn($q) => $q->where('tipe', $request->tipe))
        ->when($request->query('kas') === 'kas', fn($q) => $q->whereIn('tipe', ['BKM', 'BKK']))
        ->when($request->query('bank') === 'bank', fn($q) => $q->whereIn('tipe', ['BBK', 'BBM','BBKN','BBMN']))
        ->when($request->query('ocbc') === 'ocbc', fn($q) => $q->whereIn('tipe', ['BBKO', 'BBMO']))
        ->orderByRaw("jurnal.no DESC, jurnal.id ASC, jurnal.created_at DESC, jurnal.tgl DESC");
    
    
        // Eksekusi query utama
        $data = $query->get();
    
        // Ambil data jurnal untuk bulan & tahun yang dipilih
        $MonJNL = Jurnal::join('coa', 'jurnal.coa_id', '=', 'coa.id')
            ->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun');
    
        if ($request->has(['month', 'year'])) {
            $MonJNL->whereMonth('tgl', $request->input('month'))
                ->whereYear('tgl', $request->input('year'));
        }
    
        $MonJNL = $MonJNL->get();
    
        // Hitung saldo debit dan kredit
        $balance = Jurnal::select(
            'nomor',
            DB::raw('SUM(debit) as total_debit'),
            DB::raw('SUM(kredit) as total_kredit')
        )
        ->whereYear('tgl', $request->input('year', date('Y')))
        ->groupBy('nomor')
        ->get();
    
        // Ambil jurnal terakhir yang berjenis 'JNL' hanya jika ada filter bulan & tahun
        $LastJNL = collect(); // Default kosong
    
        if ($request->has(['month', 'year'])) {
            $LastJNL = Jurnal::where('tipe', 'JNL')
                ->whereMonth('tgl', $request->input('month'))
                ->whereYear('tgl', $request->input('year'))
                ->join('coa', 'jurnal.coa_id', '=', 'coa.id')
                ->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')
                ->get();
        }
    
        // Cek jurnal yang tidak balance
        $notBalance = [];
    
        foreach ($balance as $b) {
            if ($b->total_debit != $b->total_kredit) {
                $notBalance[] = $b->nomor;
            }
        }
    
        // Return ke view
        return view('jurnal.jurnal', compact('data', 'MonJNL', 'notBalance', 'LastJNL'));
    }

   public function listKodeJurnal(Request $request)
{
    $month = $request->month_is ?? date('m');
    $kredit = $request->kredit_is;
    $debit = $request->debit_is;
    $coa = $request->coa_id ?? 5;
    $coa = (int)$coa;
    $year  = $request->year_is ?? date('Y');
    $type  = $request->tipe ?? 'bank';
    $query = Jurnal::query()
        ->select(
            'jurnal.id',
            'jurnal.kode',
            'jurnal.tgl',
            'jurnal.nomor',
            'jurnal.invoice_external',
            'jurnal.invoice',
            'jurnal.container',
            'jurnal.keterangan',
            'jurnal.debit',
            'jurnal.kredit',

            // --- ambil coa_id
            'jurnal.coa_id',

            // --- ambil nama coa & nomor akun pakai AS
            'coa.nama_akun as nama_akun',
            'coa.no_akun as coa_no_akun'
        )
        ->leftJoin('coa', 'coa.id', '=', 'jurnal.coa_id');



    // Filter tipe jurnal
    if (!empty($type)) {
        if ($type === 'kas') {
            $query->whereIn('tipe', ['BKM', 'BKK']);
        } elseif ($type === 'bank') {
            $query->whereIn('tipe', ['BBK', 'BBM', 'BBKN', 'BBMN']);
        } elseif ($type === 'ocbc') {
            $query->whereIn('tipe', ['BBKO', 'BBMO']);
        } else {
            $query->where('tipe', $type);
        }

        // Filter bulan & tahun hanya jika tipe dipilih
        if (!empty($month)) {
            $query->whereMonth('tgl', $month);
        }
        if (!empty($year)) {
            $query->whereYear('tgl', $year);
        }
        if (!empty($debit)) {
            $query->where('debit', '>', 0);
        }
        if (!empty($kredit)) {
            $query->where('kredit', '>', 0);
        }
         if (!empty($coa)) {
            $query->where('coa_id', $coa);
        }
    }

    $query->orderBy('tgl', 'DESC');


    // --- PAGINATION SESUAI jqGrid --- //
    $page   = $request->page ?? 1;
    $limit  = $request->rows ?? 500;

    $count  = $query->count();
    $totalPages = ($count > 0) ? ceil($count / $limit) : 1;

    if ($page > $totalPages) {
        $page = $totalPages;
    }

    $start = ($page - 1) * $limit;
    if ($start < 0) $start = 0;

    $rows = $query->skip($start)->take($limit)->get();

    return response()->json([
        'page'    => $page,
        'total'   => $totalPages,
        'records' => $count,
        'rows'    => $rows
    ]);
}



    public function code(){
        $now = Carbon::now()->addMonths(1)->format('Y-m-d');
        $last = Carbon::now()->subMonths(3)->format('Y-m-d');

        $cacheKey = 'jurnal_unbalance_' . $last . '_' . $now;

        $month = request('month') ?? date('m');
        $year = request('year') ?? date('Y');
        return view('jurnal.jurnal-code', compact('month', 'year'));
    }

        public function simpanKode(Request $request)
    {
        $data = $request->input('data');
        foreach ($data as $row) {
            DB::table('jurnal')
                ->where('id', $row['id'])
                ->update(['kode' => $row['kode']]); // pastikan kolom 'kode' ada
        }

        return response()->json(['status' => 'success']);
    }
    

        public function balik()
    {
        $coa = Coa::where('status', 'aktif')->orderBy('no_akun')->get();
        $journals = Jurnal::select('kode', \DB::raw('MAX(id) AS id'))
        ->whereIn('kode', function($query) {
            $query->select(\DB::raw('DISTINCT kode'))
                ->from('jurnal')
                ->whereNotNull('kode');
        })
        ->whereNull('jurnal_balik')
        ->groupBy('kode')
        ->orderBy('kode')
        ->get();
        $no = Jurnal::where('tipe', 'BKK')->whereYear('tgl',date('Y'))->orderBy('no', 'desc')->first() ?? 0;
        $no =  $no ? $no->no + 1 : 1;
        $nomor = $no .'/BKK-TM' . '/' . date('Y');

        return view('jurnal.jurnal-balik', 
        compact('coa','journals','nomor','no')
    );
    }

   
        public function prosesJurnalBalik(Request $r)
    {
        $dataToInsert = [];
        $no  = $r->no;
        $nomor = $r->nomor;
        $new_ket = $r->new_keterengan ?? "";
        $jurnal = $r->jurnal;
        $coa_tujuan_d = $r->tujuan_debit;
        $coa_tujuan_k = $r->tujuan_credit;
        $coa_awal_d = $r->awal_debit;
        $coa_awal_k = $r->awal_credit;
        $kode = $r->kode;

        $new_coa = $coa_tujuan_d ?? $coa_tujuan_k;
        $total = 0;

    $lastJurnalLama = null; // untuk menyimpan jurnal lama terakhir

foreach ($jurnal as $item) {

    $id = $item['id'];

    // Ambil jurnal lama jika ID ada
    $jurnalLama = ($id !== null) ? Jurnal::find($id) : null;

    // ============================
    // 1. Jika ID NULL → jurnal baru
    // ============================
    if ($id === null) {

        // Gunakan Jurnal Lama Terakhir
        if ($lastJurnalLama) {
            $dataToInsert[] = [
                'coa_id'     => $new_coa,
                'tgl'        => now()->toDateString(),
                'debit'      => $item['debit'],
                'kredit'     => $item['kredit'],
                // ambil dari jurnalLama terakhir
                'invoice'           => $lastJurnalLama->invoice,
                'invoice_external'  => $lastJurnalLama->invoice_external,
                'jurnal_balik'      => $lastJurnalLama->id,
                'kode'              => $lastJurnalLama->kode,
                'nopol'      => $lastJurnalLama->nopol,
                'container'  => $lastJurnalLama->container,
                'keterangan' => $new_ket,
                'no'         => $no,
                'nomor'      => $nomor,
                'keterangan_buku_besar_pembantu' => $nomor,
                'tipe'       => $r->tipe,
            ];
        }

        continue;
    }

    // Jika sampai sini berarti ID ADA → simpan sebagai last jurnal lama
    $lastJurnalLama = $jurnalLama;

    // ============================
    // Hitung total
    // ============================
    $total += $coa_awal_d
        ? $jurnalLama->debit
        : $jurnalLama->kredit;

    // ============================
    // 2. Tambah jurnal balik
    // ============================
    if ($coa_tujuan_k) {
        $dataToInsert[] = [
            'coa_id'     => $jurnalLama->coa_id,
            'tgl'        => now()->toDateString(),
            'kredit'     => $jurnalLama->debit,
            'debit'      => $jurnalLama->kredit,
            'invoice'    => $jurnalLama->invoice,
            'invoice_external'  => $jurnalLama->invoice_external,
            'jurnal_balik' => $jurnalLama->id,
            'kode'       => $jurnalLama->kode,
            'keterangan' => $jurnalLama->keterangan,
            'no'         => $no,
            'nomor'      => $nomor,
            'nopol'      => $jurnalLama->nopol,
            'container'  => $jurnalLama->container,
            'keterangan_buku_besar_pembantu' => $nomor,
            'tipe'       => $r->tipe,
        ];
    } else {
        $dataToInsert[] = [
            'coa_id'     => $jurnalLama->coa_id,
            'tgl'        => now()->toDateString(),
            'kredit'     => $jurnalLama->debit,
            'debit'      => $jurnalLama->kredit,
            'invoice'    => $jurnalLama->invoice,
            'invoice_external'  => $jurnalLama->invoice_external,
            'jurnal_balik' => $jurnalLama->id,
            'kode'       => $jurnalLama->kode,
            'keterangan' => $jurnalLama->keterangan,
            'no'         => $no,
            'nomor'      => $nomor,
            'nopol'      => $jurnalLama->nopol,
            'container'  => $jurnalLama->container,
            'keterangan_buku_besar_pembantu' => $nomor,
            'tipe'       => $r->tipe,
        ];
    }
}


    DB::beginTransaction();

    try {
        // Step 1: Insert data secara bertahap (hindari limit MySQL)
        foreach (array_chunk($dataToInsert, 50) as $batch) {
            Jurnal::insert($batch);
        }

        // Step 2: Ambil ulang data yang baru dimasukkan
        $insertedJurnal = Jurnal::where('nomor', $request->nomor ?? $nomor)
                                ->whereNotNull('jurnal_balik')
                                ->orderBy('id', 'asc')
                                ->get();

        if ($insertedJurnal->count() !== count($dataToInsert)) {
            throw new \Exception('Jumlah data yang dimasukkan tidak sesuai.');
        }

        // Step 3: Update jurnal lama dengan referensi balik
        foreach ($insertedJurnal as $index => $j) {
            $original = $dataToInsert[$index];
            if (!empty($original['jurnal_balik'])) {
                Jurnal::where('id', $original['jurnal_balik'])
                      ->update(['jurnal_balik' => $j->id]);
            }
        }

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Gagal menyimpan jurnal balik', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

       
    }

        // ✔ PROSES BARIS TERAKHIR (INDEX TERAKHIR ARRAY)

        return response()->json([
            'status' => 'success',
            'msg' => 'Data diterima',
            'coa_id_kredit' => $coa_tujuan_k,
            'coa_id_debit' => $coa_tujuan_d,
            'no' => $no,
            'nomor' => $nomor,
            'jumlah_data' => count($jurnal),
            'data' => $dataToInsert
        ]);
    }



public function JurnalBalikcari(Request $req)
{
    $q = Jurnal::query()
        ->leftJoin('coa', 'jurnal.coa_id', '=', 'coa.id')
        ->whereNull('jurnal_balik')
        ->select(
            'jurnal.*',
            'coa.no_akun',
            'coa.nama_akun'
        );
    $coa_tujuan = Coa::find($req->coa4 ?? $req->coa3);

    if ($req->tanggal_awal && $req->tanggal_akhir) {
        $q->whereBetween('jurnal.tgl', [$req->tanggal_awal, $req->tanggal_akhir]);
    }

    if ($req->kode) {
        $q->where('jurnal.kode', $req->kode);
    }

    if ($req->coa1) {
        $q->where('jurnal.coa_id', $req->coa1);
    }

    if ($req->coa2) {
        $q->where('jurnal.coa_id', $req->coa2);
    }

    // ==== CLONE QUERY UNTUK HITUNG SUM ====
    $sumQuery = clone $q;

    // === DAPATKAN DATA DETAIL ===
    $data = $q->orderBy('jurnal.tgl')->get()->map(function ($item,$coa_tujuan) {
        return [
            'id'               => $item->id,
            'nomor'            => $item->nomor,
            'tgl'              => $item->tgl,
            'kode'             => $item->kode,
            'invoice'          => $item->invoice,
            'invoice_external' => $item->invoice_external,
            'keterangan'       => $item->keterangan,
            'debit'            => number_format($item->debit, 0, ',', '.'),
            'kredit'           => number_format($item->kredit, 0, ',', '.'),
            'coa_id'           => $item->coa_id,
            'akun'             => $item->no_akun . ' - ' . $item->nama_akun,
        ];
    });

    // === SUM DARI DATABASE ===
    $sumDebit  = $sumQuery->sum('jurnal.debit');
    $sumKredit = $sumQuery->sum('jurnal.kredit');
    $totalRecord = $sumQuery->count();

    return response()->json([
        'data'         => $data,
        'sum_debit'    => $sumDebit,
        'sum_kredit'   => $sumKredit,
        'total_record' => $totalRecord
    ]);
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // dd($_GET['tipe']);
        // dd($data[0]->nomor);
        $nomor = $_GET['nomor'];
        // dd($nomor);
        $jurnal = Jurnal::where('nomor', $nomor) ->orderBy('id', 'desc')->first();
        $tgl = $jurnal->tgl;
        $data = Jurnal::where('nomor', $nomor)->join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun') ->orderBy('id', 'asc')->get();
        $coa = Coa::where('status', 'aktif')->get();
        $nopol = Nopol::where('status', 'aktif')->get();
        $jurnals = Jurnal::select('keterangan_buku_besar_pembantu') // Tambahkan 'id' ke dalam select
        ->whereNotNull('keterangan_buku_besar_pembantu')
        ->distinct()
        ->orderBy('id', 'desc')
        ->get();

    
        $id_jurnals = Jurnal::select('id') // Tambahkan 'id' ke dalam select
        ->orderBy('id', 'desc')
        ->get(); // Mengambil koleksi ID
        $latestId = $id_jurnals->pluck('id')->first(); // Mengambil ID terbaru (karena data sudah diurutkan desc)
    
        $cekVoucher = Jurnal::where('nomor', $nomor)->whereIn('coa_id', [2, 5, 6])->get();
        $cekVoucher_d = $cekVoucher->pluck('debit');
        $cekVoucher_k = $cekVoucher->pluck('kredit');



        // dd($jurnals);

        $invoices = Invoice::all();
        $invProc = [];
        $invoiceCounts = [];
        foreach ($invoices as $invoice) {
            $invoiceNumber = $invoice->invoice;
            if (!isset($invoiceCounts[$invoiceNumber])) {
                $invoiceCounts[$invoiceNumber] = 0;
            }
            $invoiceCounts[$invoiceNumber]++;

            $processedInvoiceNumber = $invoiceNumber . '_' . $invoiceCounts[$invoiceNumber];
            $invProc[] = $processedInvoiceNumber;
        }


        $invext = Transaction::whereNot('invoice_external', null)->get();
        $invExtProc = [];
        $transactionCounts = [];

        foreach ($invext as $transaction) {
            $invoiceNumber = $transaction->invoice_external;

            if (!isset($transactionCounts[$invoiceNumber])) {
                $transactionCounts[$invoiceNumber] = 0;
            }
            $transactionCounts[$invoiceNumber]++;

            $procTransactionNumber = $invoiceNumber . '_' . $transactionCounts[$invoiceNumber];

            // Cek apakah id_suratjalan null
            if (is_null($transaction->id_surat_jalan)) {
                $procTransactionNumber .= ' Mutasi '. $transaction->no_bm;
            } else {
                $procTransactionNumber .= ' Jualan '.$transaction->no_bm;
            }

            $invExtProc[] = $procTransactionNumber;
        }



        session(['jurnal_edit_url' => url()->full()]);
        return view('jurnal.edit-jurnal', compact('latestId','cekVoucher_d', 'cekVoucher_k','jurnals','data', 'tgl', 'coa', 'nopol', 'invProc', 'invExtProc'));
    }

    public function merger()
    {
        $jurnal = Jurnal::groupBy('nomor')->orderBy('nomor', 'asc')->get();
        return view('jurnal.jurnal-merger', compact('jurnal'));
    }

    function merger_store(Request $request)
    {
        if($request->jurnal_awal === null || $request->jurnal_tujuan === null){
             return back()->with('error', 'Jurnal awal dan tujuan wajib dipilih!');
        }
        $tujuan = Jurnal::where('nomor', $request->jurnal_tujuan)->first();
        Jurnal::where('nomor', $request->jurnal_awal)->update([
            'nomor' => $tujuan->nomor,
            'no' => $tujuan->no,
            'tipe' => $tujuan->tipe,
            'tgl' => $tujuan->tgl,
            'keterangan_buku_besar_pembantu' => $tujuan->keterangan_buku_besar_pembantu
        ]);
        BiayaInv::where('jurnal', $request->jurnal_awal)->update([
            'jurnal' => $tujuan->nomor,
        ]);

        return to_route('jurnal.index')->with('success', 'Merge No. Jurnal berhasil');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        $data = Jurnal::find($request->id);
        if (!$data) {
            return back()->with('error', 'Data Jurnal tidak ditemukan');
        }
        if ($request->invoice_external === null) {
            $data->id_transaksi = null;
        }
        $data->save(); 

        if ($request->invoice != null) {
            if (str_contains($request->invoice, '_')) {
                $inv = explode('_', $request->invoice)[0];
                $index = explode('_', $request->invoice)[1];
                $invoices = Invoice::with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                ])
                    ->where('invoice', $inv)
                    ->get();
                    $barang = $invoices[$index - 1]->transaksi->barang->nama;
                    $supplier = $invoices[$index - 1]->transaksi->suppliers->nama;
                    $customer = $invoices[$index - 1]->transaksi->suratJalan->customer->nama;
                    $quantity = $invoices[$index - 1]->transaksi->jumlah_jual;
                $satuan = $invoices[$index - 1]->transaksi->satuan_jual;
                $id = $invoices[$index - 1]->transaksi->id;
                $hargabeli = $invoices[$index - 1]->transaksi->harga_beli;
                $hargajual = $invoices[$index - 1]->transaksi->harga_jual;
                $ket = $invoices[$index - 1]->transaksi->keterangan;
                
                // dd($customer, $satuan, $quantity, $hargabeli, $hargajual, $ket, $supplier, $barang);
                $keterangan = $request->keterangan;
                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $id_transaksi = Invoice::where('invoice', $inv)->where('harga', $hargajual)->pluck('id_transaksi')->first();
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    $noCounter = explode('-', $nomor)[1]; // Ambil bagian kedua setelah '-'
                    $no = str_replace(' ', '', explode('/', $noCounter)[0]); // Ambil bagian pertama sebelum '/'
                }
                $data = Jurnal::find($request->id);
                if ($request->invoice === null && $request->invoice_external === null) {
                    $data->id_transaksi = $data->id_transaksi ?? $id;
                } else {
                    $data->id_transaksi = $id_transaksi;
                }
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keterangan;
                $data->keterangan_buku_besar_pembantu = $request->keterangan_buku_besar_pembantu;
                $data->invoice = !empty($request->invoice) ? explode('_', $request->invoice)[0] : null;
                $data->invoice_external = !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null;
                $data->nopol = $request->nopol;
                $data->tipe = $tipe;
                $data->coa_id = $request->coa_id;

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            } else {
                $invoice = $request->invoice;
                $id_transaksi1 = $request->id_transaksi;
                $invoices = Invoice::where('invoice', $invoice)->where('id_transaksi',$id_transaksi1)->with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                    ])->get();
                $barang = $invoices[0]->transaksi->barang->nama ?? null;
                $supplier = $invoices[0]->transaksi->suppliers->nama ?? null;
                $customer = $invoices[0]->transaksi->suratJalan->customer->nama ?? null;
                $quantity = $invoices[0]->transaksi->jumlah_jual ?? null;
                $satuan = $invoices[0]->transaksi->satuan_jual ?? null;
                $hargabeli = $invoices[0]->transaksi->harga_beli ?? null;
                $hargajual = $invoices[0]->transaksi->harga_jual ?? null;
                $ket = $invoices[0]->transaksi->keterangan ?? null;
                $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $request->keterangan;
                $id_transaksi = Invoice::where('invoice', $invoice)->where('harga', $hargajual)->where('id_transaksi',$id_transaksi1)->pluck('id_transaksi')->first();
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    $noCounter = explode('-', $nomor)[1]; // Ambil bagian kedua setelah '-'
                    $no = str_replace(' ', '', explode('/', $noCounter)[0]); // Ambil bagian pertama sebelum '/'
                }
                $data = Jurnal::find($request->id);
                if ($request->invoice === null && $request->invoice_external === null) {
                    $data->id_transaksi = $request->id_transaksi ?? $data->id_transaksi;
                } else {
                    $data->id_transaksi = $id_transaksi;
                }
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keterangan;
                $data->keterangan_buku_besar_pembantu = $request->keterangan_buku_besar_pembantu;
                $data->invoice = !empty($request->invoice) ? explode('_', $request->invoice)[0] : null;
                $data->invoice_external = !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null;
                $data->nopol = $request->nopol;
                $data->tipe = $tipe;
                $data->coa_id = $request->coa_id;

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            }
        } else if ($request->invoice_external ) {
            if (str_contains($request->invoice_external, '_')) {
                $part = explode(' ', $request->invoice_external);
                $invext = explode('_', $request->invoice_external)[0];
                $index1 = explode('_', $part[0]);
                $index = (int) $index1[1];
                
                $invoice_external = Transaction::where('invoice_external', $invext)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();
                    
                    // Jika tidak ada data ditemukan, lakukan query kedua
                    $barang = $invoice_external[$index - 1]->barang->nama;
                    $supplier = $invoice_external[$index - 1]->suppliers->nama;
                    $customer = $invoice_external[$index - 1]->suratJalan->customer->nama ?? null;
                    $quantity = $invoice_external[$index - 1]->jumlah_jual;
                    $satuan = $invoice_external[$index - 1]->satuan_jual;
                    $hargabeli = $invoice_external[$index - 1]->harga_beli;
                    $no_bm = $invoice_external[$index - 1]->no_bm;
                    $hargajual = $invoice_external[$index - 1]->harga_jual;
                $id = $invoice_external[$index - 1]->id;
                $ket = $invoice_external[$index - 1]->keterangan;
                $invoice_external= $request->invoice_external ?? '';
                $keterangan = $request->keterangan;
                
                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray();
                $id_transaksi =Transaction::where('invoice_external', $invext)->where('id_barang', $id_barang)->where('no_bm',$no_bm)->pluck('id')->first();
                $keteranganNow = $keterangan;
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    $noCounter = explode('-', $nomor)[1]; // Ambil bagian kedua setelah '-'
                    $no = str_replace(' ', '', explode('/', $noCounter)[0]); // Ambil bagian pertama sebelum '/'
                }
                $data = Jurnal::find($request->id);
                $data->nomor = $request->nomor;
                if ($request->invoice_external === null) {
                    $data->id_transaksi = $data->id_transaksi;
                } else {
                    $data->id_transaksi = $id_transaksi ?? $id;
                }
                $data->id_transaksi = $data->id_transaksi;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keteranganNow;
                $data->keterangan_buku_besar_pembantu = $request->keterangan_buku_besar_pembantu;
                $data->invoice = !empty($request->invoice) ? explode('_', $request->invoice)[0] : null;
                $data->invoice_external = !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null;
                $data->nopol = $request->nopol;
                $data->tipe = $tipe;
                $data->coa_id = $request->coa_id;

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            } else {
                $id_transaksi1 = $request->id_transaksi;
                $invoice_external = $request->invoice_external;
                $invoiceExternal = Transaction::where('invoice_external', $request->invoice_external)
                ->where('id',$id_transaksi1)
                ->with(['suratJalan.customer', 'barang', 'suppliers'])
                ->get();
                $barang = $invoiceExternal[0]->barang->nama ?? null;
                $supplier = $invoiceExternal[0]->suppliers->nama ?? null;
                $id = $invoiceExternal[0]->id ?? null;
                $customer = $invoiceExternal[0]->suratJalan->customer->nama ?? null;
                $quantity = $invoiceExternal[0]->jumlah_jual ?? null;
                $satuan = $invoiceExternal[0]->satuan_jual ?? null;
                $hargabeli = $invoiceExternal[0]->harga_beli ?? null;
                $hargajual = $invoiceExternal[0]->harga_jual ?? null;
                $ket = $invoiceExternal[0]->keterangan ?? null;
                
                // dd($request->invoice_external);
                $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray();
                $id_transaksi = Transaction::whereNull('id_surat_jalan')->where('id_barang', $id_barang)->where('id',$id_transaksi1)->pluck('id')->first();
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    if ($nomor == 'SALDO AWAL') {
                        $noCounter = 'SALDO AWAL';
                        $no = 0;
                    } else {
                        $noCounter = explode('-', $nomor)[1] ?? 'SALDO AWAL'; // Ambil bagian kedua setelah '-' jika ada
                        $no = str_replace(' ', '', explode('/', $noCounter)[0] ?? 0); // Ambil bagian pertama sebelum '/' jika ada
                    }
                }
                $data = Jurnal::find($request->id);
                if ($request->invoice === null && $request->invoice_external === null) {
                    $data->id_transaksi = $data->id_transaksi;
                } else {
                    $data->id_transaksi = $id_transaksi ?? $request->id_transaksi;
                }
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keteranganNow;
                $data->keterangan_buku_besar_pembantu = $request->keterangan_buku_besar_pembantu;
                $data->invoice = !empty($request->invoice) ? explode('_', $request->invoice)[0] : null;
                $data->invoice_external = !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null;
                $data->nopol = $request->nopol;
                $data->tipe = $tipe;
                $data->coa_id = $request->coa_id;
                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data->nomor, $data->tgl));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            }
        } else if ($request->keterangan) {
            if (str_contains($request->invoice_external, '_')) {
                $invext = explode('_', $request->invoice_external)[0];
                $index = explode('_', $request->invoice_external)[1];

                $invoice_external = Transaction::where('invoice_external', $request->invoice_external)
                    ->whereNull('id_surat_jalan')
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();

                $barang = $invoice_external[$index - 1]->barang->nama;
                $supplier = $invoice_external[$index - 1]->suppliers->nama;
                $customer = $invoice_external[$index - 1]->suratJalan->customer->nama;
                $quantity = $invoice_external[$index - 1]->jumlah_jual;
                $satuan = $invoice_external[$index - 1]->satuan_jual;
                $hargabeli = $invoice_external[$index - 1]->harga_beli;
                $hargajual = $invoice_external[$index - 1]->harga_jual;
                $ket = $invoice_external[$index - 1]->keterangan;
                $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray();
                $id_transaksi =Transaction::where('invoice_external', $invoice_external)->where('id_barang', $id_barang)
                        ->where('id_supplier', $supplier)->where('harga_jual', $hargajual)
                        ->pluck('id')->first() ?? null;
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    if ($nomor == 'SALDO AWAL') {
                        $noCounter = 'SALDO AWAL';
                        $no = 0;
                    } else {
                        $noCounter = explode('-', $nomor)[1] ?? 'SALDO AWAL'; // Ambil bagian kedua setelah '-' jika ada
                        $no = str_replace(' ', '', explode('/', $noCounter)[0] ?? 0); // Ambil bagian pertama sebelum '/' jika ada
                    }
                }
                $data = Jurnal::find($request->id);
                if ($request->invoice === null && $request->invoice_external === null) {
                    $data->id_transaksi = $data->id_transaksi;
                } else {
                    $data->id_transaksi = $id_transaksi;
                }
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keteranganNow;
                $data->keterangan_buku_besar_pembantu = $request->keterangan_buku_besar_pembantu;
                $data->invoice = !empty($request->invoice) ? explode('_', $request->invoice)[0] : null;
                $data->invoice_external = !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null;
                $data->nopol = $request->nopol;
                $data->tipe = $tipe;
                $data->coa_id = $request->coa_id;

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            } else {
                $invoice_external = $request->invoice_external;
                if ($invoice_external != null) {
                $invoiceExternal = Transaction::where('invoice_external', $request->invoice_external)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();

                    
                        $barang = optional(optional($invoiceExternal[0])->barang)->nama;
                        $supplier = optional(optional($invoiceExternal[0])->suppliers)->nama;
                        $customer = optional(optional(optional($invoiceExternal[0])->suratJalan)->customer)->nama;
                        $quantity = optional($invoiceExternal[0])->jumlah_jual;
                        $satuan = optional($invoiceExternal[0])->satuan_jual;
                        $hargabeli = optional($invoiceExternal[0])->harga_beli;
                        $hargajual = optional($invoiceExternal[0])->harga_jual;                    
                        $ket = optional($invoiceExternal[0])->keterangan;
                        $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray() ?? null;
                        $id_transaksi =Transaction::where('invoice_external', $invoice_external)->where('id_barang', $id_barang)
                        ->where('id_supplier', $supplier)->where('harga_jual', $hargajual)
                        ->pluck('id')->first() ?? null;
                    }                    
                    $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    if ($nomor == 'SALDO AWAL') {
                        $noCounter = 'SALDO AWAL';
                        $no = 0;
                    } else {
                        $noCounter = explode('-', $nomor)[1] ?? 'SALDO AWAL'; // Ambil bagian kedua setelah '-' jika ada
                        $no = str_replace(' ', '', explode('/', $noCounter)[0] ?? 0); // Ambil bagian pertama sebelum '/' jika ada
                    }
                }
                
                $data = Jurnal::find($request->id);
                if ($request->invoice === null && $request->invoice_external === null) {
                    $data->id_transaksi = $data->id_transaksi;
                } else {
                    $data->id_transaksi = $id_transaksi;
                }
                $data->nomor = $request->nomor;
                $data->debit = $request->debit;
                $data->kredit = $request->kredit;
                $data->keterangan = $keteranganNow;
                $data->keterangan_buku_besar_pembantu = $request->keterangan_buku_besar_pembantu;
                $data->invoice = !empty($request->invoice) ? explode('_', $request->invoice)[0] : null;
                $data->invoice_external = !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null;
                $data->nopol = $request->nopol;
                $data->tipe = $tipe;
                $data->coa_id = $request->coa_id;

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data->nomor, $data->tgl));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Invoice dan Invoice External kosong');
        }
        
        return redirect()->route('jurnal.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
{
    // Menghapus jurnal berdasarkan ID yang dikirim
    $data = Jurnal::destroy(request('id'));
    
    // Mendapatkan URL redirect dari session
    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
    
    // Memeriksa apakah redirectUrl ada, jika tidak maka mengarahkan ke jurnal.index
    if (!$redirectUrl) {
        return redirect()->route('jurnal.index')->with('success', 'Data Jurnal berhasil dihapus!');
    }

    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil dihapus!');
}


    public function dataTable()
    {
        $jurnal = Jurnal::join('coa', 'jurnal.coa_id', '=', 'coa.id')->select('jurnal.*', 'coa.no_akun', 'coa.nama_akun')->orderBy('tgl', 'desc')->orderBy('nomor', 'desc')->orderBy('tipe', 'asc')->get();

        return DataTables::of($jurnal)
            ->addIndexColumn()
            //            ->addColumn('#', function ($row) {
            //                return '<input type="checkbox" name="id' . $row->id . '" id="id" value="' . $row->id . '">';
            //            })
            //            ->rawColumns(['#'])
            ->make(true);
    }

    public function tglUpdate(Request $request)
    {
        // dd($request->all());
        $tgl = $request->tgl_input;
        $nomor = $request->nomor_jurnal_input;
        // dd($tgl, $nomor);
        $data = Jurnal::where('nomor', $nomor)->update([
            'tgl' => $tgl
        ]);
        $redirectUrl = route('jurnal.edit', ['nomor' => $nomor]);
        return redirect($redirectUrl)->with('success', 'Tanggal Jurnal berhasil diubah!');
    }

    public function store(Request $request, Jurnal $jurnal)
    {
        // dd($request->all());
        if ($request->invoice != null) {
            if (str_contains($request->invoice, '_')) {
                $inv = explode('_', $request->invoice)[0];
                $index = explode('_', $request->invoice)[1];
                $invoices = Invoice::with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                ])
                    ->where('invoice', $inv)
                    ->get();
                    $barang = $invoices[$index - 1]->transaksi->barang->nama;
                    $supplier = $invoices[$index - 1]->transaksi->suppliers->nama;
                    $customer = $invoices[$index - 1]->transaksi->suratJalan->customer->nama;
                    $quantity = $invoices[$index - 1]->transaksi->jumlah_jual;
                $satuan = $invoices[$index - 1]->transaksi->satuan_jual;
                $hargabeli = $invoices[$index - 1]->transaksi->harga_beli;
                $hargajual = $invoices[$index - 1]->transaksi->harga_jual;
                $ket = $invoices[$index - 1]->transaksi->keterangan;
                
                // dd($customer, $satuan, $quantity, $hargabeli, $hargajual, $ket, $supplier, $barang);
                $keteranganNow = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $id_transaksi = Invoice::where('invoice', $inv)->where('harga', $hargajual)->pluck('id_transaksi')->first();
                
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    $noCounter = explode('-', $nomor)[1]; // Ambil bagian kedua setelah '-'
                    $no = str_replace(' ', '', explode('/', $noCounter)[0]); // Ambil bagian pertama sebelum '/'
                }
                $data = Jurnal::create([
                    'id' => $request->id,
                    'no' => $request->no,
                    'tgl' => $request->tgl,
                    'id_transaksi' => $id_transaksi,
                    'nomor' => $request->nomor,
                    'debit' => $request->debit,
                    'kredit' => $request->kredit,
                    'keterangan' => $keteranganNow,
                    'keterangan_buku_besar_pembantu' => $request->keterangan_buku_besar_pembantu,
                    'invoice' => !empty($request->invoice) ? explode('_', $request->invoice)[0] : null,
                    'invoice_external' => !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null,
                    'nopol' => $request->nopol,
                    'tipe' => $tipe,
                    'coa_id' => $request->coa_id,
                ]);                

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            } else {
                $invoice = $request->invoice;
                $invoices = Invoice::where('invoice', $invoice)->with([
                    'transaksi.suppliers',
                    'transaksi.barang',
                    'transaksi.suratJalan.customer',
                    ])->get();

                
                $barang = $invoices[0]->transaksi->barang->nama;
                $supplier = $invoices[0]->transaksi->suppliers->nama;
                $customer = $invoices[0]->transaksi->suratJalan->customer->nama;
                $quantity = $invoices[0]->transaksi->jumlah_jual;
                $satuan = $invoices[0]->transaksi->satuan_jual;
                $hargabeli = $invoices[0]->transaksi->harga_beli;
                $hargajual = $invoices[0]->transaksi->harga_jual;
                $ket = $invoices[0]->transaksi->keterangan;
                
                

                $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $request->keterangan;
                $id_transaksi = Invoice::where('invoice', $invoice)->where('harga', $hargajual)->where('id_transaksi', $request->id_transaksi)->pluck('id_transaksi')->first();
                $nomor = $request->nomor;
                $tipe = $request->tipe;

                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    $noCounter = explode('-', $nomor)[1]; // Ambil bagian kedua setelah '-'
                    $no = str_replace(' ', '', explode('/', $noCounter)[0]); // Ambil bagian pertama sebelum '/'
                }
                $data = Jurnal::create([
                    'id' => $request->id,
                    'no' => $request->no,
                    'tgl' => $request->tgl,
                    'id_transaksi' => $id_transaksi,
                    'nomor' => $request->nomor,
                    'debit' => $request->debit,
                    'kredit' => $request->kredit,
                    'keterangan' => $keteranganNow,
                    'keterangan_buku_besar_pembantu' => $request->keterangan_buku_besar_pembantu,
                    'invoice' => !empty($request->invoice) ? explode('_', $request->invoice)[0] : null,
                    'invoice_external' => !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null,
                    'nopol' => $request->nopol,
                    'tipe' => $tipe,
                    'coa_id' => $request->coa_id,
                ]);       
                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            }
        } else if ($request->invoice_external ) {
            if (str_contains($request->invoice_external, '_')) {
                $part = explode(' ', $request->invoice_external);
                $invext = explode('_', $request->invoice_external)[0];
                $index1 = explode('_', $part[0]);
                $index = (int) $index1[1];
                
                $invoice_external = Transaction::where('invoice_external', $invext)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();
                
                
                    $barang = $invoice_external[$index - 1]->barang->nama;
                    $supplier = $invoice_external[$index - 1]->suppliers->nama;
                    $customer = $invoice_external[$index - 1]->suratJalan->customer->nama ?? null;
                    $quantity = $invoice_external[$index - 1]->jumlah_jual;
                    $satuan = $invoice_external[$index - 1]->satuan_jual;
                    $hargabeli = $invoice_external[$index - 1]->harga_beli;
                    $no_bm = $invoice_external[$index - 1]->no_bm;
                    $hargajual = $invoice_external[$index - 1]->harga_jual;
                    $id = $invoice_external[$index - 1]->id;
                    $ket = $invoice_external[$index - 1]->keterangan;
                    $invoice_external= $request->invoice_external ?? '';
                    $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray();
                $keteranganNow = $keterangan;
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    $noCounter = explode('-', $nomor)[1]; // Ambil bagian kedua setelah '-'
                    $no = str_replace(' ', '', explode('/', $noCounter)[0]); // Ambil bagian pertama sebelum '/'
                }
                $data = Jurnal::create([
                    'id' => $request->id,
                    'no' => $request->no,
                    'tgl' => $request->tgl,
                   'id_transaksi' => $id,
                    'nomor' => $request->nomor,
                    'debit' => $request->debit,
                    'kredit' => $request->kredit,
                    'keterangan' => $keteranganNow,
                    'keterangan_buku_besar_pembantu' => $request->keterangan_buku_besar_pembantu,
                    'invoice' => !empty($request->invoice) ? explode('_', $request->invoice)[0] : null,
                    'invoice_external' => !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null,
                    'nopol' => $request->nopol,
                    'tipe' => $tipe,
                    'coa_id' => $request->coa_id,
                ]);       

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            } else {
                $invoice_external = $request->invoice_external;
                $invoiceExternal = Transaction::where('invoice_external', $request->invoice_external)
                ->with(['suratJalan.customer', 'barang', 'suppliers'])
                ->get();
                
                $barang = $invoiceExternal[0]->barang->nama;
                $supplier = $invoiceExternal[0]->suppliers->nama;
                $customer = $invoiceExternal[0]->suratJalan->customer->nama ?? null;
                $quantity = $invoiceExternal[0]->jumlah_jual;
                $satuan = $invoiceExternal[0]->satuan_jual;
                $id = $invoiceExternal[0]->id;
                $hargabeli = $invoiceExternal[0]->harga_beli;
                $hargajual = $invoiceExternal[0]->harga_jual;
                $ket = $invoiceExternal[0]->keterangan;
                
                // dd($request->invoice_external);
                $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray();
                $id_transaksi =Transaction::where('invoice_external', $invoice_external)->where('id_barang', $id_barang)->where('id',$id)->pluck('id')->first();
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    if ($nomor == 'SALDO AWAL') {
                        $noCounter = 'SALDO AWAL';
                        $no = 0;
                    } else {
                        $noCounter = explode('-', $nomor)[1] ?? 'SALDO AWAL'; // Ambil bagian kedua setelah '-' jika ada
                        $no = str_replace(' ', '', explode('/', $noCounter)[0] ?? 0); // Ambil bagian pertama sebelum '/' jika ada
                    }
                }
                $data = Jurnal::create([
                    'id' => $request->id,
                    'no' => $request->no,
                    'tgl' => $request->tgl,
                    'id_transaksi' => $id_transaksi ?? $request->id_transaksi,
                    'nomor' => $request->nomor,
                    'debit' => $request->debit,
                    'kredit' => $request->kredit,
                    'keterangan' => $keteranganNow,
                    'keterangan_buku_besar_pembantu' => $request->keterangan_buku_besar_pembantu,
                    'invoice' => !empty($request->invoice) ? explode('_', $request->invoice)[0] : null,
                    'invoice_external' => !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null,
                    'nopol' => $request->nopol,
                    'tipe' => $tipe,
                    'coa_id' => $request->coa_id,
                ]);         
                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data->nomor, $data->tgl));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            }
        } else if ($request->keterangan) {
            if (str_contains($request->invoice_external, '_')) {
                $invext = explode('_', $request->invoice_external)[0];
                $index = explode('_', $request->invoice_external)[1];

                $invoice_external = Transaction::where('invoice_external', $request->invoice_external)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();

                $barang = $invoice_external[$index - 1]->barang->nama;
                $supplier = $invoice_external[$index - 1]->suppliers->nama;
                $customer = $invoice_external[$index - 1]->suratJalan->customer->nama;
                $quantity = $invoice_external[$index - 1]->jumlah_jual;
                $satuan = $invoice_external[$index - 1]->satuan_jual;
                $hargabeli = $invoice_external[$index - 1]->harga_beli;
                $hargajual = $invoice_external[$index - 1]->harga_jual;
                $ket = $invoice_external[$index - 1]->keterangan;

                $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray();
                $id_transaksi = Transaction::where('invoice_external', $invext)->where('id_barang', $id_barang)->pluck('id')->first();
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    if ($nomor == 'SALDO AWAL') {
                        $noCounter = 'SALDO AWAL';
                        $no = 0;
                    } else {
                        $noCounter = explode('-', $nomor)[1] ?? 'SALDO AWAL'; // Ambil bagian kedua setelah '-' jika ada
                        $no = str_replace(' ', '', explode('/', $noCounter)[0] ?? 0); // Ambil bagian pertama sebelum '/' jika ada
                    }
                }
                $data = Jurnal::create([
                    'id' => $request->id,
                    'no' => $request->no,
                    'tgl' => $request->tgl,
                    'id_transaksi' => $id_transaksi,
                    'nomor' => $request->nomor,
                    'debit' => $request->debit,
                    'kredit' => $request->kredit,
                    'keterangan' => $keteranganNow,
                    'keterangan_buku_besar_pembantu' => $request->keterangan_buku_besar_pembantu,
                    'invoice' => !empty($request->invoice) ? explode('_', $request->invoice)[0] : null,
                    'invoice_external' => !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null,
                    'nopol' => $request->nopol,
                    'tipe' => $tipe,
                    'coa_id' => $request->coa_id,
                ]);       

                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            } else {
                $invoice_external = $request->invoice_external;
                $invoiceExternal = Transaction::where('invoice_external', $request->invoice_external)
                    ->with(['suratJalan.customer', 'barang', 'suppliers'])
                    ->get();

                // Mengambil elemen pertama dengan aman
                $invoice = $invoiceExternal->first();

                $barang = optional(optional($invoice)->barang)->nama ?? null;
                $supplier = optional(optional($invoice)->suppliers)->nama ?? null;
                $customer = optional(optional(optional($invoice)->suratJalan)->customer)->nama ?? null;
                $quantity = optional($invoice)->jumlah_jual ?? null;
                $satuan = optional($invoice)->satuan_jual ?? null;
                $hargabeli = optional($invoice)->harga_beli ?? null;
                $hargajual = optional($invoice)->harga_jual ?? null;
                $ket = optional($invoice)->keterangan ?? null;

                    $keterangan = $request->keterangan;

                if (str_contains($request->keterangan, '[1]')) {
                    $keterangan = str_replace('[1]', $customer, $keterangan);
                }
                if (str_contains($request->keterangan, '[2]')) {
                    $keterangan = str_replace('[2]', $supplier, $keterangan);
                }
                if (str_contains($request->keterangan, '[3]')) {
                    $keterangan = str_replace('[3]', $barang, $keterangan);
                }
                if (str_contains($request->keterangan, '[4]')) {
                    $keterangan = str_replace('[4]', $quantity, $keterangan);
                }
                if (str_contains($request->keterangan, '[5]')) {
                    $keterangan = str_replace('[5]', $satuan, $keterangan);
                }
                if (str_contains($request->keterangan, '[6]')) {
                    $keterangan = str_replace('[6]', $hargabeli, $keterangan);
                }
                if (str_contains($request->keterangan, '[7]')) {
                    $keterangan = str_replace('[7]', $hargajual, $keterangan);
                }
                if (str_contains($request->keterangan, '[8]')) {
                    $keterangan = str_replace('[8]', $ket, $keterangan);
                }

                $keteranganNow = $keterangan;
                $id_barang = Barang::where('nama', $barang)->pluck('id')->toArray() ?? null;
                $id_transaksi =Transaction::where('invoice_external', $invoice_external)->where('id_barang', $id_barang)->pluck('id')->first() ?? null;
               
                $nomor = $request->nomor;
                $tipe = $request->tipe;
                $noCounter = explode('-', $nomor)[0];
                $no = str_replace(' ', '', explode('/', $noCounter)[0]);
                if ($tipe == 'JNL') {
                    if ($nomor == 'SALDO AWAL') {
                        $noCounter = 'SALDO AWAL';
                        $no = 0;
                    } else {
                        $noCounter = explode('-', $nomor)[1] ?? 'SALDO AWAL'; // Ambil bagian kedua setelah '-' jika ada
                        $no = str_replace(' ', '', explode('/', $noCounter)[0] ?? 0); // Ambil bagian pertama sebelum '/' jika ada
                    }
                }
                $data = Jurnal::create([
                    'id' => $request->id,
                    'no' => $request->no,
                    'tgl' => $request->tgl,
                    'id_transaksi' => $id_transaksi,
                    'nomor' => $request->nomor,
                    'debit' => $request->debit,
                    'kredit' => $request->kredit,
                    'keterangan' => $keteranganNow,
                    'keterangan_buku_besar_pembantu' => $request->keterangan_buku_besar_pembantu,
                    'invoice' => !empty($request->invoice) ? explode('_', $request->invoice)[0] : null,
                    'invoice_external' => !empty($request->invoice_external) ? explode('_', $request->invoice_external)[0] : null,
                    'nopol' => $request->nopol,
                    'tipe' => $tipe,
                    'coa_id' => $request->coa_id,
                ]);       
                if ($data->save()) {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data->nomor, $data->tgl));
                    return redirect($redirectUrl)->with('success', 'Data Jurnal berhasil diubah!');
                } else {
                    $redirectUrl = session('jurnal_edit_url', route('jurnal.edit', $data));
                    return redirect($redirectUrl)->with('error', 'Data Jurnal Gagal diubah!');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Invoice dan Invoice External kosong');
        }
        
        return redirect()->route('jurnal.edit');
    }
    public function exportJurnal(Request $request){

        if ($request->mulai == null || $request->sampai == null) {
            return back()->with('error', 'Silahkan atur nilai rentang data.');
        }
        return Excel::download(new JurnalALLExport($request->mulai, $request->sampai), 'jurnal.xlsx');
    }
}
