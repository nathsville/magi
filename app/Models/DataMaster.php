<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMaster extends Model
{
    protected $table = 'data_master';
    protected $primaryKey = 'id_master';
    
    protected $fillable = [
        'tipe_data',
        'kode',
        'nilai',
        'deskripsi',
        'status',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}