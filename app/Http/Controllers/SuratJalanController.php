<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Ekspedisi;
use App\Models\Nopol;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\SuratJalan;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SuratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('surat_jalan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = Barang::join('satuan', 'barang.id_satuan', '=', 'satuan.id')->select('barang.*', 'satuan.nama_satuan')->get();
        // dd($barang);
        $nopol = Nopol::where('status', 'aktif')->get();
        $customer = Customer::all();
        $ekspedisi = Ekspedisi::all();
        $satuan = Satuan::all();
        $supplier = Supplier::all();
        return view('surat_jalan.create', compact('barang', 'nopol', 'customer', 'ekspedisi', 'satuan', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->satuan_jual); $i++) {
            $satuanJual = Satuan::where('nama_satuan', $request->satuan_jual[$i])->exists();
            if (!$satuanJual) {
                if ($request->satuan_jual[$i] != null) {
                    $satuan = new Satuan;
                    $satuan->nama_satuan = $request->satuan_jual[$i];
                    $satuan->save();
                }
            }
        }

        for ($i = 0; $i < count($request->satuan_beli); $i++) {
            $satuanBeli = Satuan::where('nama_satuan', $request->satuan_beli[$i])->exists();
            if (!$satuanBeli) {
                if ($request->satuan_beli[$i] != null) {
                    $satuan = new Satuan;
                    $satuan->nama_satuan = $request->satuan_beli[$i];
                    $satuan->save();
                }
            }
        }

        $customer = Customer::find($request->id_customer);
        if (!$customer) {
            return back()->with('error', 'Customer Tidak Ditemukan');
        }
        $data = $request->all();
        if (SuratJalan::count() == 0) {
            $no = 87;
        } else {
            $no = SuratJalan::whereYear('created_at', date('Y'))->max('no') + 1;
        }

        $roman_numerals = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // daftar angka Romawi
        $month_number = date("n", strtotime($request->tgl_sj)); // mengambil nomor bulan dari tanggal
        $month_roman = $roman_numerals[$month_number];
        $data['no'] = $no;
        $data['nomor_surat'] = sprintf('%03d', $no) . '/SJ/SB-' . $month_roman . '/' . date('Y', strtotime($request->tgl_sj));
        $sj = SuratJalan::create($data);
        for ($i = 0; $i < count($request->barang); $i++) {
            if ($request->barang[$i] != null && $request->supplier[$i] != null) {
                Transaction::create([
                    'id_surat_jalan' => $sj->id,
                    'id_barang' => $request->barang[$i],
                    'jumlah_beli' => $request->jumlah_beli[$i],
                    'jumlah_jual' => $request->jumlah_jual[$i],
                    'sisa' => $request->jumlah_jual[$i],
                    'satuan_beli' => $request->satuan_beli[$i],
                    'satuan_jual' => $request->satuan_jual[$i],
                    'keterangan' => $request->keterangan[$i],
                    'id_supplier' => $request->supplier[$i]
                ]);
            }
        }
        return redirect()->route('surat-jalan.cetak', $sj);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // id, invoice, nomor_surat, kepada, jumlah, satuan, jenis_barang, nama_kapal, no_cont, no_seal, no_pol, no_job
        $data = SuratJalan::find($request->id);
        $data->invoice = $request->invoice;
        $data->nomor_surat = $request->nomor_surat;
        $data->kepada = $request->kepada;
        $data->jumlah = $request->jumlah;
        $data->satuan = $request->satuan;
        // $data->jenis_barang = $request->jenis_barang;
        $data->nama_kapal = $request->nama_kapal;
        $data->no_cont = $request->no_cont;
        $data->no_seal = $request->no_seal;
        $data->no_pol = $request->no_pol;
        $data->no_job = $request->no_job;
        $data->save();

        return redirect()->route('surat-jalan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Transaction::destroy(request('id'));
        SuratJalan::destroy(request('id'));
        return route('surat-jalan.index');
    }

    public function cetak(SuratJalan $surat_jalan)
    {
        // PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $ekspedisi = Ekspedisi::find($surat_jalan->id_ekspedisi);
        $pdf = Pdf::loadView('surat_jalan.cetak', compact('surat_jalan', 'ekspedisi'))->setPaper('a4', 'potrait');
        return $pdf->stream('surat_jalan.pdf');
        return view('surat_jalan.cetak', compact('surat_jalan', 'ekspedisi'));
    }

    public function tarif()
    {
        return view('surat_jalan.tarif');
    }

    public function dataTable()
    {
        $data = SuratJalan::query()->orderBy('nomor_surat', 'desc');
        // $data = SuratJalan::query()->join('ekspedisi', 'ekspedisi.id', '=', 'surat_jalan.id_ekspedisi')->join('transaction', 'transaction.id_surat_jalan', '=', 'surat_jalan.id')->select('surat_jalan.*', 'ekspedisi.nama', 'transaction.id_surat_jalan', 'transaction.harga_jual', 'transaction.jumlah_jual', 'transaction.harga_beli', 'transaction.jumlah_beli');


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('profit', function ($row) {
                $total = $row->transactions->sum('margin');
                return number_format($total);
            })
            ->addColumn('invoice', function ($row) {
                $inv = array();
                foreach ($row->transactions as $key => $item) {
                    foreach ($item->invoices as $in) {
                        array_push($inv, $in->invoice);
                    }
                }
                $inv = array_unique($inv);
                return implode(', ', $inv);
            })
            ->addColumn('aksi', function ($row) {
                $action = '';
                $sisa = $row->transactions->sum('sisa');
                if ($sisa > 0) {
                    $action = '<button onclick="getData(' . $row->id . ', \'' . addslashes($row->invoice) . '\', \'' . addslashes($row->nomor_surat) . '\', \'' . addslashes($row->kepada) . '\', \'' . addslashes($row->jumlah) . '\', \'' . addslashes($row->satuan) . '\', \'' . addslashes($row->nama_kapal) . '\', \'' . addslashes($row->no_cont) . '\', \'' . addslashes($row->no_seal) . '\', \'' . addslashes($row->no_pol) . '\', \'' . addslashes($row->no_job) . '\')"   id="edit" class="text-yellow-400 font-semibold mb-3 self-end"><i class="fa-solid fa-pencil"></i></button>
                                <button onclick="deleteData(' . $row->id . ')"  id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end"><i class="fa-solid fa-trash"></i></button>';
                }
                return '<div class="flex gap-3 mt-2">
                                <a target="_blank" href="' . route('surat-jalan.cetak', $row) . '" class="text-green-500 font-semibold mb-3 self-end"><i class="fa-solid fa-print mt-2"></i></a>
                                '.$action.'
                            </div>';
            })
            ->rawColumns(['profit'])
            ->rawColumns(['aksi'])
            ->make();
    }
}
