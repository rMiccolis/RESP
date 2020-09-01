<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIcd9CatDiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_icd9_cat_diag_codici', function(Blueprint $table)
		{
			$table->string('codice_categoria', 4)->nullable()->index('fk_tbl_icd9_cat_diag_codici_idx');
			$table->string('codice_blocco', 7)->nullable()->index('fk_tbl_icd9_cat_diag_codici_tbl_icd9_bloc_diag_codici1_idx');
			$table->text('categoria_cod_descrizione', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_icd9_cat_diag_codici');
	}

}
