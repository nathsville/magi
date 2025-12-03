<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = 'puskesmas';
    protected $primaryKey = 'id_puskesmas';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'nama_puskesmas',
        'alamat',
        'kecamatan',
        'kabupaten',
        'no_telepon',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Relasi ke Posyandu
     */
    public function posyandu()
    {
        return $this->hasMany(Posyandu::class, 'id_puskesmas', 'id_puskesmas');
    }

    /**
     * Scope untuk filter status aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Accessor untuk badge status
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'Aktif' 
            ? '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>'
            : '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Nonaktif</span>';
    }
}