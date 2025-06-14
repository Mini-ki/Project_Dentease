<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; // <--- PENTING: Import ini!

class Dokter extends Authenticatable 
{
    use HasFactory, Notifiable;
    protected $table = 'dokter'; 
    protected $primaryKey = 'id_dokter'; 
    public $timestamps = false; 
    protected $guard = 'dokter';
    

    protected $fillable = [
        'foto_profil',
        'nama_panggilan',
        'nama_lengkap',
        'umur',
        'spesialis',
        'id_layanan',
        'alamat'
    ];

    protected $casts = [
        'foto_profil', 
        'umur' => 'integer',
        'id_layanan' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_dokter', 'id_user');
    }

    public function layananDokter()
    {
        return $this->belongsTo(LayananDokter::class, 'id_layanan', 'id_layanan');
    }
    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'id_dokter', 'id_dokter');
    }
     
}
?>