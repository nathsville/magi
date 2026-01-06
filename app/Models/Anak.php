<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt; // Tambahan Wajib: Library Enkripsi
use Illuminate\Contracts\Encryption\DecryptException; // Tambahan: Error handling

class Anak extends Model
{
    protected $table = 'anak';
    protected $primaryKey = 'id_anak';
    public $timestamps = false;

    protected $fillable = [
        'id_orangtua',
        'id_posyandu',
        'nama_anak',
        'nik_anak', // Kolom ini yang akan kita enkripsi
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

    // =================================================================
    // IMPLEMENTASI ENKRIPSI AES-256 (CIA TRIAD: CONFIDENTIALITY)
    // =================================================================

    /**
     * MUTATOR: Enkripsi otomatis saat data disimpan (Insert/Update).
     * Nama function harus format: set[NamaKolomCamelCase]Attribute
     */
    public function setNikAnakAttribute($value)
    {
        // Ubah NIK asli menjadi Ciphertext sebelum masuk database
        $this->attributes['nik_anak'] = Crypt::encryptString($value);
    }

    /**
     * ACCESSOR: Dekripsi otomatis saat data diambil (Select).
     * Sehingga di website terbaca angka biasa, tapi di database tetap acak.
     */
    public function getNikAnakAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            // Fail-safe: Jika data lama belum terenkripsi, tampilkan apa adanya
            return $value;
        }
    }
    
    // =================================================================
    // AKHIR IMPLEMENTASI ENKRIPSI
    // =================================================================

    // Relationships
    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class, 'id_orangtua', 'id_orangtua');
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'id_posyandu', 'id_posyandu');
    }

    public function dataPengukuran()
    {
        return $this->hasMany(DataPengukuran::class, 'id_anak', 'id_anak');
    }

    public function pengukuranTerakhir()
    {
        return $this->hasOne(DataPengukuran::class, 'id_anak', 'id_anak')
            ->ofMany([
                'tanggal_ukur' => 'max',
                'id_pengukuran' => 'max'
            ]);
    }

    public function stuntingTerakhir()
    {
        return $this->hasOneThrough(
            DataStunting::class,
            DataPengukuran::class,
            'id_anak',
            'id_pengukuran',
            'id_anak',
            'id_pengukuran'
        )->orderBy('data_pengukuran.tanggal_ukur', 'desc');
    }

    public function intervensiStunting()
    {
        return $this->hasMany(IntervensiStunting::class, 'id_anak', 'id_anak');
    }

    // Accessor: Calculate age in months
    public function getUmurBulanAttribute()
    {
        if ($this->tanggal_lahir) {
            return \Carbon\Carbon::parse($this->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now());
        }
        return 0;
    }

    // Accessor: Calculate age in years
    public function getUmurTahunAttribute()
    {
        if ($this->tanggal_lahir) {
            return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
        }
        return 0;
    }
}


