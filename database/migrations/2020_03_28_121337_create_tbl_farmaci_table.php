<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFarmaciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_farmaci', function (Blueprint $table) {
            $table->string('id_farmaco_codifa', 8)->primary();
            $table->string('cod_minsan', 9)->index('cod_minsan');
            $table->string('cod_EMEA', 20)->index('cod_EMEA');
            $table->string('cod_articolo', 13)->index('cod_articolo');
            $table->string('descrizione_breve', 30)->index('descrizione_breve');
            $table->string('descrizione_estesa', 200)->index('descrizione_estesa');
            $table->string('tipo', 3)->nullable(); //F - farmaco, P - parafarmaco, O - omeopatico, M - materia prima, D - dispositivo medico
            $table->date('data_registrazione')->nullable();
            $table->date('data_codifica_EMEA')->nullable();
            $table->date('data_commercializzazione')->nullable();
            $table->string('id_forma_farmaceutica', 8);
            $table->string('id_via_somministrazione', 3);
            $table->integer('q_ta_confezione')->nullable();
            $table->string('id_unita_misura_q_ta', 4)->nullable();
            $table->integer('num_unita_posologiche_rif')->nullable();
            $table->string('val_rif_unita_posologiche', 5)->nullable();
            $table->string('destinazione_duso', 1)->nullable();
            $table->string('id_codiceATC', 8)->index('id_codiceATC');
            $table->string('id_sostanza', 7)->index('id_sostanza')->nullable();
            $table->integer('scadenza')->nullable();
            $table->string('id_unita_misura_scadenza', 4)->nullable();
            $table->string('id_prodotti_identici', 9)->index('id_prodotti_identici')->nullable();
            $table->string('id_codifa_nuovo_prodotto', 8)->nullable();
            $table->string('id_codifa_vecchio_prodotto', 8)->nullable();
            $table->string('numero_reg_PMC', 10)->nullable();
            $table->date('data_reg_PMC')->nullable();
            $table->string('numero_reg_dietetici', 8)->nullable();
            $table->date('data_reg_dietetici')->nullable();
            $table->string('cod_new_minsan_10', 9)->index('cod_new_minsan_10')->nullable();
            $table->string('cod_old_minsan_10', 9)->index('cod_old_minsan_10')->nullable();
            $table->string('id_titolare_AIC', 4)->index('id_titolare_AIC')->nullable();
            $table->string('id_concessionario', 4)->index('id_concessionario')->nullable();
            $table->string('id_gruppo_terrapeutico', 4)->index('id_gruppo_terrapeutico')->nullable();
            $table->string('id_ATC_complementare_somm', 4)->index('id_ATC_complementare_somm')->nullable();
            $table->decimal('capacita_unita_posologica', 12, 2)->nullable();
            $table->string('id_unita_misura_capacita_UP', 4)->index('id_unita_misura_capacita_UP')->nullable();
            $table->boolean('monitoraggio_intensivo')->nullable();
            $table->boolean('quote_spettanza')->nullable();

            $table->foreign('id_forma_farmaceutica')
                  ->references('id_forma_farmaceutica')
                  ->on('tbl_forme_farmaceutiche')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');

            $table->foreign('id_via_somministrazione')
                  ->references('id_via_somministrazione')
                  ->on('tbl_farmaci_tipologie_somm')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');

            $table->foreign('id_codiceATC')
                  ->references('id_codiceATC')
                  ->on('tbl_codiciATC')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');

            $table->foreign('id_sostanza')
                  ->references('id_principio_attivo')
                  ->on('tbl_principi_attivi')
                  ->onUpdate('NO ACTION')
                  ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_farmaci');
    }
}
