<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFormeFarmaceuticheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_forme_farmaceutiche', function (Blueprint $table) {
          $table->string('id_forma_farmaceutica', 8)->primary();
          $table->string('descrizione', 200)->index('descrizione');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_forme_farmaceutiche');
    }
}
