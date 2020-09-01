<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblPrincipiAttiviTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_principi_attivi', function(Blueprint $table)
		{
			$table->string('id_principio_attivo', 7)->primary();
			$table->string('descrizione', 200)->nullable()->index('descrizione');
			$table->string('id_cas', 20)->nullable()->index('id_cas');
			$table->string('id_einecs', 9)->nullable()->index('id_einecs');
			$table->string('peso_molecolare', 40)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_principi_attivi');
	}

}
