<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_customer',
        'npwp',
        'alamat_pengiriman',
        'alamat_penagihan',
        'email',
        'no_telepon',
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

    public function getNPWP()
    {
        return preg_replace('/[^0-9]/', '', $this->npwp);
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
}
