<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9DiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_diag_codici', function(Blueprint $table)
		{
			$table->string('codice_diag', 7)->nullable()->index('fk_tbl_icd9_diag_codici_idx');
			$table->string('codice_categoria', 4)->nullable()->index('fk_tbl_icd9_diag_codici_tbl_icd9_cat_diag_codici1_idx');
			$table->text('codice_descrizione', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_diag_codici');
	}

}
