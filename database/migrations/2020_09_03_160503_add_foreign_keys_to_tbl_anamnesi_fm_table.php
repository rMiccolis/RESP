<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblAnamnesiFmTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_anamnesi_fm', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'tbl_anamnesi_fm_ibfk_1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_anamnesi_fm', function(Blueprint $table)
		{
			$table->dropForeign('tbl_anamnesi_fm_ibfk_1');
		});
	}

}
