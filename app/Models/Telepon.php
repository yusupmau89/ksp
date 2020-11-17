<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telepon extends Model
{
    use HasFactory;

    protected $table = 'telepon';
    protected $fillable = ['no_telepon', 'pengguna_id', 'deskripsi'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id', 'id');
    }

    public function noTelp()
    {
        //if(preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $this->no_telepon,  $matches ) )
        if(strlen($this->no_telepon > 10) && preg_match('/^(\d{4})(\d{4})(\d{3,})$/', $this->no_telepon,  $matches))
        {
            $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
            return $result;
        } elseif (preg_match('/^(\d{3})(\d{3})(\d{4,})$/', $this->no_telepon,  $matches))
        {
            $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
            return $result;
        }
    }
}
