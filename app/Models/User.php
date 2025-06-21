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

    protected $hidden = ['password'];

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_dokter', 'id_user');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_admin', 'id_user');
    }
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_pasien', 'id_user');
    }

    public function adminDetail()
    {
        return $this->hasOne(Admin::class, 'id_admin', 'id_user');
    }

    public function getSubRoleAttribute()
    {
        if ($this->role === 'admin' && $this->adminDetail) {
            return $this->adminDetail->role;
        }
        return $this->role;
    }
}
?>