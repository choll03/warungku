<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('warung_id')->unsigned();
            $table->string('nama');
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->smallInteger('stok')->default(0);
            $table->timestamps();
            $table->foreign('warung_id')->references('id')->on('warungs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
