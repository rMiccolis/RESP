<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToIndagineDiagnosiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indagine_diagnosi', function (Blueprint $table) {
            $table->foreign('id_indagine', 'indagine_diagnosi_ibfk_1')->references('id_indagine')->on('tbl_indagini')->onupdate("NO ACTION")->ondelete("NO ACTION");
            $table->foreign('id_diagnosi', 'indagine_diagnosi_ibfk_2')->references('id_diagnosi')->on('tbl_diagnosi')->onupdate("NO ACTION")->ondelete("NO ACTION");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indagine_diagnosi', function (Blueprint $table) {
            $table->dropForeign('indagine_diagnosi_ibfk_1');
            $table->dropForeign('indagine_diagnosi_ibfk_2');
        });
    }
}
