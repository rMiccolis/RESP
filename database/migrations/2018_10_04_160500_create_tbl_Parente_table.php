<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblParenteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_Parente', function(Blueprint $table)
		{
			$table->increments('id_parente');
			$table->integer('id_paziente')->unsigned();
			$table->char('codice_fiscale', 16)->nullable();
/*
			$table->string('nome', 25)->nullable();
			$table->string('cognome', 25)->nullable();
            $table->string('grado_parentela', 25)->nullable();
			$table->string('sesso', 8)->nullable();
			$table->date('data_nascita');
			$table->integer('età');
            $table->text('annotazioni')->nullable();
			$table->boolean('decesso');
			$table->integer('età_decesso');
			$table->date('data_decesso')->nullable();
*/
			$table->text('nome', 25)->nullable();
			$table->text('cognome', 25)->nullable();
			$table->string('sesso', 10)->nullable();
			$table->string('telefono', 11)->nullable();
			$table->string('mail', 150)->nullable();
			$table->date('data_nascita')->nullable();
			$table->integer('eta')->nullable();
			$table->boolean('decesso')->nullable();
			$table->integer('eta_decesso')->nullable();
			$table->date('data_decesso')->nullable();
			$table->string('grado_parentela')->nullable();
			$table->text('annotazioni')->nullable();

		});
		
		
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_Parente');
	}

}
