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
        Schema::create('dialogue', function (Blueprint $table) {
            $table->bigIncrements('id_dialogue');
            $table->bigInteger('id_verbatim')->unsigned()->nullable();
            $table->string('dialogue');
            $table->bigInteger('positif');
            $table->bigInteger('neutre');
            $table->bigInteger('negatif');
            $table->foreign('id_verbatim')->references('id_verbatim')->on('verbatim');
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
        Schema::dropIfExists('verbatim');
    }
};
