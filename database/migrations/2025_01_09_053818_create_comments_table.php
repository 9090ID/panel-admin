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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key
            $table->string('name'); // Nama pengirim komentar
            $table->text('comment'); // Isi komentar
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade'); // Mengaitkan komentar dengan artikel
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
