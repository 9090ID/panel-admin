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
        Schema::table('buku', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('file_buku'); // Menambahkan kolom status dengan default draft
            $table->string('slug')->unique()->after('status'); // Menambahkan kolom slug yang unik
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('status');
$table->dropColumn('slug');
        });
    }
};
