<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->date('tanggal_invoice');
            $table->unsignedBigInteger('nomor_po');
            $table->boolean('down_payment');
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('diskon')->default(0);
            $table->unsignedBigInteger('ppn')->default(0);
            $table->enum('status', ['Invoiced', 'Paid']);
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('signed_by');
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
        Schema::dropIfExists('invoices');
    }
}
