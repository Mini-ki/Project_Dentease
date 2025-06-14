<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi'; 
    protected $primaryKey = 'id_konsultasi'; 
    public $timestamps = false; 

    protected $fillable = ['id_dokter', 'id_pasien', 'keluhan', 'tanggal_konsultasi', 'status', 'status_pembayaran'];

    protected $casts = [
        'status' => 'string', 
        'status_pembayaran' => 'string',
        'tanggal_konsultasi' => 'date',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'id_konsultasi', 'id_konsultasi');
    }
}
?>