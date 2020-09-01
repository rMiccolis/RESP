<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_files', function(Blueprint $table)
		{
			$table->foreign('id_audit_log', 'fk_tbl_files_tbl_auditlog_log1_idx')->references('id_audit')->on('tbl_auditlog_log')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_files_tbl_pazienti1_idx')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_files', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_files_tbl_auditlog_log1_idx');
			$table->dropForeign('fk_tbl_files_tbl_pazienti1_idx');
		});
	}

}
