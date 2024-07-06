<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuratJalanResource;
use App\Models\NSFP;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class PajakController extends Controller
{
    public function index()
    {
        $data = DB::table('nsfp')->get();

        return view('pajak.nsfp',  compact('data'));
    }

    public function lapPpn()
    {
        return view('pajak.laporan-ppn');
    }

    public function nsfpAvailable()
    {
        $data = DB::table('nsfp')->get();
        return $data;
    }

    public function datatable()
    {

        // dd($suratJalan);
        /**
         * Data yang dibutuhkan
         * Surat Jalan
         * Customer customer diambil dari relasi surat jalan
         * Nsfp 
         * 
         * kemudian di passing ke databable
         */

        $data1 = SuratJalan::get();
        $data = SuratJalanResource::collection($data1);
        $res = $data->toArray(request());
        return DataTables::of($res)
            ->addIndexColumn()
            ->toJson();
    }
}
