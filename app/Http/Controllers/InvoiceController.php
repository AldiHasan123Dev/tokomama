<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Jurnal;
use App\Models\NSFP;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ids = explode(',', request('id_transaksi'));
        $transaksi = Transaction::whereIn('id', $ids)->get();
        $count = $transaksi->groupBy('suratJalan.id_customer');
        if($count->count()>1){
            return back()->with('error', 'Invoice hanya bisa dibuat untuk 1 customer');
        }
        $invoice_count = request('invoice_count');
        $nsfp = NSFP::where('available', '1')->orderBy('nomor')->take($invoice_count)->get();
        if($nsfp->count() < $invoice_count) {
            return back()->with('error', 'NSFP Belum Tersedia, pastikan nomor NSFP tersedia.');
        }
        $array_jumlah = [];
        foreach ($transaksi as $item) {
            $array_jumlah[$item->id] = $item->jumlah_jual;
        }
        $array_jumlah = json_encode($array_jumlah);
        $invoice_count = request('invoice_count');

        $currentMonth = Carbon::now()->month;
        $noJNL = Jurnal::where('tipe', 'JNL')->whereMonth('tgl', $currentMonth)->orderBy('no', 'desc')->first() ?? 0;
        $no_JNL =  $noJNL ? $noJNL->no + 1 : 1;

        // dd($no_JNL);
        
        return view('invoice.index', compact('transaksi','ids','invoice_count','array_jumlah', 'no_JNL'));
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
        // dd($request->all());
        // dd(date("n"));
        $tgl_inv = $request->tgl_invoice;
        $monthNumber = (int) substr($tgl_inv, 5, 2);
        // dd($monthNumber);
        $data = array();
        $idtsk = array();
        $array_invoice = array();
        $invoice_count = $request->invoice_count;
        $nsfp = NSFP::where('available', '1')->orderBy('nomor')->take($invoice_count)->get();
        if($nsfp->count() < $invoice_count) {
            return back()->with('error', 'NSFP Belum Tersedia, pastikan nomor NSFP tersedia.');
        }

        $no = Invoice::whereYear('created_at', date('Y'))->max('no') + 1;
        foreach ($nsfp as $item) {
            $roman_numerals = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
            $month_number = $monthNumber;
            $month_roman = $roman_numerals[$month_number];
            $inv= sprintf('%03d', $no) . '/INV/SB-' . $month_roman . '/' . date('Y');
            array_push($array_invoice, [
                'id_nsfp' => $item->id,
                'invoice' => $inv,
                'no' => $no
            ]);
            $no++;
        }


        foreach ($request->invoice as $id_transaksi => $invoice) {
            // dd($id_transaksi);
            foreach ($invoice as $idx => $item) {
                $data[$id_transaksi]['invoice'][$idx] = $item;
            }
        }
        foreach ($request->jumlah as $id_transaksi => $jumlah) {
            foreach ($jumlah as $idx => $item) {
                $data[$id_transaksi]['jumlah'][$idx] = $item;
            }
        }
        foreach ($request->invoice as $id_transaksi => $invoice) {
            array_push($idtsk, $id_transaksi);
        }
        
        
        // dd($idtsk);
        // dd($array_invoice);
        DB::transaction(function () use($data, $array_invoice, $request, $idtsk) {
            foreach ($data as $id_transaksi => $array_data) {
                // dd($request->tgl_invoice);
                for ($i=0; $i < count($array_data['invoice']); $i++) {
                    if ((int)$array_data['jumlah'][$i] > 0) {
                        $trx = Transaction::find($id_transaksi);

                        Invoice::create([
                            'id_transaksi' => $id_transaksi,
                            'id_nsfp' => $array_invoice[(int)$array_data['invoice'][$i]]['id_nsfp'],
                            'invoice' => $array_invoice[(int)$array_data['invoice'][$i]]['invoice'],
                            'harga' => $trx->harga_jual,
                            'jumlah' => $array_data['jumlah'][$i],
                            'subtotal' => $array_data['jumlah'][$i] * $trx->harga_jual,
                            'no' => $array_invoice[(int)$array_data['invoice'][$i]]['no'],
                            'tgl_invoice' => $request->tgl_invoice,
                        ]);
                        $trx->update([
                            'sisa' => $trx->sisa - $array_data['jumlah'][$i]
                        ]);
                        NSFP::find($array_invoice[(int)$array_data['invoice'][$i]]['id_nsfp'])->update([
                            'available' => 0,
                            'invoice' => $array_invoice[(int)$array_data['invoice'][$i]]['invoice'],
                        ]);
                    }
                }
            }
            $this->autoJurnal($idtsk, $array_invoice, $request->tipe, $request->tgl_invoice);

        });;

        return to_route('keuangan.invoice')->with('success', 'Invoice Created Successfully');
    }

    private function autoJurnal($idtsk, $invoice, $tipe, $tgl)
    {
        // dd($invoice[1]['invoice']);
        $no = (int) str_replace(' ', '', explode('-',explode('/', $tipe)[0])[1]);
        // dd($no);
        $total_all = array();
        $temp_total = array();
        for($i = 0; $i < count($invoice); $i++) {
            // dd(count($invoice));
            $result = Invoice::with([
                'transaksi.barang.satuan',
                'transaksi.suratJalan.customer'
                ])
                ->where('invoice',$invoice[$i]['invoice'])->get();
                // untuk debug '088/INV/SB-VI/2024' $invoice[$i]['invoice']
                
                $nopol = '';
                $temp_debit = 0;
                // dd($result);
                // dd($invoice[$i]['invoice']);
                foreach($result as $item) {
                    // dd($item);
                    // dd($invoice[$i]['invoice']);
                    $temp_debit +=  $item->subtotal; //$result[$i]->subtotal;
                    $nopol = $item->transaksi->suratJalan->no_pol;
                    Jurnal::create([
                        'coa_id' => 52,
                        'nomor' => $tipe,
                        'tgl' => date('Y-m-d'),
                        'keterangan' => 'Pendapatan ' . $item->transaksi->barang->nama . ' (' . $item->jumlah . ' ' . $item->transaksi->satuan_jual . ' Harsat ' . $item->transaksi->harga_jual . ')',
                        'debit' => 0,
                        'kredit' => $item->subtotal, // $result[$i]->subtotal,
                        'invoice' => $item->invoice,
                        'invoice_external' => 0,
                        'id_transaksi' => $item->id_transaksi,
                        'nopol' => $item->transaksi->suratJalan->no_pol,
                        'container' => null,
                        'tipe' => 'JNL',
                        'no' => $no
                    ]);
                }

            // dd($result);
            Jurnal::create([
                'coa_id' => 8,
                'nomor' => $tipe,
                'tgl' => date('Y-m-d'),
                'keterangan' => 'Piutang ' . $result[0]->transaksi->suratJalan->customer->nama,
                'debit' => $temp_debit,
                'kredit' => 0,
                'invoice' => $invoice[$i]['invoice'],
                'invoice_external' => 0,
                'id_transaksi' => null,
                'nopol' => $nopol,
                'container' => null,
                'tipe' => 'JNL',
                'no' => $no
            ]);
        }
        
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
