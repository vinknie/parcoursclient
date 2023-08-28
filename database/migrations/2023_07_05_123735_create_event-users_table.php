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
          Schema::create('event-users', function (Blueprint $table) {
            $table->BigIncrements('id_event-users');
         
            $table->bigInteger('id_user')->unsigned()->nullable();
            $table->bigInteger('id_event')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_event')->references('id_event')->on('event');
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
        //
    }
};
