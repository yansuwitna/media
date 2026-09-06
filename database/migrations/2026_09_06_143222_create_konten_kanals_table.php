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
        Schema::create('konten_kanal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rincian_proyek')->constrained('rincian_proyek')->cascadeOnDelete();
            $table->foreignId('id_lokasi_unggah')->constrained('lokasi_unggah')->cascadeOnDelete();
            $table->string('link_unggahan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konten_kanal');
    }
};
