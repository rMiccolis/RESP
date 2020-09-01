<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileModel3dman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_model3d', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_3d');
            $table->unsignedBigInteger('id_file');
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
        Schema::dropIfExists('file_model3d');
    }
}
