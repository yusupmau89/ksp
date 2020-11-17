<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Kategori::class, 'parent_id', 'id');
    }

    public function childrens()
    {
        return $this->hasMany(Kategori::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'kategory', 'id');
    }
}
