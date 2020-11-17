<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRefAlamatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_alamat', function (Blueprint $table) {
            $table->id();
            $table->string('referensi')->unique();
            $table->string('deskripsi');
            $table->timestamps();
        });
        DB::table('ref_alamat')->insert([
            ['referensi'=> strtoupper('pengiriman'), 'deskiripsi' => strtoupper('alamat pengiriman')],
            ['referensi'=> strtoupper('penagihan'), 'deskiripsi' => strtoupper('alamat penagihan')],
            ['referensi'=> strtoupper('kantor'), 'deskiripsi' => strtoupper('alamat kantor')],
            ['referensi'=> strtoupper('toko'), 'deskiripsi' => strtoupper('alamat toko')],
            ['referensi'=> strtoupper('gudang'), 'deskiripsi' => strtoupper('alamat gudang')],
            ['referensi'=> strtoupper('rumah'), 'deskiripsi' => strtoupper('alamat rumah')],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_alamat');
    }
}
