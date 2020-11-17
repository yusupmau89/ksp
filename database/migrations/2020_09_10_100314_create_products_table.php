<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk')->unique();
            $table->enum('jenis_produk', ['Barang', 'Jasa']);
            $table->unsignedBigInteger('kategori'); //contoh: komponen, panel, extension (untuk jenis barang); pengadaan, repair, pembuatan (untuk jenis jasa)
            $table->string('satuan_unit');
            $table->unsignedBigInteger('harga');
            $table->string('drawing')->nullable();
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
        Schema::dropIfExists('products');
    }
}
