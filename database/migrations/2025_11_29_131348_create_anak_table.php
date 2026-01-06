<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anak', function (Blueprint $table) {
            $table->id('id_anak');
            $table->foreignId('id_posyandu')->constrained('posyandu', 'id_posyandu')->onDelete('cascade');
            $table->foreignId('id_orangtua')->constrained('orang_tua', 'id_orangtua')->onDelete('cascade');
            $table->string('nama_anak', 100);
            
            // PERUBAHAN DISINI:
            // 1. Ubah jadi 'text' agar muat string enkripsi panjang
            // 2. Hapus 'unique()' untuk sementara agar tidak error di database
            $table->text('nik_anak'); 
            
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        // Matikan pengecekan foreign key sementara
        Schema::disableForeignKeyConstraints();
        
        Schema::dropIfExists('anak');
        
        // Hidupkan kembali
        Schema::enableForeignKeyConstraints();
    }
};