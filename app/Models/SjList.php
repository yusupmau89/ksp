<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SjList extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat_jalan',
        'purchase_list',
        'jumlah',
        'retur',
    ];

    public function purchaseList()
    {
        return $this->belongsTo(PurchaseList::class, 'purchase_list', 'id');
    }
}
