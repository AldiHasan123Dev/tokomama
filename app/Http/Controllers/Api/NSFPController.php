<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NSFP;
use Illuminate\Cache\Events\RetrievingKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;

use function Laravel\Prompts\alert;

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
        $query = NSFP::query()->where('available', 1);
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<button class="btn" onclick="getDataNSFP(' . $row->id . ',\''.$row->nomor.'\')">open modal</button>
                <form method=' . 'post' . ' action = ' . route('nsfp.delete') . '><input type=hidden name=id value=' . $row->id . '><button type="submit" class="btn bg-red-600 text-white">Hapus</button></form>';
            })
            ->rawColumns(['aksi'])
            ->make();
    }

    public function deleteNSFP(Request $request)
    {
        NSFP::destroy($request->id);
        return redirect()->route('pajak.nsfp');
    }

    public function dataNSFPDone()
    {
        $data = NSFP::query()->where('available', 0);
        return Datatables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function deleteAllNSFP()
    {
        NSFP::where('available', 1)->delete();

        return redirect()->route('pajak.nsfp');
    }
}
