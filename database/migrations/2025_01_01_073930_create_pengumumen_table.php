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
        Schema::create('pengumumen', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('author');
            $table->text('isipengumuman');
            $table->string('file')->nullable(); // File dapat kosong
            $table->date('tanggalpublish');
            $table->unsignedBigInteger('kategoripengumuman_id');
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreign('kategoripengumuman_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumen');
    }
};
