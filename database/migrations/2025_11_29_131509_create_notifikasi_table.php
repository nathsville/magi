<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_stunting')->nullable()->constrained('data_stunting', 'id_stunting')->onDelete('cascade');
            $table->string('judul', 200);
            $table->text('pesan');
            $table->enum('tipe_notifikasi', ['Validasi', 'Peringatan', 'Informasi']);
            $table->enum('status_baca', ['Belum Dibaca', 'Sudah Dibaca'])->default('Belum Dibaca');
            $table->timestamp('tanggal_kirim')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};