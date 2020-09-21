<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseList extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_po',
        'produk',
        'jumlah',
        'harga',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchaseOrder::class, 'no_po', 'id');
    }

    public function subtotal()
    {
        return $this->jumlah*$this->harga;
    }
}
