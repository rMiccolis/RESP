<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_indagini', function(Blueprint $table)
		{
			$table->increments('id_indagine');
			$table->integer('id_centro_indagine')->unsigned()->nullable()->index('fk_tbl_indagini_tbl_centri_indagini1_idx');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->integer('id_cpp')->unsigned()->nullable()->index('id_cpp');
			$table->text('careprovider', 65535)->nullable();
			$table->date('indagine_data');
			$table->date('indagine_data_fine');
			$table->date('indagine_aggiornamento');
			$table->string('indagine_issued');
			$table->string('referto_stato', 20)->index('referto_stato')->default('unknown');
			$table->string('indagine_stato',1)->index('indagine_stato')->nullable();
			$table->string('indagine_category', 20)->index('indagine_category')->nullable();
			$table->string('indagine_code', 20)->index('indagine_code')->nullable();
			$table->string('indagine_interpretation', 20)->index('indagine_interpretation')->nullable();
			$table->text('indagine_tipologia', 65535)->nullable();
			$table->text('indagine_motivo', 65535)->nullable();
			$table->integer('indagine_referto')->unsigned()->nullable();
			$table->string('codice_ICD', 7)->index('codice_ICD')->nullable();
			$table->string('codice_LOINC', 10)->index('codice_LOINC')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_indagini');
	}

}
