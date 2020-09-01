<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToTblAllegatiIndagineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_allegati_indagini', function (Blueprint $table) {
            $table->foreign('id_indagine', 'tbl_allegati_indagini_ibfk_1')->references('id_indagine')->on('tbl_indagini')->onupdate("CASCADE")->ondelete("CASCADE");
            $table->foreign('Id_file', 'tbl_allegati_indagini_ibfk_2')->references('id_file')->on('tbl_files')->onupdate("CASCADE")->ondelete("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_allegati_indagini', function (Blueprint $table) {
            $table->dropForeign('tbl_allegati_indagini_ibfk_1');
            $table->dropForeign('tbl_allegati_indagini_ibfk_2');
        });
    }
}
