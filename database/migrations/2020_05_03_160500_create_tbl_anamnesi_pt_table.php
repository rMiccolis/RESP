<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiPtTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_anamnesi_pt', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('id_paziente')->unsigned();
						$table->integer('id_anamnesi_remota_log')->unsigned()->nullable();
						$table->integer('id_anamnesi_prossima_log')->unsigned()->nullable();
						$table->date('dataAggiornamento_anamnesi_remota')->nullable();
						$table->date('dataAggiornamento_anamnesi_prossima')->nullable();
			$table->timestamps();
			$table->text('anamnesi_remota_contenuto', 65535)->nullable();
            $table->text('anamnesi_prossima_contenuto', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_anamnesi_pt');
	}

}
