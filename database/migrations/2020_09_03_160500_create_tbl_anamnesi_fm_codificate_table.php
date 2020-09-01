<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiFmCodificateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_anamnesi_fm_codificate', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('id_anamnesi_fm')->unsigned();
            $table->integer('id_parente')->unsigned();
			$table->string('codice_diag', 7);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_anamnesi_fm_codificate');
	}

}
