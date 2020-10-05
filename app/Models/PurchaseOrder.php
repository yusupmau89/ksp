<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_po',
        'tanggal_po',
        'tanggal_kirim',
        'customer_id',
        'down_payment',
        'top',
        'ppn',
        'status',
        'created_by',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany(PurchaseList::class, 'no_po', 'id');
    }

    public function suratJalan()
    {
        return $this->hasMany(SuratJalan::class, 'no_po', 'id');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->lists as $list) {
            $total+= ($list->subtotal());
        }
        return $total;
    }
}
