<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_po')->unique();
            $table->date('tanggal_po');
            $table->date('tanggal_kirim');
            $table->unsignedBigInteger('customer_id');
            $table->string('top');
            $table->unsignedBigInteger('ppn');
            $table->unsignedBigInteger('diskon');
            $table->unsignedBigInteger('grand_total');
            $table->enum('status',['On Progress', 'Partially Delivered', 'Partially Invoiced', 'Completed']);
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
        Schema::dropIfExists('purchase_orders');
    }
}
