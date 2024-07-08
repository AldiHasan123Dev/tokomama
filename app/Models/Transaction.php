<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'id_surat_jalan',
        'id_barang',
        'harga_beli',
        'jumlah_beli',
        'satuan_beli',
        'harga_jual',
        'jumlah_jual',
        'satuan_jual',
        'margin',
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class, 'id_surat_jalan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
