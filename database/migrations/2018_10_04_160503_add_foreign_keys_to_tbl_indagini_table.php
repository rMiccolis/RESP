<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_indagini', function(Blueprint $table)
		{
			$table->foreign('id_centro_indagine', 'fk_tbl_indagini_tbl_centri_indagini1_idx')->references('id_centro')->on('tbl_centri_indagini')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_cpp', 'tbl_indagini_ibfk_1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('id_paziente', 'tbl_indagini_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('referto_stato', 'tbl_indagini_ibfk_3')->references('Code')->on('ObservationStatus')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('indagine_stato', 'tbl_indagini_ibfk_4')->references('Code')->on('StatiIndagine')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('indagine_category', 'tbl_indagini_ibfk_5')->references('Code')->on('ObservationCategory')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('indagine_code', 'tbl_indagini_ibfk_6')->references('Code')->on('ObservationCode')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('indagine_interpretation', 'tbl_indagini_ibfk_7')->references('Code')->on('ObservationInterpretation')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('indagine_referto', 'tbl_indagini_ibfk_8')->references('id_file')->on('tbl_files')->onUpdate('CASCADE')->onDelete('SET NULL');
			$table->foreign('codice_ICD', 'tbl_indagini_ibfk_9')->references('esame_codice')->on('tbl_icd9_esami_strumenti_codici')->onUpdate('CASCADE')->onDelete('SET NULL');
			$table->foreign('codice_LOINC', 'tbl_indagini_ibfk_10')->references('codice_loinc')->on('tbl_loinc')->onUpdate('CASCADE')->onDelete('SET NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_indagini', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_indagini_tbl_centri_indagini1_idx');
			$table->dropForeign('tbl_indagini_ibfk_1');
			$table->dropForeign('tbl_indagini_ibfk_2');
			$table->dropForeign('tbl_indagini_ibfk_3');
            $table->dropForeign('tbl_indagini_ibfk_4');
            $table->dropForeign('tbl_indagini_ibfk_5');
            $table->dropForeign('tbl_indagini_ibfk_6');
            $table->dropForeign('tbl_indagini_ibfk_7');
            $table->dropForeign('tbl_indagini_ibfk_8');
            $table->dropForeign('tbl_indagini_ibfk_9');
            $table->dropForeign('tbl_indagini_ibfk_10');
		});
	}

}
