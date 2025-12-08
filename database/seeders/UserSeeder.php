<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama' => 'Administrator',
            'role' => 'Admin',
            'email' => 'admin@magi.com',
            'no_telepon' => '081234567890',
            'status' => 'Aktif',
        ]);

        // 2. Petugas DPPKB
        User::create([
            'username' => 'dppkb',
            'password' => Hash::make('dppkb123'),
            'nama' => 'Petugas DPPKB Parepare',
            'role' => 'Petugas DPPKB',
            'email' => 'dppkb@magi.com',
            'no_telepon' => '081234567891',
            'status' => 'Aktif',
        ]);

        // 3. Petugas Puskesmas
        User::create([
            'username' => 'puskesmas1',
            'password' => Hash::make('puskesmas123'),
            'nama' => 'Dr. Ahmad Yani',
            'role' => 'Petugas Puskesmas',
            'email' => 'puskesmas1@magi.com',
            'no_telepon' => '081234567892',
            'status' => 'Aktif',
        ]);

        User::create([
            'username' => 'puskesmas2',
            'password' => Hash::make('puskesmas123'),
            'nama' => 'Dr. Siti Nurhaliza',
            'role' => 'Petugas Puskesmas',
            'email' => 'puskesmas2@magi.com',
            'no_telepon' => '081234567893',
            'status' => 'Aktif',
        ]);

        // 4. Petugas Posyandu
        User::create([
            'username' => 'posyandu1',
            'password' => Hash::make('posyandu123'),
            'nama' => 'Ibu Fatimah',
            'role' => 'Petugas Posyandu',
            'email' => 'posyandu1@magi.com',
            'no_telepon' => '081234567894',
            'status' => 'Aktif',
        ]);

        User::create([
            'username' => 'posyandu2',
            'password' => Hash::make('posyandu123'),
            'nama' => 'Ibu Aisyah',
            'role' => 'Petugas Posyandu',
            'email' => 'posyandu2@magi.com',
            'no_telepon' => '081234567895',
            'status' => 'Aktif',
        ]);

        User::create([
            'username' => 'posyandu3',
            'password' => Hash::make('posyandu123'),
            'nama' => 'Ibu Khadijah',
            'role' => 'Petugas Posyandu',
            'email' => 'posyandu3@magi.com',
            'no_telepon' => '081234567896',
            'status' => 'Aktif',
        ]);

        // 5. Orang Tua
        
        // --- ORANG TUA 1 (Budi Santoso - Ayah) ---
        $orangtua1 = User::create([
            'username' => 'orangtua1',
            'password' => Hash::make('orangtua123'),
            'nama' => 'Budi Santoso', // Nama User Account
            'role' => 'Orang Tua',
            'email' => 'budi.santoso@gmail.com',
            'no_telepon' => '081234567897',
            'status' => 'Aktif',
        ]);

        OrangTua::create([
            'id_user' => $orangtua1->id_user,
            'nik' => '7371010101850001',
            'nama_ayah' => 'Budi Santoso',      // Perbaikan: Masuk ke nama_ayah
            'nama_ibu' => 'Siti Aminah',        // Perbaikan: Harus diisi (Data dummy istri)
            'alamat' => 'Jl. Jend. Ahmad Yani No. 45, Parepare',
            'no_telepon' => '081234567897',
            'pekerjaan_ayah' => 'Wiraswasta',   // Perbaikan: Masuk ke pekerjaan_ayah
            'pekerjaan_ibu' => 'Ibu Rumah Tangga' // Perbaikan: Tambahan data dummy
        ]);

        // --- ORANG TUA 2 (Siti Aminah - Ibu) ---
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
            'nama_ayah' => 'Budi Santoso',      // Dummy Suami
            'nama_ibu' => 'Siti Aminah',        // Nama user masuk ke nama_ibu
            'alamat' => 'Jl. Bau Massepe No. 12, Parepare',
            'no_telepon' => '081234567898',
            'pekerjaan_ayah' => 'Wiraswasta',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga'
        ]);

        // --- ORANG TUA 3 (Andi Rahman - Ayah) ---
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
            'nama_ayah' => 'Andi Rahman',
            'nama_ibu' => 'Rina Wati',          // Dummy Istri
            'alamat' => 'Jl. Jend. Sudirman No. 78, Parepare',
            'no_telepon' => '081234567899',
            'pekerjaan_ayah' => 'PNS',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga'
        ]);

        // --- ORANG TUA 4 (Dewi Lestari - Ibu) ---
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
            'nama_ayah' => 'Joko Susilo',       // Dummy Suami
            'nama_ibu' => 'Dewi Lestari',
            'alamat' => 'Jl. Lasinrang No. 23, Parepare',
            'no_telepon' => '081234567800',
            'pekerjaan_ayah' => 'Karyawan Swasta',
            'pekerjaan_ibu' => 'Guru'
        ]);

        // --- ORANG TUA 5 (Muhammad Ridwan - Ayah) ---
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
            'nama_ayah' => 'Muhammad Ridwan',
            'nama_ibu' => 'Nurhayati',          // Dummy Istri
            'alamat' => 'Jl. Andi Makkasau No. 56, Parepare',
            'no_telepon' => '081234567801',
            'pekerjaan_ayah' => 'Pedagang',
            'pekerjaan_ibu' => 'Membantu Suami'
        ]);
    }
}