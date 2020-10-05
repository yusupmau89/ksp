<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat_jalan',
        'tanggal_surat_jalan',
        'no_po',
        'signed_by',
        'created_by',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseOrder::class, 'no_po', 'id');
    }

    public function lists()
    {
        return $this->hasMany(SjList::class, 'surat_jalan', 'id');
    }
}
