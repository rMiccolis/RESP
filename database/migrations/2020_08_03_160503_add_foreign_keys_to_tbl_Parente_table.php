<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblParenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_Parente', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'tbl_Parente_ibfk_1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_anamnesi_pt', function(Blueprint $table)
		{
			$table->dropForeign('tbl_Parente_ibfk_1');
		});
	}

}
