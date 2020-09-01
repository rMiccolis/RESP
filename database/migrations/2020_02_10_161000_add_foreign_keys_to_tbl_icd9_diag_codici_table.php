<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblIcd9DiagCodiciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_icd9_diag_codici', function(Blueprint $table)
		{
			$table->foreign('codice_categoria', 'fk_tbl_icd9_diag_codici_tbl_icd9_cat_diag_codici1_idx')->references('codice_categoria')->on('tbl_icd9_cat_diag_codici')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_icd9_diag_codici', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_icd9_diag_codici_tbl_icd9_cat_diag_codici1_idx');
		});
	}

}
