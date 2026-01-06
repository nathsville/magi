<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    
    // PENTING: Karena PK di database adalah 'id_user' (bukan 'id')
    protected $primaryKey = 'id_user';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // === BAGIAN INI YANG DIPERBAIKI ===
    protected $fillable = [
        'username',
        'password',
        'nama',
        'role',
        'email',
        'no_telepon',
        'status',
        'otp_code',       // <--- WAJIB ADA
        'otp_expires_at', // <--- WAJIB ADA
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code', // Sebaiknya disembunyikan juga agar tidak terekspos sembarangan
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password' => 'hashed',
        'otp_expires_at' => 'datetime', // <--- Biar otomatis jadi Carbon object
    ];

    /**
     * Relasi ke Orang Tua
     */
    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'id_user', 'id_user');
    }

    // Relasi ke Petugas Posyandu
    public function posyandu()
    {
        return $this->hasOne(Posyandu::class, 'id_user', 'id_user');
    }

    /**
     * Check if user has role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Scope untuk filter status aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope untuk filter by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}