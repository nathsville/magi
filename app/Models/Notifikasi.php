<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_stunting',
        'judul',
        'pesan',
        'tipe_notifikasi',
        'status_baca',
        'tanggal_kirim',
        'created_at'
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
        'created_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function stunting()
    {
        return $this->belongsTo(DataStunting::class, 'id_stunting', 'id_stunting');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('status_baca', 'Belum Dibaca');
    }

    public function scopeRead($query)
    {
        return $query->where('status_baca', 'Sudah Dibaca');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('tipe_notifikasi', $type);
    }

    // Accessors
    public function getIsUnreadAttribute()
    {
        return $this->status_baca === 'Belum Dibaca';
    }

    public function getFormattedDateAttribute()
    {
        return $this->tanggal_kirim->format('d F Y, H:i');
    }
}