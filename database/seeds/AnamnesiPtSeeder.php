<?php

use Illuminate\Database\Seeder;

class AnamnesiPtSeeder extends Seeder
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

        DB::table('tbl_anamnesi_pt')->insert([
            'id' => 1,
            'id_paziente' => 2,
            'id_anamnesi_remota_log' => 2,
            'id_anamnesi_prossima_log' => 1,
            'dataAggiornamento_anamnesi_prossima' => '2020-04-14',
            'dataAggiornamento_anamnesi_remota' => '2020-04-14',
            'anamnesi_remota_contenuto' => 'Prova anamnesi patologica remota.',
            'anamnesi_prossima_contenuto' => 'Prova anamnesi patologica prossima.'
        ]);

    }
}
