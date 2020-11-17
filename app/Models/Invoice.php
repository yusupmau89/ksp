<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'tanggal_invoice',
        'nomor_po',
        'jumlah',
        'created_by',
        'signed_by',
        'slug',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchaseOrder::class, 'nomor_po', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function lists()
    {
        return $this->hasMany(InvoiceList::class, 'invoice', 'id');
    }
}
