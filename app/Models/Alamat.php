<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table= 'alamat';
    protected $guarded = [];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id', 'id');
    }

    public function refAlamat()
    {
        return $this->belongsTo(RefAlamat::class, 'ref_alamat_id', 'id');
    }
}
