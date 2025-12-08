<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tua';
    protected $primaryKey = 'id_orangtua';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nik',
        'nama_ayah',
        'nama_ibu',
        'alamat',
        'no_telepon',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Anak
     */
    public function anak()
    {
        return $this->hasMany(Anak::class, 'id_orangtua', 'id_orangtua');
    }
}