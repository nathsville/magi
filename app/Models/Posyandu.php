<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $table = 'posyandu';
    protected $primaryKey = 'id_posyandu';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'nama_posyandu',
        'id_puskesmas',
        'alamat',
        'kelurahan',
        'kecamatan',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Relasi ke Puskesmas
     */
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }

    /**
     * Relasi ke Data Pengukuran
     */
    public function dataPengukuran()
    {
        return $this->hasMany(DataPengukuran::class, 'id_posyandu', 'id_posyandu');
    }

    /**
     * Scope untuk filter status aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
}