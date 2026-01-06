<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('who_standards', function (Blueprint $table) {
            $table->id();
            
            // Jenis Kelamin: L (Laki-laki/Male), P (Perempuan/Female)
            $table->enum('gender', ['L', 'P']);
            
            // Tipe Indikator:
            // 'bbu' = Berat Badan menurut Umur (Weight-for-Age / WFA)
            // 'tbu' = Tinggi Badan menurut Umur (Length/Height-for-Age / LHFA)
            // 'wfl' = Berat Badan menurut Panjang Badan 0-2 tahun (Weight-for-Length)
            // 'wfh' = Berat Badan menurut Tinggi Badan 2-5 tahun (Weight-for-Height)
            $table->string('type', 20);
            
            // Nilai Pengukuran (Month untuk WFA/LHFA, atau Length/Height dalam cm untuk WFL/WFH)
            $table->decimal('measure_value', 8, 2);
            
            // Parameter LMS dari WHO
            $table->decimal('l', 12, 5); // Box-Cox power transformation
            $table->decimal('m', 12, 5); // Median
            $table->decimal('s', 12, 5); // Coefficient of Variation
            
            // Index untuk performa query yang cepat
            $table->index(['gender', 'type', 'measure_value'], 'who_search_idx');
            
            // No timestamps karena data ini statis
            // $table->timestamps(); // TIDAK PERLU
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('who_standards');
    }
};