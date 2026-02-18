<?php

namespace App\Exports;

use App\Models\Coa;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JurnalExport implements WithMultipleSheets
{
    protected $coaId;

    public function __construct($coaId = null)
    {
        $this->coaId = $coaId;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Ambil data COA
        $query = Coa::where('status', 'aktif');

        // Jika pilih COA tertentu
        if ($this->coaId) {
            $query->where('id', $this->coaId);
        }

        $coas = $query->orderBy('kode')->get();

        // Looping semua COA jadi Sheet
        foreach ($coas as $coa)
        {
            $sheets[] = new JurnalSheetExport($coa);
        }

        return $sheets;
    }
}