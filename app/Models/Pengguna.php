<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $fillable = [
        'nama',
        'npwp',
        'perusahaan',
        'supplier',
        'pegawai',
        'customer',
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

    public function alamats()
    {
        return $this->hasMany(Alamat::class, 'pengguna_id', 'id');
    }

    public function telepons()
    {
        return $this->hasMany(Telepon::class, 'pengguna_id', 'id');
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'pengguna_id', 'id');
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
