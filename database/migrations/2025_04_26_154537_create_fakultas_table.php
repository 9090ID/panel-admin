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
        Schema::create('fakultas', function (Blueprint $table) {
            $table->id();
            $table->string('namafakultas');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->string('fotofakultas')->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('dekan_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};
