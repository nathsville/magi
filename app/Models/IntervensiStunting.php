<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntervensiStunting extends Model
{
    protected $table = 'intervensi_stunting';
    protected $primaryKey = 'id_intervensi';
    public $timestamps = false;

    protected $fillable = [
        'id_anak',
        'jenis_intervensi',
        'deskripsi',
        'tanggal_pelaksanaan',
        'dosis_jumlah',
        'id_petugas',
        'status_tindak_lanjut',
        'catatan',
        'file_pendukung',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke Anak
     */
    public function anak()
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }

    /**
     * Relasi ke Petugas
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id_user');
    }
}