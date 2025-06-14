<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter'; 
    protected $primaryKey = 'id_jadwal'; 
    public $timestamps = false; 
    protected $fillable = ['id_dokter', 'hari', 'change_date', 'jam_mulai', 'jam_selesai'];

    protected $casts = [
        'hari' => 'string', 
        'change_date' => 'datetime',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }
}
?>