<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NSFP;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class NSFPController extends Controller
{
    public function generate(Request $request)
    {
        try {
            $no = str_replace(' ', '', $request->nomor);
            $res = explode('.', $no);
            $depan = $res[0] . '.' . $res[1] . '.' . $res[2] . '.';
            $res = (int)end($res);
            for ($i = 0; $i < $request->jumlah; $i++) {
                $num = $res + $i;
                NSFP::create([
                    'nomor' => $depan . '' . sprintf('%08d', $num),
                    'available' => 1
                ]);
            }
            return response('success');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // dd("berhasil masuk controller");
    }

    public function data()
    {
        $query = NSFP::query();
        return Datatables::of($query)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            return '<a href='.route('nsfp.data').'>Edit</a>';
        })
        ->rawColumns(['aksi'])
        ->make();
    }   
    
}
