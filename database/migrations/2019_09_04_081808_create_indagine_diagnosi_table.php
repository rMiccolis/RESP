<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndagineDiagnosiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indagine_diagnosi', function (Blueprint $table) {
            $table->unsignedInteger('id_indagine');
            $table->unsignedInteger('id_diagnosi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indagini_diagnosi');
    }
}
