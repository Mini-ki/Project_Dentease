<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $table = 'feed'; 
    protected $primaryKey = 'id_feed'; 
    public $timestamps = false; 

    protected $fillable = ['judul_feed', 'deskripsi', 'image', 'id_admin', 'created_at', 'update_at'];

    protected $casts = [
        'image' => 'string', // Assuming image is stored as a base64 string
        'created_at' => 'datetime',
        'update_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
    public function getImageAttribute($value)
    {
        return $value ? base64_encode($value) : null; // Encode image to base64 for easier handling in views
    }
}
?>