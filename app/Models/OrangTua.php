<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';
    protected $primaryKey = 'id_orangtua';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nik',
        'nama',
        'alamat',
        'no_telepon',
        'pekerjaan',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function anak()
    {
        return $this->hasMany(Anak::class, 'id_orangtua', 'id_orangtua');
    }
}