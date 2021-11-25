<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('pesan');
            $table->text('private_pesan');
            $table->binary('image');
            $table->unsignedBigInteger('id_pengirim');
            $table->foreign('id_pengirim')->references('id')->on('users');
            $table->unsignedBigInteger('id_penerima');
            $table->foreign('id_penerima')->references('id')->on('users');
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
        Schema::dropIfExists('messages');
    }
}
