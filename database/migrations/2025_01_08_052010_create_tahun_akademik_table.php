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
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->id();
        $table->string('nama_tahun'); // Contoh: "2024-2025"
        $table->string('semester'); // Contoh: "Ganjil" atau "Genap"
        $table->boolean('aktif')->default(false); // Menandakan apakah tahun akademik aktif
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_akademik');
    }
};