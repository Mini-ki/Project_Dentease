<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanDokter extends Model
{
    protected $table = 'ulasan_dokter'; 
    protected $primaryKey = 'id_ulasan'; 
    public $timestamps = false;

    protected $fillable = ['id_konsultasi', 'id_dokter', 'ulasan', 'rating'];

    protected $casts = [
        'rating' => 'float', 
    ];

    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class, 'id_konsultasi', 'id_konsultasi');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }
}