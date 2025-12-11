<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = 'anak';
    protected $primaryKey = 'id_anak';
    public $timestamps = false;

    protected $fillable = [
        'id_orangtua',
        'id_posyandu', // Tambahan: Penting agar tidak error Mass Assignment saat create anak
        'nama_anak',
        'nik_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'tempat_lahir',
        'anak_ke',
        'created_at'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime'
    ];

    // Relationships
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'id_orangtua', 'id_orangtua');
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'id_posyandu', 'id_posyandu');
    }

    /**
     * PERBAIKAN DI SINI:
     * Mengubah nama dari 'pengukuran' menjadi 'dataPengukuran'
     * agar sesuai dengan panggilan di Seeder (IntervensiStuntingSeeder)
     */
    public function dataPengukuran()
    {
        return $this->hasMany(DataPengukuran::class, 'id_anak', 'id_anak');
    }

    public function pengukuranTerakhir()
    {
        return $this->hasOne(DataPengukuran::class, 'id_anak', 'id_anak')
            ->orderBy('tanggal_ukur', 'desc');
    }

    public function stuntingTerakhir()
    {
        return $this->hasOneThrough(
            DataStunting::class,
            DataPengukuran::class,
            'id_anak', // Foreign key on DataPengukuran
            'id_pengukuran', // Foreign key on DataStunting
            'id_anak', // Local key on Anak
            'id_pengukuran' // Local key on DataPengukuran
        )->orderBy('data_pengukuran.tanggal_ukur', 'desc');
    }

    public function intervensiStunting()
    {
        return $this->hasMany(IntervensiStunting::class, 'id_anak', 'id_anak');
    }

    // Accessor: Calculate age in months
    public function getUmurBulanAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now());
    }

    // Accessor: Calculate age in years
    public function getUmurTahunAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }
}