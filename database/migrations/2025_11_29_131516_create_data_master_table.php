<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_master', function (Blueprint $table) {
            $table->id('id_master');
            $table->string('tipe_data', 50);
            $table->string('kode', 20);
            $table->string('nilai', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_master');
    }
};