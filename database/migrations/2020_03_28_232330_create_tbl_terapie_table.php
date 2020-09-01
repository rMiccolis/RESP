<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTerapieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_terapie', function (Blueprint $table) {
            $table->increments('id_terapie');
            $table->integer('id_paziente')->unsigned()->index('fk_tbl_terapie_tbl_pazienti1_idx');
            $table->date('dataAggiornamento');
            $table->integer('tipo_terapia')->unsigned()->index('tipo_terapia');
            $table->string('id_farmaco_codifa', 8)->index('id_farmaco_codifa')->nullable();
            $table->date('data_evento')->nullable();
            $table->integer('id_prescrittore')->unsigned()->index('fk_tbl_terapie_tbl_utenti_idx');
            $table->date('data_inizio')->nullable();
            $table->date('data_fine')->nullable();
            $table->integer('id_diagnosi')->unsigned()->index('id_diagnosi')->nullable();
            $table->smallInteger('id_livello_confidenzialita')->index('tbl_livelli_confidenzialita')->nullable();
            $table->longText('note');

            $table->foreign('id_paziente')
                  ->references('id_paziente')
                  ->on('tbl_pazienti')
                  ->onUpdate('NO ACTION')
                  ->onDelete('CASCADE');

            $table->foreign('id_farmaco_codifa')
                  ->references('id_farmaco_codifa')
                  ->on('tbl_farmaci')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');

            $table->foreign('id_prescrittore')
                  ->references('id_utente')
                  ->on('tbl_utenti')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');

            $table->foreign('id_diagnosi')
                  ->references('id_diagnosi')
                  ->on('tbl_diagnosi')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');

            $table->foreign('id_livello_confidenzialita')
                  ->references('id_livello_confidenzialita')
                  ->on('tbl_livelli_confidenzialita')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_terapie');
    }
}
