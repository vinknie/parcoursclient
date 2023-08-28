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
        Schema::create('category-event', function (Blueprint $table) {
            $table->BigIncrements('id_category-event');
         
            $table->bigInteger('id_category')->unsigned()->nullable();
            $table->bigInteger('id_event')->unsigned()->nullable();
            $table->foreign('id_category')->references('id_category')->on('category');
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
