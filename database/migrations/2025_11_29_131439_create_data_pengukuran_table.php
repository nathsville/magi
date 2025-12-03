<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_pengukuran', function (Blueprint $table) {
            $table->id('id_pengukuran');
            $table->foreignId('id_anak')->constrained('anak', 'id_anak')->onDelete('cascade');
            $table->foreignId('id_posyandu')->constrained('posyandu', 'id_posyandu')->onDelete('cascade');
            $table->foreignId('id_petugas')->constrained('users', 'id_user')->onDelete('cascade');
            $table->date('tanggal_ukur');
            $table->integer('umur_bulan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2);
            $table->decimal('lingkar_lengan', 5, 2);
            $table->string('status_gizi', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_pengukuran');
    }
};