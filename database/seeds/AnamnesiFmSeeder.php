<?php

use Illuminate\Database\Seeder;

class AnamnesiFmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		/**
		* Popola il database con dati di prova.
	   */

        DB::table('tbl_anamnesi_fm')->insert([
            'id' => 1,
            'id_paziente' => 2,
            'id_anamnesi_log' => 2,
            'dataAggiornamento' => '2020-04-14',
            'anamnesi_familiare_contenuto' => 'Prova anamnesi patologica familiare.'
        ]);

    }
}
