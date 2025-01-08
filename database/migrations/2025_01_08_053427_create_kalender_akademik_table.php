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
        Schema::create('kalender_akademik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('cascade'); // Relasi ke tahun akademik
            $table->string('nama_event'); // Nama event
            $table->date('tanggal_mulai'); // Tanggal mulai event
            $table->date('tanggal_selesai')->nullable(); // Tanggal selesai event
            $table->text('deskripsi')->nullable(); // Deskripsi event
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalender_akademik');
    }
};
