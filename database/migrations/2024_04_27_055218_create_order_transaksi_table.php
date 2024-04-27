<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->date('tanggal_transaksi');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('master_barang');
            $table->string('kode_item');
            $table->string('nama_item');
            $table->integer('kuantitas');
            $table->double('total_harga');
            $table->double('total_harga_ppn');
            $table->unsignedBigInteger('id_vendor');
            $table->foreign('id_vendor')->references('id')->on('master_vendor');
            $table->string('nama_vendor');
            $table->string('email');
            $table->string('nama_bank');
            $table->string('nomor_rekening');
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
        Schema::dropIfExists('order_transaksi');
    }
};
