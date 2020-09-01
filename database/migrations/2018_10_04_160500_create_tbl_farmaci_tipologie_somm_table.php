<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFarmaciTipologieSommTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_farmaci_tipologie_somm', function(Blueprint $table)
		{
			$table->string('id_via_somministrazione',3)->primary();
            $table->text('descrizione', 1000)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_farmaci_tipologie_somm');
	}

}
