<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    protected $table = 'posyandu';
    protected $primaryKey = 'id_posyandu';
    public $timestamps = false;

    protected $fillable = [
        'nama_posyandu',
        'id_puskesmas',
        'alamat',
        'kelurahan',
        'kecamatan',
        'status',
        'created_at'
    ];

    // Relationships
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function anak()
    {
        return $this->hasMany(Anak::class, 'id_posyandu', 'id_posyandu');
    }
}