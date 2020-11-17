<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori',
        'jenis_produk',
        'satuan_unit',
        'harga',
        'drawing',
        'created_by',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDateCreated()
    {
        $tgl = Carbon::parse($this->created_at)->locale('id');
        return $tgl->dayName.', '.$tgl->isoFormat('DD MMMM Y');
    }

    public function getDateModified()
    {
        $tgl = Carbon::parse($this->updated_at)->locale('id');
        return $tgl->dayName.', '.$tgl->isoFormat('DD MMMM Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'id');
    }
}
