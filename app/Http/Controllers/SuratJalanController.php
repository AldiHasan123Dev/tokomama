<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Nopol;
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
        $barang = Barang::select('nama', 'value','id')->get();
        $nopol = Nopol::pluck('nopol')->toArray();
        $customer = Customer::all();
        $no = SuratJalan::whereYear('created_at', date('Y'))->max('no') + 1;
        $roman_numerals = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // daftar angka Romawi
        $month_number = date("n", strtotime(date('Y-m-d'))); // mengambil nomor bulan dari tanggal
        $month_roman = $roman_numerals[$month_number];
        $nomor = sprintf('%03d', $no) . '/SJ/SB-' . $month_roman . '/' . date('Y');
        return view('surat_jalan.create', compact('barang', 'nopol', 'nomor', 'no', 'customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = SuratJalan::create($request->all());
        for ($i=0; $i < 4; $i++) { 
            if($request->barang[$i] != null && $request->id_barang[$i] != null){
                Transaction::create([
                    'id_surat_jalan' => $data->id,
                    'id_barang' => $request->id_barang[$i],
                    'harga_beli' => $request->harga_beli[$i],
                    'harga_jual' => $request->harga_jual[$i],
                    'jumlah_beli' => $request->jumlah_beli[$i],
                    'jumlah_jual' => $request->jumlah_jual[$i],
                    'satuan_beli' => $request->satuan_beli[$i],
                    'satuan_jual' => $request->satuan_jual[$i],
                    'margin' => $request->profit[$i],
                ]);
            }
        }
        return redirect()->route('surat-jalan.cetak', $data);
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
        $data->jenis_barang = $request->jenis_barang;
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
        SuratJalan::destroy(request('id'));
        return route('surat-jalan.index');
    }

    public function cetak(SuratJalan $surat_jalan)
    {
        // PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = Pdf::loadView('surat_jalan.cetak', compact('surat_jalan'));
        return $pdf->stream('surat_jalan.pdf');
        return view('surat_jalan.cetak', compact('surat_jalan'));
    }

    public function dataTable()
    {
        $data = SuratJalan::query()->orderBy('nomor_surat', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<div class="flex gap-3 mt-2">
                                <a target="_blank" href="' . route('surat-jalan.cetak', $row) . '" class="text-green-500 font-semibold mb-3 self-end"><i class="fa-solid fa-print mt-2"></i></a>
                                <button onclick="getData(' . $row->id . ', \'' . addslashes($row->invoice) . '\', \'' . addslashes($row->nomor_surat) . '\', \'' . addslashes($row->kepada) . '\', \'' . addslashes($row->jumlah) . '\', \'' . addslashes($row->satuan) . '\', \'' . addslashes($row->jenis_barang) . '\', \'' . addslashes($row->nama_kapal) . '\', \'' . addslashes($row->no_cont) . '\', \'' . addslashes($row->no_seal) . '\', \'' . addslashes($row->no_pol) . '\', \'' . addslashes($row->no_job) . '\')"   id="edit" class="text-yellow-400 font-semibold mb-3 self-end"><i class="fa-solid fa-pencil"></i></button>
                                <button onclick="deleteData(' . $row->id . ')"  id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end"><i class="fa-solid fa-trash"></i></button>
                            </div>';
            })
            ->rawColumns(['aksi'])
            ->make();
    }

    
}
