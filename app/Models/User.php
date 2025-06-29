<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = ['username', 'email', 'password', 'role'];

    protected $casts = [
        'role' => 'string', 
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
