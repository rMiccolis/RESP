<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiFmTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_anamnesi_fm', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('id_paziente')->unsigned();
						$table->integer('id_anamnesi_log')->unsigned()->nullable();
						$table->date('dataAggiornamento')->nullable();
			$table->timestamps();
			$table->text('anamnesi_familiare_contenuto', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_anamnesi_fm');
	}

}
