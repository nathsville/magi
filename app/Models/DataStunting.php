<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataStunting extends Model
{
    use HasFactory;

    protected $table = 'data_stunting';
    protected $primaryKey = 'id_stunting';
    public $timestamps = false;

    protected $fillable = [
        'id_pengukuran',
        'status_stunting',
        'zscore_tb_u',
        'zscore_bb_u',
        'zscore_bb_tb',
        'status_validasi',
        'id_validator',
        'tanggal_validasi',
        'catatan_validasi',
    ];

    protected $casts = [
        'zscore_tb_u' => 'decimal:2',
        'zscore_bb_u' => 'decimal:2',
        'zscore_bb_tb' => 'decimal:2',
        'tanggal_validasi' => 'datetime',
    ];

    // Relationships
    public function dataPengukuran()
    {
        return $this->belongsTo(DataPengukuran::class, 'id_pengukuran', 'id_pengukuran');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'id_validator', 'id_user');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_stunting', 'id_stunting');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status_validasi === 'Pending';
    }

    public function isValidated()
    {
        return $this->status_validasi === 'Validated';
    }

    public function isRejected()
    {
        return $this->status_validasi === 'Rejected';
    }

    public function isStunting()
    {
        return in_array($this->status_stunting, ['Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']);
    }

    public function getStatusBadgeColorAttribute()
    {
        return match($this->status_stunting) {
            'Normal' => 'green',
            'Stunting Ringan' => 'yellow',
            'Stunting Sedang' => 'orange',
            'Stunting Berat' => 'red',
            default => 'gray',
        };
    }
}