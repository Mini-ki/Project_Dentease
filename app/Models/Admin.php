<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class Admin extends Authenticatable 
{
    use HasFactory, Notifiable;
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = ['nama_admin', 'noHP', 'role'];
    protected $casts = ['role' => 'string'];

    protected $guard = 'admin';
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['foto_profil'];

    public function feeds()
    {
        return $this->hasMany(Feed::class, 'id_admin');
    }
    public function layananDokters()
    {
        return $this->hasMany(LayananDokter::class, 'id_admin');
    }
    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_admin');
    }
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_admin');
    }
    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'id_admin');
    }
    public function dokter()
    {
        return $this->hasMany(Dokter::class, 'id_admin');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
    

}

?>