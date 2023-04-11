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
        Schema::create('verbatim', function (Blueprint $table) {
            $table->bigIncrements('id_verbatim');
            $table->bigInteger('id_category')->unsigned()->nullable();
            $table->string('verbatim');
            $table->bigInteger('positif');
            $table->bigInteger('neutre');
            $table->bigInteger('negatif');
            $table->bigInteger('position');
            $table->foreign('id_category')->references('id_category')->on('category')->onDelete('set null');
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
