<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurnal extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'jurnal';
    protected $fillable = [
        'coa_id',
        'nomor',
        'tgl',
        'keterangan',
        'debit',
        'kredit',
        'invoice',
        'invoice_external',
        'nopol',
        'container',
        'tipe',
        'no',
        'created_by',
        'updated_by',
    ];

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'coa_id'); 
    }
}
