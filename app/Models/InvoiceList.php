<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'surat_jalan',
        'jumlah',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice', 'id');
    }
    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class, 'surat_jalan', 'id');
    }
}
