<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefAlamat extends Model
{
    use HasFactory;
    protected $table = 'ref_alamat';

    protected $fillable = ['referensi', 'deskripsi'];

    public function alamats()
    {
        return $this->hasMany(Alamat::class, 'ref_alamat_id', 'id');
    }
}
