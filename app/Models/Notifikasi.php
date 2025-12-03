<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    public $timestamps = false; 
    protected $guarded = [];
    
    protected $fillable = [
        'id_user',
        'id_stunting',
        'judul',
        'pesan',
        'tipe_notifikasi',
        'status_baca',
        'tanggal_kirim'
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Data Stunting
    public function dataStunting()
    {
        return $this->belongsTo(DataStunting::class, 'id_stunting', 'id_stunting');
    }

    // Scope untuk filter
    public function scopeBelumDibaca($query)
    {
        return $query->where('status_baca', 'Belum Dibaca');
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_notifikasi', $tipe);
    }
}