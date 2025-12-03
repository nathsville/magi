<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\OrangTua;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama' => 'Administrator',
            'role' => 'Admin',
            'email' => 'admin@magi.com',
            'no_telepon' => '081234567890',
            'status' => 'Aktif',
        ]);

        // 2. Petugas DPPKB
        $dppkb = User::create([
            'username' => 'dppkb',
            'password' => Hash::make('dppkb123'),
            'nama' => 'Petugas DPPKB Parepare',
            'role' => 'Petugas DPPKB',
            'email' => 'dppkb@magi.com',
            'no_telepon' => '081234567891',
            'status' => 'Aktif',
        ]);

        // 3. Petugas Puskesmas
        $puskesmas1 = User::create([
            'username' => 'puskesmas1',
            'password' => Hash::make('puskesmas123'),
            'nama' => 'Dr. Ahmad Yani',
            'role' => 'Petugas Puskesmas',
            'email' => 'puskesmas1@magi.com',
            'no_telepon' => '081234567892',
            'status' => 'Aktif',
        ]);

        $puskesmas2 = User::create([
            'username' => 'puskesmas2',
            'password' => Hash::make('puskesmas123'),
            'nama' => 'Dr. Siti Nurhaliza',
            'role' => 'Petugas Puskesmas',
            'email' => 'puskesmas2@magi.com',
            'no_telepon' => '081234567893',
            'status' => 'Aktif',
        ]);

        // 4. Petugas Posyandu
        $posyandu1 = User::create([
            'username' => 'posyandu1',
            'password' => Hash::make('posyandu123'),
            'nama' => 'Ibu Fatimah',
            'role' => 'Petugas Posyandu',
            'email' => 'posyandu1@magi.com',
            'no_telepon' => '081234567894',
            'status' => 'Aktif',
        ]);

        $posyandu2 = User::create([
            'username' => 'posyandu2',
            'password' => Hash::make('posyandu123'),
            'nama' => 'Ibu Aisyah',
            'role' => 'Petugas Posyandu',
            'email' => 'posyandu2@magi.com',
            'no_telepon' => '081234567895',
            'status' => 'Aktif',
        ]);

        $posyandu3 = User::create([
            'username' => 'posyandu3',
            'password' => Hash::make('posyandu123'),
            'nama' => 'Ibu Khadijah',
            'role' => 'Petugas Posyandu',
            'email' => 'posyandu3@magi.com',
            'no_telepon' => '081234567896',
            'status' => 'Aktif',
        ]);

        // 5. Orang Tua
        $orangtua1 = User::create([
            'username' => 'orangtua1',
            'password' => Hash::make('orangtua123'),
            'nama' => 'Budi Santoso',
            'role' => 'Orang Tua',
            'email' => 'budi.santoso@gmail.com',
            'no_telepon' => '081234567897',
            'status' => 'Aktif',
        ]);

        // Buat profil orang tua
        OrangTua::create([
            'id_user' => $orangtua1->id_user,
            'nik' => '7371010101850001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Jend. Ahmad Yani No. 45, Parepare',
            'no_telepon' => '081234567897',
            'pekerjaan' => 'Wiraswasta',
        ]);

        $orangtua2 = User::create([
            'username' => 'orangtua2',
            'password' => Hash::make('orangtua123'),
            'nama' => 'Siti Aminah',
            'role' => 'Orang Tua',
            'email' => 'siti.aminah@gmail.com',
            'no_telepon' => '081234567898',
            'status' => 'Aktif',
        ]);

        OrangTua::create([
            'id_user' => $orangtua2->id_user,
            'nik' => '7371010101900002',
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Bau Massepe No. 12, Parepare',
            'no_telepon' => '081234567898',
            'pekerjaan' => 'Ibu Rumah Tangga',
        ]);

        $orangtua3 = User::create([
            'username' => 'orangtua3',
            'password' => Hash::make('orangtua123'),
            'nama' => 'Andi Rahman',
            'role' => 'Orang Tua',
            'email' => 'andi.rahman@gmail.com',
            'no_telepon' => '081234567899',
            'status' => 'Aktif',
        ]);

        OrangTua::create([
            'id_user' => $orangtua3->id_user,
            'nik' => '7371010101880003',
            'nama' => 'Andi Rahman',
            'alamat' => 'Jl. Jend. Sudirman No. 78, Parepare',
            'no_telepon' => '081234567899',
            'pekerjaan' => 'PNS',
        ]);

        $orangtua4 = User::create([
            'username' => 'orangtua4',
            'password' => Hash::make('orangtua123'),
            'nama' => 'Dewi Lestari',
            'role' => 'Orang Tua',
            'email' => 'dewi.lestari@gmail.com',
            'no_telepon' => '081234567800',
            'status' => 'Aktif',
        ]);

        OrangTua::create([
            'id_user' => $orangtua4->id_user,
            'nik' => '7371010101920004',
            'nama' => 'Dewi Lestari',
            'alamat' => 'Jl. Lasinrang No. 23, Parepare',
            'no_telepon' => '081234567800',
            'pekerjaan' => 'Guru',
        ]);

        $orangtua5 = User::create([
            'username' => 'orangtua5',
            'password' => Hash::make('orangtua123'),
            'nama' => 'Muhammad Ridwan',
            'role' => 'Orang Tua',
            'email' => 'ridwan.m@gmail.com',
            'no_telepon' => '081234567801',
            'status' => 'Aktif',
        ]);

        OrangTua::create([
            'id_user' => $orangtua5->id_user,
            'nik' => '7371010101870005',
            'nama' => 'Muhammad Ridwan',
            'alamat' => 'Jl. Andi Makkasau No. 56, Parepare',
            'no_telepon' => '081234567801',
            'pekerjaan' => 'Pedagang',
        ]);
    }
}