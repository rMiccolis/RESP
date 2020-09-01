<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModel3dMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model3d_men', function (Blueprint $table) {
            $table->increments('id_3d');
            $table->longText('selected_places');
            $table->unsignedBigInteger('id_paziente');
            $table->unsignedBigInteger('id_taccuino');
            $table->unsignedBigInteger('id_visita');
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
        Schema::dropIfExists('model3d_men');
    }
}
