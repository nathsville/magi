<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id('id_orangtua');
            $table->unsignedBigInteger('id_user');
            $table->string('nik', 16)->unique();
            $table->string('nama_ayah', 100);
            $table->string('nama_ibu', 100);
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('pekerjaan_ayah', 50)->nullable();
            $table->string('pekerjaan_ibu', 50)->nullable();
            $table->string('pendidikan_ayah', 20)->nullable();
            $table->string('pendidikan_ibu', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign key
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('nik');
            $table->index('id_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};