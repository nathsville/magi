<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_stunting', function (Blueprint $table) {
            $table->id('id_stunting');
            
            $table->foreignId('id_pengukuran')->constrained('data_pengukuran', 'id_pengukuran')->onDelete('cascade');
            
            $table->enum('status_stunting', ['Normal', 'Stunting Ringan', 'Stunting Sedang', 'Stunting Berat']);
            
            // Decimal untuk menyimpan nilai Z-Score (misal: -2.15)
            $table->decimal('zscore_tb_u', 5, 2);
            $table->decimal('zscore_bb_u', 5, 2);
            $table->decimal('zscore_bb_tb', 5, 2);
            
            $table->enum('status_validasi', ['Pending', 'Validated', 'Rejected'])->default('Pending');
            
            // Validator bisa null jika status masih pending
            $table->foreignId('id_validator')->nullable()->constrained('users', 'id_user')->onDelete('set null');
            
            $table->timestamp('tanggal_validasi')->nullable();
            $table->text('catatan_validasi')->nullable();
            
            // PERBAIKAN: Gunakan timestamps() agar ada created_at DAN updated_at
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_stunting');
    }
};