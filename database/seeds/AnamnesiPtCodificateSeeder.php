<?php

use Illuminate\Database\Seeder;

class AnamnesiPtCodificateSeeder extends Seeder
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
        
        DB::table('tbl_anamnesi_pt_codificate')->insert([
            'id_anamnesi_pt' => 1,
            'codice_diag' => '001.0',
            'stato' => 'remota'
        ]);

        DB::table('tbl_anamnesi_pt_codificate')->insert([
            'id_anamnesi_pt' => 1,
            'codice_diag' => '001.1',
            'stato' => 'prossima'
        ]);
    }
}
