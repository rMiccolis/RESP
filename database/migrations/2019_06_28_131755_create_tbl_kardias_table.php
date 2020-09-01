<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblKardiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardias', function (Blueprint $table) {
            $table->increments('id_kardia');
            $table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx')->onDelete('cascade');
            $table->text('date')->nullable();
            $table->text('filepdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardias');
    }
}
