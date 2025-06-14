<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; // <--- PENTING: Import ini!

class Pasien extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'pasien'; 
    protected $primaryKey = 'id_pasien'; 
    public $timestamps = false; 

    protected $fillable = ['foto_profil', 'nama_panggilan', 'nama_lengkap', 'umur', 'alamat', 'noHp'];

    protected $casts = [
        'foto_profil', 
        'umur' => 'integer',
        'noHp' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pasien', 'id_user');
    }

    public function latestKonsultasi()
    {
        return $this->hasOne(Konsultasi::class, 'id_pasien', 'id_pasien')
                    ->latest('tanggal_konsultasi') // Urutkan berdasarkan tanggal terbaru
                    ->latest('id_konsultasi'); // Jika tanggal sama, ambil ID terbesar
    }
}
