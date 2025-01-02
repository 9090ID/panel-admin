<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePengumumenAndCreatePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Hapus foreign key constraint sebelum menghapus kolom
        Schema::table('pengumumen', function (Blueprint $table) {
            if (Schema::hasColumn('pengumumen', 'kategoripengumuman_id')) {
                $table->dropForeign(['kategoripengumuman_id']); // Hapus foreign key constraint
                $table->dropColumn('kategoripengumuman_id');   // Hapus kolom
            }
        });

        // Buat tabel pivot pengumuman_category
        Schema::create('pengumuman_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengumuman_id')->constrained('pengumumen')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Tambahkan kembali kolom kategoripengumuman_id ke tabel pengumumen
        Schema::table('pengumumen', function (Blueprint $table) {
            if (!Schema::hasColumn('pengumumen', 'kategoripengumuman_id')) {
                $table->unsignedBigInteger('kategoripengumuman_id')->nullable();
                $table->foreign('kategoripengumuman_id')->references('id')->on('categories')->onDelete('cascade');
            }
        });

        // Hapus tabel pivot pengumuman_category
        Schema::dropIfExists('pengumuman_category');
    }
}
