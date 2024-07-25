<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateJurnalItem extends Model
{
    use HasFactory;
    protected $table = 'template_jurnal_item';
    protected $fillable = [
        'template_jurnal_id',
        'coa_debit_id',
        'coa_kredit_id'
    ];
}
