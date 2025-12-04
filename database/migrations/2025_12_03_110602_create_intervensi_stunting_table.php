<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('intervensi_stunting', function (Blueprint $table) {
            $table->id('id_intervensi');

            // 1. Relasi ke Anak
            $table->foreignId('id_anak')
                  ->constrained('anak', 'id_anak')
                  ->onDelete('cascade');

            // 2. Relasi ke Data Stunting (Nullable)
            $table->foreignId('id_stunting')
                  ->nullable()
                  ->constrained('data_stunting', 'id_stunting')
                  ->onDelete('set null');

            $table->enum('jenis_intervensi', [
                'PMT',
                'Suplemen/Vitamin',
                'Edukasi Gizi',
                'Rujukan RS',
                'Konseling',
                'Lainnya'
            ]);
            
            $table->date('tanggal_pelaksanaan');
            $table->string('dosis_jumlah', 100)->nullable();

            // 3. Relasi ke User (Penanggung Jawab)
            $table->foreignId('penanggung_jawab')
                  ->constrained('users', 'id_user')
                  ->onDelete('cascade');

            $table->text('catatan_perkembangan')->nullable();
            
            $table->enum('status_tindak_lanjut', [
                'Sedang Berjalan',
                'Selesai',
                'Perlu Rujukan Lanjutan'
            ]);
            
            $table->string('file_pendukung')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('intervensi_stunting');
    }
};