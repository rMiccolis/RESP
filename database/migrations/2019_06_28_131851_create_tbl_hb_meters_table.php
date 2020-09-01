<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblHbMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_meters', function (Blueprint $table) {
            $table->increments('id_hbmeter');
            $table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx')->onDelete('cascade');
            $table->string('analisi_giorno')->nullable();
            $table->string('analisi_valore')->nullable();
            $table->string('analisi_laboratorio')->nullable();
            $table->text('img_palpebra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_meters');
    }
}

