<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_files', function(Blueprint $table)
		{
			$table->increments('id_file'); //da rimuovere, la chiave diventa hashIPFS
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_files_tbl_pazienti1_idx');
			$table->string('hash', 46);
            //$table->string('nomeFileIPFS', 60);
			$table->integer('id_audit_log')->unsigned()->index('fk_tbl_files_tbl_auditlog_log1_idx');
			$table->string('file_nome', 100)->nullable(); //Nome file oblligatorio con determinate keywords
			$table->text('file_commento', 65535)->nullable();
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
		Schema::drop('tbl_files');
	}

}
