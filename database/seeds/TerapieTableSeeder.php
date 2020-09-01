<?php

use Illuminate\Database\Seeder;

class TerapieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table ( 'tbl_terapie' )->insert([
        'id_paziente' => '2',
        'dataAggiornamento' => '2020-03-26',
        'tipo_terapia' => '0',
        'id_farmaco_codifa' => '1',
        'data_evento' => '2020-03-26',
        'id_prescrittore' => '1',
        'id_livello_confidenzialita' => '3',
        'note' => 'Allergia grave',
      ]);

      DB::table ( 'tbl_terapie' )->insert ( [
        'id_paziente' => '2',
        'dataAggiornamento' => '2020-03-20',
        'tipo_terapia' => '1',
        'id_prescrittore' => '1',
        'id_farmaco_codifa' => '2',
        'data_inizio' => '2020-03-20',
        'data_fine' => '2020-03-30',
        'id_livello_confidenzialita' => '3',
        'id_diagnosi' => '2',
        'note' => 'Mattina, Mezzogiorno, sera a stomaco pieno',
      ] );

      DB::table ( 'tbl_terapie' )->insert ( [
        'id_paziente' => '2',
        'dataAggiornamento' => '2020-03-1',
        'tipo_terapia' => '2',
        'data_evento' => '2020-03-26',
        'id_prescrittore' => '1',
        'id_farmaco_codifa' => '3',
        'data_inizio' => '2020-03-1',
        'data_fine' => '2020-03-20',
        'id_diagnosi' => '3',
        'id_livello_confidenzialita' => '4',
        'note' => 'Fine Terapia',
      ] );
    }

}