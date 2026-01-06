<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne; // Tambahkan import ini
use Carbon\Carbon;

class DataPengukuran extends Model
{
    use HasFactory;

    protected $table = 'data_pengukuran';
    protected $primaryKey = 'id_pengukuran';
    
    public $timestamps = true; 

    protected $fillable = [
        'id_anak',
        'id_posyandu',
        'id_petugas',
        'tanggal_ukur',
        'umur_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'cara_ukur',
        'status_gizi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_ukur' => 'date',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'lingkar_lengan' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'id_posyandu', 'id_posyandu');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id_user');
    }

    /**
     * PENTING: Nama fungsi ini HARUS 'dataStunting' 
     * karena di Controller dipanggil dengan ->with('dataStunting')
     */
    public function dataStunting(): HasOne
    {
        return $this->hasOne(DataStunting::class, 'id_pengukuran', 'id_pengukuran');
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    public function hitungUmurBulan()
    {
        if ($this->anak && $this->anak->tanggal_lahir) {
            $tanggalLahir = $this->anak->tanggal_lahir;
            return Carbon::parse($tanggalLahir)->diffInMonths($this->tanggal_ukur);
        }
        return 0;
    }

    public function isOutlier()
    {
        // Deteksi outlier sederhana
        // BB: 2-30 kg, TB: 45-120 cm untuk balita
        if ($this->berat_badan < 2 || $this->berat_badan > 30) {
            return true;
        }
        if ($this->tinggi_badan < 45 || $this->tinggi_badan > 120) {
            return true;
        }
        return false;
    }
}