<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis'; 
    protected $primaryKey = 'id_rekam_medis'; 
    public $timestamps = false; 

    protected $fillable = ['id_konsultasi', 'tanggal', 'diagnosa', 'tindakan', 'obat'];

    protected $casts = [
        'tanggal' => 'datetime', 
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi', 'id_konsultasi');
    }
}