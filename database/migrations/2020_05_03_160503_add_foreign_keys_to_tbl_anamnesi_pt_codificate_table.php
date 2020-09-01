<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblAnamnesiPtCodificateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_anamnesi_pt_codificate', function(Blueprint $table)
		{
			$table->foreign('id_anamnesi_pt', 'tbl_anamnesi_pt_codificate_ibfk_1')->references('id')->on('tbl_anamnesi_pt')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('codice_diag', 'tbl_anamnesi_pt_codificate_ibfk_2')->references('codice_diag')->on('tbl_icd9_diag_codici')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_anamnesi_pt_codificate', function(Blueprint $table)
		{
			$table->dropForeign('tbl_anamnesi_pt_codificate_ibfk_1');
			$table->dropForeign('tbl_anamnesi_pt_codificate_ibfk_2');
		});
	}

}
