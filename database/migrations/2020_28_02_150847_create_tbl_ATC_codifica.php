<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatetblATCCodifica extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_ATC_codifica', function(Blueprint $table)
		{
			$table->char('Codice_ATC', 7)->primary();
			$table->string('Descrizione', 45)->nullable();
			$table->char('Livello', 1)->nullable();
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
		Schema::drop('tbl_ATC_codifica');
	}

}
