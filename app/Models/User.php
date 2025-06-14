<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users'; // Nama tabel sesuai database
    protected $primaryKey = 'id_user'; // Primary key sesuai tabel lama
    public $timestamps = false; // Tidak pakai timestamps otomatis

    protected $fillable = ['username', 'email', 'password', 'role'];

    protected $casts = [
        'role' => 'string', // ENUM dikonversi ke string agar lebih mudah digunakan
    ];

    // Jika ingin memakai fitur autentikasi Laravel (Auth)
    protected $hidden = ['password'];

    // Relasi ke Dokter (Jika ada dokter dengan FK id_dokter di tabel user)
    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_dokter', 'id_user');
    }
    // Relasi ke Admin (Jika ada admin dengan FK id_admin di tabel user)
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_admin', 'id_user');
    }
    // Relasi ke Pasien (Jika ada pasien dengan FK id_pasien di tabel user)
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_pasien', 'id_user');
    }

}
?>