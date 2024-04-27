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
        Schema::create('master_vendor', function (Blueprint $table) {
            $table->id();
            $table->string('kode_vendor')->unique();;
            $table->string('nama_vendor');
            $table->text('alamat_vendor');
            $table->string('email')->unique();
            $table->string('telepon');
            $table->unsignedBigInteger('id_bank');
            $table->foreign('id_bank')->references('id')->on('master_bank');
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
        Schema::dropIfExists('master_vendor');
    }
};
