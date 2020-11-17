<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSjListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sj_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_surat_jalan');
            $table->unsignedBigInteger('purchase_list');
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('retur')->default(0);
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
        Schema::dropIfExists('sj_lists');
    }
}
