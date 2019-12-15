<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warungs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('nama')->unique();
            $table->text('alamat');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warungs');
    }
}
