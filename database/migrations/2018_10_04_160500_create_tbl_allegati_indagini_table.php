<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAllegatiIndaginiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_allegati_indagini', function (Blueprint $table) {
            $table->integer('id_indagine')->unsigned()->index('id_indagine');
            $table->integer('id_file')->unsigned()->index('id_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_allegati_indagini');
    }
}
