<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCodiciATCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_codiciATC', function (Blueprint $table) {
            $table->string('id_codiceATC', 8)->primary();
            $table->string('descrizione', 200)->index('descrizione');
            $table->string('destinazione_d_uso', 1)->nullable(); //U - Umano, V - Veterinario, T - Tutti
            $table->string('uso_terapeutico', 200)->nullable();
            $table->integer('livello')->unsigned()->index('ATC_livello');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_codiciATC');
    }
}
