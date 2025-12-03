<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_master', function (Blueprint $table) {
            // Tambahkan unique constraint pada kolom kode
            $table->unique('kode');
            
            // Tambahkan index untuk performa query
            $table->index('tipe_data');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('data_master', function (Blueprint $table) {
            $table->dropUnique(['kode']);
            $table->dropIndex(['tipe_data']);
            $table->dropIndex(['status']);
        });
    }
};