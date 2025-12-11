<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // BAGIAN 1: Buat Tabel Posyandu Dulu
        Schema::create('posyandu', function (Blueprint $table) {
            $table->id('id_posyandu'); // Primary Key
            $table->string('nama_posyandu', 100);
            
            // Pastikan tabel 'puskesmas' sudah dibuat sebelum migrasi ini jalan
            $table->foreignId('id_puskesmas')
                  ->constrained('puskesmas', 'id_puskesmas')
                  ->onDelete('cascade');
            
            $table->text('alamat')->nullable();
            $table->string('kelurahan', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // BAGIAN 2: Edit Tabel Users (Menambahkan Kolom Penghubung)
        // Kita melakukannya di sini agar tidak perlu file migrasi terpisah
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom id_posyandu setelah kolom role
            $table->unsignedBigInteger('id_posyandu')->nullable()->after('role');

            // Menambahkan Foreign Key: users.id_posyandu -> posyandu.id_posyandu
            $table->foreign('id_posyandu')
                  ->references('id_posyandu')
                  ->on('posyandu')
                  ->onDelete('set null'); // Jika posyandu dihapus, user tetap ada tapi id_posyandu jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Hapus relasi di tabel users dulu
        Schema::table('users', function (Blueprint $table) {
            // Cek jika kolom ada sebelum drop untuk menghindari error
            if (Schema::hasColumn('users', 'id_posyandu')) {
                // Drop Foreign Key (Nama default biasanya users_id_posyandu_foreign)
                // Kita gunakan array syntax agar Laravel mencari nama index otomatis
                $table->dropForeign(['id_posyandu']);
                $table->dropColumn('id_posyandu');
            }
        });

        // 2. Baru hapus tabel posyandu
        Schema::dropIfExists('posyandu');
    }
};