<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSambutanPejabatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sambutan_pejabat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->text('isisambutan');
            $table->text('riwayathidup')->nullable();
            $table->date('tglmulaimenjabat');
            $table->date('akhirjabatan');
            $table->string('fotopejabat')->nullable();
            $table->timestamps();

            // Relasi dengan tabel pegawai
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            // Relasi dengan tabel jabatan
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sambutan_pejabat');
    }
}
