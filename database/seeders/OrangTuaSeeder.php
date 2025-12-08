<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Posyandu;
use Faker\Factory as Faker;

class OrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all active posyandu
        $posyanduList = Posyandu::where('status', 'Aktif')->get();
        
        if ($posyanduList->isEmpty()) {
            $this->command->warn('No active Posyandu found. Please run PosyanduSeeder first.');
            return;
        }

        $orangTuaData = [];
        $userData = [];
        
        // Create 50 Orang Tua (families)
        for ($i = 1; $i <= 50; $i++) {
            $namaAyah = $faker->firstNameMale() . ' ' . $faker->lastName();
            $namaIbu = $faker->firstNameFemale() . ' ' . $faker->lastName();
            $username = 'orangtua' . $i;
            $email = strtolower(str_replace(' ', '', $namaIbu)) . $i . '@example.com';
            $noTelepon = '08' . $faker->numerify('##########');
            $nik = $faker->numerify('73##############'); // NIK Sulawesi Selatan (73)
            
            // Pilih posyandu secara acak
            $posyandu = $posyanduList->random();
            
            // Create User account for Orang Tua
            $user = User::create([
                'username' => $username,
                'password' => Hash::make('password123'),
                'nama' => $namaIbu, // Nama ibu sebagai nama user
                'role' => 'Orang Tua',
                'email' => $email,
                'no_telepon' => $noTelepon,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create Orang Tua profile
            $orangTuaData[] = [
                'id_orangtua' => $i,
                'id_user' => $user->id_user,
                'nik' => $nik,
                'nama_ayah' => $namaAyah,
                'nama_ibu' => $namaIbu,
                'alamat' => $faker->address(),
                'no_telepon' => $noTelepon,
                'pekerjaan_ayah' => $faker->randomElement([
                    'Petani', 'Nelayan', 'Pedagang', 'PNS', 'Swasta', 
                    'Wiraswasta', 'Buruh', 'Supir', 'Tukang'
                ]),
                'pekerjaan_ibu' => $faker->randomElement([
                    'Ibu Rumah Tangga', 'Petani', 'Pedagang', 'PNS', 
                    'Swasta', 'Guru', 'Buruh', 'Wiraswasta'
                ]),
                'pendidikan_ayah' => $faker->randomElement([
                    'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'
                ]),
                'pendidikan_ibu' => $faker->randomElement([
                    'SD', 'SMP', 'SMA', 'D3', 'S1'
                ]),
                'created_at' => now()
            ];
        }

        // Bulk insert
        DB::table('orang_tua')->insert($orangTuaData);

        $this->command->info('✅ Created 50 Orang Tua with user accounts');
    }
}