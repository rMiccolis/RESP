<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblIcd9CatDiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_icd9_cat_diag_codici', function(Blueprint $table)
		{
			$table->foreign('codice_blocco', 'fk_tbl_icd9_cat_diag_codici_tbl_icd9_bloc_diag_codici1_idx')->references('codice_blocco')->on('tbl_icd9_bloc_diag_codici')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_icd9_cat_diag_codici', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_icd9_cat_diag_codici_tbl_icd9_bloc_diag_codici1_idx');
		});
	}

}
