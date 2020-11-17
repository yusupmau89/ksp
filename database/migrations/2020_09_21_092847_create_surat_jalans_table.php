<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratJalansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_jalans', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat_jalan')->unique();
            $table->date('tanggal_surat_jalan');
            $table->unsignedBigInteger('nomor_po');
            $table->unsignedBigInteger('nomor_invoice')->nullable();
            $table->string('kendaraan')->nullable();
            $table->string('plat_no')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('signed_by');
            $table->unsignedBigInteger('created_by');
            $table->string('slug');
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
        Schema::dropIfExists('surat_jalans');
    }
}
