<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    public $timestamps = false;

    protected $fillable = [
        'jenis_laporan',
        'id_pembuat',
        'periode_bulan',
        'periode_tahun',
        'id_wilayah',
        'tipe_wilayah',
        'total_anak',
        'total_stunting',
        'total_normal',
        'persentase_stunting',
        'file_laporan',
        'tanggal_buat',
    ];

    protected $casts = [
        'tanggal_buat' => 'datetime',
        'persentase_stunting' => 'decimal:2',
    ];

    // Relationships
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'id_pembuat', 'id_user');
    }

    public function wilayah()
    {
        if ($this->tipe_wilayah === 'Puskesmas') {
            return $this->belongsTo(Puskesmas::class, 'id_wilayah', 'id_puskesmas');
        }
        return null;
    }

    // Helper methods
    public function getPeriodeFormatAttribute()
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulan[$this->periode_bulan] . ' ' . $this->periode_tahun;
    }

    public function getFileUrlAttribute()
    {
        return $this->file_laporan ? asset('storage/' . $this->file_laporan) : null;
    }
}