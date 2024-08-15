<?php
namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class Neraca extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;
    
        // Get the month and year from the request, or use the current month and year as defaults
        $bulan = $request->input('bulan', $currentMonth);
        $tahun = $request->input('tahun', $currentYear);
    
        // Define the start date as January 2023
        $startDate = '2023-01-01';
        // Define the end date based on the selected month and year
        $endDate = now()->create($tahun . '-' . $bulan . '-01')->endOfMonth()->toDateString();
    
        $coa1 = Coa::where('no_akun', 'not like', '1.2%')->where('no_akun', 'like', '1%')->orderBy('no_akun')->get();
        $coa2 = Coa::where('no_akun', ' ')->orderBy('no_akun')->get();
        $coa3 = Coa::where('no_akun', 'like', '2%')->orderBy('no_akun')->get();
        $coa4 = Coa::where('no_akun', 'like', '3%')->orderBy('no_akun')->get();
    
        $totals = [];
        $coaId1 = $coa1->pluck('id')->toArray();
        $coaId2 = $coa2->pluck('id')->toArray();
        $coaId3 = $coa3->pluck('id')->toArray();
        $coaId4 = $coa4->pluck('id')->toArray();
    
        $allCoaIds = array_merge($coaId1, $coaId2, $coaId3, $coaId4);
       
        foreach ($allCoaIds as $coaId) {
            // Filter based on start date and end date
            $debit = Jurnal::where('coa_id', $coaId)
                ->whereBetween('tgl', [$startDate, $endDate])
                ->sum('debit');
    
            $kredit = Jurnal::where('coa_id', $coaId)
                ->whereBetween('tgl', [$startDate, $endDate])
                ->sum('kredit');
    
            if (in_array($coaId, $coaId1) || in_array($coaId, $coaId2)) {
                $selisih = $debit - $kredit;
            } elseif (in_array($coaId, $coaId3) || in_array($coaId, $coaId4)) {
                $selisih = $kredit - $debit;
            } else {
                $selisih = 0;
            }
    
            $totals[$coaId] = [
                'debit' => $debit,
                'kredit' => $kredit,
                'selisih' => $selisih,
            ];
        }
    
        // Calculate totals based on filtered COAs
        $totalA = array_sum(array_column(array_intersect_key($totals, array_flip($coaId1)), 'selisih'));
        $totalB = array_sum(array_column(array_intersect_key($totals, array_flip($coaId2)), 'selisih'));
        $totalC = array_sum(array_column(array_intersect_key($totals, array_flip($coaId3)), 'selisih'));
        $totalD = array_sum(array_column(array_intersect_key($totals, array_flip($coaId4)), 'selisih'));
    
        // Calculate Laba Rugi (LR)
        $kel5 = Jurnal::join('coa', 'coa.id', '=', 'jurnal.coa_id')
            ->where('coa.no_akun', 'like', '5.%')
            ->whereBetween('jurnal.tgl', [$startDate, $endDate])
            ->get();

        $kel6 = Jurnal::join('coa', 'coa.id', '=', 'jurnal.coa_id')
            ->where('coa.no_akun', 'like', '6.%')
            ->whereBetween('jurnal.tgl', [$startDate, $endDate])
            ->get();

        $kel7 = Jurnal::join('coa', 'coa.id', '=', 'jurnal.coa_id')
            ->where('coa.no_akun', 'like', '7.%')
            ->whereBetween('jurnal.tgl', [$startDate, $endDate])
            ->get();

        $lr = ($kel5->sum('kredit') - $kel5->sum('debit')) - 
            (($kel6->sum('debit') - $kel6->sum('kredit')) + 
            ($kel7->sum('debit') - $kel7->sum('kredit')));

        return view('jurnal.neraca', compact(
            'coa1', 'coa2', 'coa3', 'coa4',
            'totals', 'totalA', 'totalB', 'totalC', 'totalD',
            'bulan', 'tahun', 'lr', 'startDate', 'endDate'
        ));
    }

    // Other controller methods...


    


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
        //
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
}
