<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntervensiStunting extends Model
{
    protected $table = 'intervensi_stunting';
    protected $primaryKey = 'id_intervensi';
    public $timestamps = true;
    
    protected $fillable = [
        'id_anak',
        'id_stunting',
        'jenis_intervensi',
        'tanggal_pelaksanaan',
        'dosis_jumlah',
        'penanggung_jawab',
        'catatan_perkembangan',
        'status_tindak_lanjut',
        'file_pendukung'
    ];
    
    protected $casts = [
        'tanggal_pelaksanaan' => 'date'
    ];
    
    // Relasi
    public function anak()
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }
    
    public function dataStunting()
    {
        return $this->belongsTo(DataStunting::class, 'id_stunting', 'id_stunting');
    }
    
    public function petugas()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab', 'id_user');
    }
}