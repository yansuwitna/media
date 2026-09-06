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
        Schema::table('rincian_proyek', function (Blueprint $table) {
            $table->string('kode')->nullable()->after('id_proyek');
            $table->integer('urutan')->default(1)->after('kode');
            $table->text('deskripsi')->nullable()->after('nama_item');
            $table->string('tautan_konten')->nullable()->after('status_unggah');
        });
    }

    public function down(): void
    {
        Schema::table('rincian_proyek', function (Blueprint $table) {
            $table->dropColumn(['kode', 'urutan', 'deskripsi', 'tautan_konten']);
        });
    }
};
