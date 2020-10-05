<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SjList extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_jalan',
        'purchase_list',
        'produk',
        'jumlah',
        'retur',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'produk', 'id');
    }

    public function purchaseList()
    {
        return $this->belongsTo(PurchaseList::class, 'purchase_list', 'id');
    }
}
