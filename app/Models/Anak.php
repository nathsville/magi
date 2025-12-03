<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anak';
    protected $primaryKey = 'id_anak';
    public $timestamps = false;

    protected $fillable = [
        'id_orangtua',
        'nama_anak',
        'nik_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'tempat_lahir',
        'anak_ke',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relationships
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'id_orangtua', 'id_orangtua');
    }

    public function dataPengukuran()
    {
        return $this->hasMany(DataPengukuran::class, 'id_anak', 'id_anak');
    }

    // Helper methods
    public function getUmurBulanAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->diffInMonths(Carbon::now());
    }

    public function getUmurTahunAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->diffInYears(Carbon::now());
    }

    public function getPengukuranTerakhirAttribute()
    {
        return $this->dataPengukuran()->latest('tanggal_ukur')->first();
    }

    public function getStatusGiziTerakhirAttribute()
    {
        $pengukuran = $this->pengukuranTerakhir;
        return $pengukuran?->dataStunting?->status_stunting ?? 'Belum Ada Data';
    }
}