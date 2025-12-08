<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intervensi_stunting', function (Blueprint $table) {
            $table->id('id_intervensi');
            $table->unsignedBigInteger('id_anak');
            $table->enum('jenis_intervensi', [
                'PMT', 
                'Suplemen/Vitamin', 
                'Edukasi Gizi', 
                'Rujukan RS', 
                'Konseling', 
                'Lainnya'
            ]);
            $table->text('deskripsi');
            $table->date('tanggal_pelaksanaan');
            $table->string('dosis_jumlah', 100)->nullable();
            $table->unsignedBigInteger('id_petugas');
            $table->enum('status_tindak_lanjut', [
                'Sedang Berjalan', 
                'Selesai', 
                'Perlu Rujukan Lanjutan'
            ])->default('Sedang Berjalan');
            $table->text('catatan')->nullable();
            $table->string('file_pendukung')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('id_anak')->references('id_anak')->on('anak')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id_user')->on('users')->onDelete('restrict');
            
            // Indexes
            $table->index('id_anak');
            $table->index('jenis_intervensi');
            $table->index('status_tindak_lanjut');
            $table->index('tanggal_pelaksanaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intervensi_stunting');
    }
};