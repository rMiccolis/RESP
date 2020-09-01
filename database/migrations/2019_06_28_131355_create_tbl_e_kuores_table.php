<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEKuoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_kuores', function (Blueprint $table) {
            $table->increments('id_ekuore');
            $table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx')->onDelete('cascade');
            $table->text('date')->nullable();
            $table->text('fileaudio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_kuores');
    }
}