<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ZScoreService;
use App\Models\User;
use App\Models\Anak;
use App\Models\DataPengukuran;
use App\Models\WhoStandard;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MagiLogicTest extends TestCase
{
    use DatabaseMigrations;

    public function test_zscore_calculation_returns_array()
    {
        $this->mockWhoData('L', 12, 'tbu', 75.7);
        $result = ZScoreService::calculate('L', 12, 9.6, 75.7);
        $this->assertIsArray($result);
    }

    public function test_zscore_result_structure()
    {
        $this->mockWhoData('L', 12, 'tbu', 75.7);
        $result = ZScoreService::calculate('L', 12, 9.6, 75.7);
        $this->assertArrayHasKey('zscore_tb_u', $result);
        $this->assertArrayHasKey('status_stunting', $result);
    }

    public function test_zscore_calculation_normal_male()
    {
        WhoStandard::create([
            'gender' => 'L', 'type' => 'tbu', 'measure_value' => 12,
            'l' => 1, 'm' => 75.7, 's' => 0.03
        ]);

        $result = ZScoreService::calculate('L', 12, 9.6, 75.7);
        
        $this->assertEquals(0, $result['zscore_tb_u']);
        $this->assertEquals('Normal', $result['status_stunting']);
    }

    public function test_zscore_status_stunting_berat()
    {
        WhoStandard::create([
            'gender' => 'L', 'type' => 'tbu', 'measure_value' => 12,
            'l' => 1, 'm' => 75.7, 's' => 0.05
        ]);

        $result = ZScoreService::calculate('L', 12, 9.6, 60.0);
        $this->assertEquals('Sangat Pendek (Severely Stunted)', $result['status_stunting']);
    }

    public function test_zscore_calculation_uses_female_median()
    {
        WhoStandard::create([
            'gender' => 'P', 'type' => 'tbu', 'measure_value' => 12,
            'l' => 1, 'm' => 74.0, 's' => 0.03
        ]);

        $result = ZScoreService::calculate('P', 12, 9.0, 74.0);
        $this->assertEquals(0, $result['zscore_tb_u']);
    }

    public function test_anak_umur_bulan_accessor()
    {
        $anak = new Anak([
            'tanggal_lahir' => Carbon::now()->subMonths(5)->format('Y-m-d')
        ]);
        $this->assertEqualsWithDelta(5, $anak->umur_bulan, 0.1);
    }

    public function test_anak_umur_tahun_accessor()
    {
        $anak = new Anak([
            'tanggal_lahir' => Carbon::now()->subYears(2)->format('Y-m-d')
        ]);
        $this->assertEquals(2, $anak->umur_tahun);
    }

    public function test_anak_date_casting()
    {
        $anak = new Anak([
            'tanggal_lahir' => '2023-01-01'
        ]);
        $this->assertInstanceOf(Carbon::class, $anak->tanggal_lahir);
    }

    public function test_pengukuran_is_outlier_low_weight()
    {
        $pengukuran = new DataPengukuran([
            'berat_badan' => 1.5,
            'tinggi_badan' => 50
        ]);
        $this->assertTrue($pengukuran->isOutlier());
    }

    public function test_pengukuran_is_outlier_high_height()
    {
        $pengukuran = new DataPengukuran([
            'berat_badan' => 10,
            'tinggi_badan' => 150
        ]);
        $this->assertTrue($pengukuran->isOutlier());
    }

    public function test_pengukuran_is_not_outlier_normal_data()
    {
        $pengukuran = new DataPengukuran([
            'berat_badan' => 10,  
            'tinggi_badan' => 75  
        ]);
        $this->assertFalse($pengukuran->isOutlier());
    }

    public function test_user_has_role_true()
    {
        $user = new User(['role' => 'admin']);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_user_has_role_false()
    {
        $user = new User(['role' => 'user']);
        $this->assertFalse($user->hasRole('admin'));
    }

    public function test_user_scope_aktif()
    {
        User::create([
            'username' => 'user_a', 
            'role' => 'kader',
            'nama' => 'User A', 'status' => 'Aktif', 'email' => 'a@a.com', 'password' => 'pass'
        ]);
        
        User::create([
            'username' => 'user_b',
            'role' => 'kader',
            'nama' => 'User B', 'status' => 'Nonaktif', 'email' => 'b@b.com', 'password' => 'pass'
        ]);

        $activeUsers = User::aktif()->get();

        $this->assertEquals(1, $activeUsers->count());
        $this->assertEquals('User A', $activeUsers->first()->nama);
    }

    public function test_pengukuran_hitung_umur_bulan_integration()
    {
        $tglLahir = Carbon::now()->subMonths(10);
        $tglUkur = Carbon::now();

        DB::statement('PRAGMA foreign_keys=OFF;');

        $anak = Anak::create([
            'nama_anak' => 'Bayi Test',
            'tanggal_lahir' => $tglLahir,
            'jenis_kelamin' => 'L',
            'nik_anak' => '1234567890123456',
            'tempat_lahir' => 'Jakarta',
            'anak_ke' => 1,
            'id_orangtua' => 1,
            'id_posyandu' => 1
        ]);
        
        DB::statement('PRAGMA foreign_keys=ON;');

        $pengukuran = new DataPengukuran([
            'id_anak' => $anak->id_anak,
            'tanggal_ukur' => $tglUkur
        ]);
        
        $pengukuran->setRelation('anak', $anak);

        $this->assertEqualsWithDelta(10, $pengukuran->hitungUmurBulan(), 0.1);
    }

    private function mockWhoData($gender, $month, $type, $median) {
        WhoStandard::create([
            'gender' => $gender,
            'type' => $type,
            'measure_value' => $month,
            'l' => 1,
            'm' => $median,
            's' => 0.03
        ]);
    }
}