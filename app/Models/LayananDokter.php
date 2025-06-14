<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananDokter extends Model
{
    protected $table = 'layanan_dokter'; 
    protected $primaryKey = 'id_layanan'; 
    public $timestamps = false; 

    protected $fillable = ['nama_layanan', 'biaya_layanan', 'status'];

    protected $casts = [
        'status' => 'string', 
        'biaya_layanan' => 'integer',
    ];

    public function dokters()
    {
        return $this->hasMany(Dokter::class, 'id_layanan', 'id_layanan');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
    public function feeds()
    {
        return $this->hasMany(Feed::class, 'id_layanan', 'id_layanan');
    }

}
?>