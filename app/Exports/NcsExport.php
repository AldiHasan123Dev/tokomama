<?php

namespace App\Exports;
use App\Models\Coa;
use App\Models\Jurnal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NcsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $coaId;
    protected $startDate;
    protected $endDate;

    public function __construct($coaId, $startDate, $endDate)
    {
        $this->coaId = $coaId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Jurnal::where('coa_id', $this->coaId)
            ->whereBetween('tgl', [$this->startDate, $this->endDate])
            ->where('invoice', '0')
            ->where('invoice_external', '0')
            ->orderBy('tgl', 'asc')
            ->get();
    }

    public function map($jurnal): array
    {
        $coa = Coa::find($this->coaId);
        return [
            $jurnal->tgl,
            $coa ? $coa->no_akun : '',
            $jurnal->keterangan,
            number_format($jurnal->debit, 2, ',', '.'), 
            number_format($jurnal->kredit, 2, ',', '.'), 
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Akun',
            'Keterangan',
            'Debit',
            'Kredit',
        ];
    }
}


