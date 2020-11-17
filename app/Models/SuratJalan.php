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
        'nomor_po',
        'nomor_invoice',
        'kendaraan',
        'plat_no',
        'pengirim',
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
        return $this->belongsTo(PurchaseOrder::class, 'nomor_po', 'id');
    }

    public function lists()
    {
        return $this->hasMany(SjList::class, 'no_surat_jalan', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'no_surat_jalan', 'id');
    }
}
