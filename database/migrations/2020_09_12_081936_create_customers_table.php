<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->string('npwp', 20)->nullable()->unique();
            $table->text('alamat_pengiriman');
            $table->text('alamat_penagihan');
            $table->string('email')->unique()->nullable();
            $table->string('no_telepon', 17)->unique()->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('customers');
    }
}
