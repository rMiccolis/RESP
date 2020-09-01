<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblTaccuinoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_taccuino', function(Blueprint $table)
		{
			$table->increments('id_taccuino');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_taccuino_tbl_pazienti1_idx');
			$table->longText('taccuino_descrizione')->nullable();
			$table->date('taccuino_data');
			$table->longText('taccuino_report_anteriore');
			$table->longText('taccuino_report_posteriore');
			$table->integer('taccuino_2d_drawn');
            $table->unsignedBigInteger('id_3d')->default('0'); //id of the 3d man insert in taccuino
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_taccuino');
	}

}
