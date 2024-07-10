<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';   
    protected $fillable = [
        'id_transaksi',
        'id_nsfp',
        'invoice',
        'harga',
        'jumlah',
        'subtotal',
    ];
}
