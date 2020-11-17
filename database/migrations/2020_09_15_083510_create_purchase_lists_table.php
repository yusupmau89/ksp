<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_po');
            $table->unsignedBigInteger('produk');
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('harga');
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('diskon');
            $table->unsignedBigInteger('terkirim');
            $table->unsignedBigInteger('sisa');
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
        Schema::dropIfExists('purchase_lists');
    }
}
