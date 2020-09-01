<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblVaccinazioneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_vaccinazione', function(Blueprint $table)
		{
			$table->increments('id_vaccinazione');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_vaccinazione_tbl_pazienti1_idx');
			$table->unsignedInteger('id_vaccino');
			$table->string('vaccinazione_reazioni');
            $table->string('vaccinazione_richiamo');
			$table->string('vaccineCode', 10)->nullable()->index('vaccineCode');
			$table->date('vaccinazione_data');
			$table->string('vaccinazione_aggiornamento', 45)->nullable();
			$table->string('vaccinazione_stato', 20)->index('vaccinazione_stato');
			$table->boolean('vaccinazione_notGiven');
			$table->integer('vaccinazione_quantity');
			$table->char('vaccinazione_route', 10)->nullable()->index('vaccinazione_route');
			$table->string('vaccinazione_note', 45)->nullable();
			$table->boolean('vaccinazione_primarySource');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_vaccinazione');
	}

}
