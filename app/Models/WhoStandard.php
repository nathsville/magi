<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhoStandard extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'who_standards';
    
    /**
     * Indicates if the model should be timestamped.
     * Data WHO adalah data statis yang tidak berubah, jadi tidak perlu timestamps.
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'gender',
        'type',
        'measure_value',
        'l',
        'm',
        's',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'measure_value' => 'decimal:2',
        'l' => 'decimal:5',
        'm' => 'decimal:5',
        's' => 'decimal:5',
    ];
}