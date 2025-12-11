<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'username',
        'password',
        'nama',
        'role',
        'email',
        'no_telepon',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password' => 'hashed',
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