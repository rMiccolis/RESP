<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblVaccinazioneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_vaccinazione', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'fk_tbl_vaccinazione_tbl_pazienti1_idx')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');

			$table->foreign('vaccineCode', 'tbl_vaccinazione_ibfk_2')->references('Code')->on('ImmunizationVaccineCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vaccinazione_stato', 'tbl_vaccinazione_ibfk_3')->references('Code')->on('ImmunizationStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('vaccinazione_route', 'tbl_vaccinazione_ibfk_4')->references('Code')->on('ImmunizationRoute')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            //$table->foreign('id_vaccino', 'fk_tbl_vaccini')->references('id_vaccino')->on('tbl_vaccini')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_vaccinazione', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_vaccinazione_tbl_pazienti1_idx');
            $table->dropForeign('fk_tbl_vaccini');
			$table->dropForeign('tbl_vaccinazione_ibfk_1');
			$table->dropForeign('tbl_vaccinazione_ibfk_2');
			$table->dropForeign('tbl_vaccinazione_ibfk_3');
			$table->dropForeign('tbl_vaccinazione_ibfk_4');
		});
	}

}
