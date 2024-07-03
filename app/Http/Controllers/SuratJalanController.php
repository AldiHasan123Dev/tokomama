<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Container;
use App\Models\Nopol;
use App\Models\Seal;
use App\Models\SuratJalan;
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
        $barang = Barang::pluck('nama')->toArray();
        $container = Container::pluck('nama')->toArray();
        $seal = Seal::pluck('nama')->toArray();
        $nopol = Nopol::pluck('nopol')->toArray();
        $no = SuratJalan::whereYear('created_at', date('Y'))->max('no') + 1;
        $roman_numerals = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // daftar angka Romawi
        $month_number = date("n", strtotime(date('Y-m-d'))); // mengambil nomor bulan dari tanggal
        $month_roman = $roman_numerals[$month_number];
        $nomor = sprintf('%03d', $no) . '/SJ/SB-' . $month_roman . '/' . date('Y');
        return view('surat_jalan.create', compact('barang', 'container', 'seal', 'nopol', 'nomor', 'no'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = SuratJalan::create($request->all());
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
                                <a target="_blank" href="' . route('surat-jalan.cetak', $row) . '" class="font-semibold mb-3 self-end"><i class="fa-solid fa-print mt-2"></i></a>
                                <button id="edit" class=" font-semibold mb-3 self-end"><i class="fa-solid fa-pencil"></i></button>
                                <button id="delete-faktur-all" class=" font-semibold mb-3 self-end"><i class="fa-solid fa-trash"></i></button>
                            </div>';
            })
            ->rawColumns(['aksi'])
            ->make();
    }
}
