<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Admin
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_pengguna')->unique();
            $table->string('email')->unique();
            $table->string('kata_sandi');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabel Operator
        Schema::create('operator', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_pengguna')->unique();
            $table->string('email')->unique();
            $table->string('kata_sandi');
            $table->foreignId('id_admin_pembuat')->nullable()->constrained('admin')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. Tabel Identitas Web
        Schema::create('identitas_web', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi')->default('Media Plan App');
            $table->text('deskripsi_aplikasi')->nullable();
            $table->string('jalur_logo')->nullable();
            $table->string('teks_footer')->default('© 2026 Media Plan. Hak cipta dilindungi.');
            $table->string('tema_bawaan')->default('gelap');
            $table->timestamps();
        });

        // 4. Tabel Lokasi Unggah
        Schema::create('lokasi_unggah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_operator')->constrained('operator')->cascadeOnDelete();
            $table->string('nama_kanal');
            $table->string('tautan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 5. Tabel Proyek
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_operator')->constrained('operator')->cascadeOnDelete();
            $table->string('judul_proyek');
            $table->text('deskripsi_proyek')->nullable();
            $table->date('target_selesai')->nullable();
            $table->enum('status_proyek', ['draf', 'dalam_proses', 'selesai', 'dibatalkan'])->default('draf');
            $table->timestamps();
        });

        // 6. Tabel Rincian Proyek
        Schema::create('rincian_proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyek')->constrained('proyek')->cascadeOnDelete();
            $table->foreignId('id_lokasi_unggah')->nullable()->constrained('lokasi_unggah')->nullOnDelete();
            $table->string('nama_item');
            $table->enum('jenis_media', ['video', 'gambar', 'audio', 'artikel', 'lainnya'])->default('video');
            $table->text('catatan')->nullable();
            $table->enum('status_unggah', ['menunggu', 'siap_unggah', 'terunggah'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rincian_proyek');
        Schema::dropIfExists('proyek');
        Schema::dropIfExists('lokasi_unggah');
        Schema::dropIfExists('identitas_web');
        Schema::dropIfExists('operator');
        Schema::dropIfExists('admin');
    }
};
