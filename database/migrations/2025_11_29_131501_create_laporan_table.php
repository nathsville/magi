<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->enum('jenis_laporan', ['Laporan Puskesmas', 'Laporan Daerah']);
            $table->foreignId('id_pembuat')->constrained('users', 'id_user')->onDelete('cascade');
            $table->integer('periode_bulan');
            $table->integer('periode_tahun');
            $table->integer('id_wilayah');
            $table->enum('tipe_wilayah', ['Puskesmas', 'Kabupaten']);
            $table->integer('total_anak')->nullable();
            $table->integer('total_stunting')->nullable();
            $table->integer('total_normal')->nullable();
            $table->decimal('persentase_stunting', 5, 2)->nullable();
            $table->string('file_laporan', 255)->nullable();
            $table->timestamp('tanggal_buat')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};