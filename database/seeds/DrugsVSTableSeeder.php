<?php

use Illuminate\Database\Seeder;

class DrugsVSTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 DB::table('tbl_farmaci_tipologie_somm')->insert([
      ['id_via_somministrazione' => 'A','descrizione' => 'Iniettabile endovena
'],
      ['id_via_somministrazione' => 'B','descrizione' => 'Iniettabile intramuscolo
'],
      ['id_via_somministrazione' => 'C','descrizione' => 'Iniettabile intraarteriosa
'],
      ['id_via_somministrazione' => 'D','descrizione' => 'Iniettabile sottocutanea
'],
      ['id_via_somministrazione' => 'E','descrizione' => 'Iniettabile intraperitoneale
'],
      ['id_via_somministrazione' => 'F','descrizione' => 'Iniettabile intraarticolare
'],
      ['id_via_somministrazione' => 'G','descrizione' => 'Iniettabile intratecale
'],
      ['id_via_somministrazione' => 'H','descrizione' => 'Iniettabile IV IM SC
'],
      ['id_via_somministrazione' => 'I','descrizione' => 'Iniettabile IV IM
'],
      ['id_via_somministrazione' => 'J','descrizione' => 'Iniettabile IV SC
'],
      ['id_via_somministrazione' => 'K','descrizione' => 'Iniettabile IM SC
'],
      ['id_via_somministrazione' => 'L','descrizione' => 'Orale
'],
      ['id_via_somministrazione' => 'M','descrizione' => 'Sublinguale
'],
      ['id_via_somministrazione' => 'N','descrizione' => 'Buccale
'],
      ['id_via_somministrazione' => 'O','descrizione' => 'Mucoadesiva
'],
      ['id_via_somministrazione' => 'P','descrizione' => 'Uso topico
'],
      ['id_via_somministrazione' => 'Q','descrizione' => 'Sistema transdermico
'],
      ['id_via_somministrazione' => 'R','descrizione' => 'Oftalmico
'],
      ['id_via_somministrazione' => 'S','descrizione' => 'Nasale
'],
      ['id_via_somministrazione' => 'T','descrizione' => 'Auricolare
'],
      ['id_via_somministrazione' => 'U','descrizione' => 'Per inalazione
'],
      ['id_via_somministrazione' => 'V','descrizione' => 'Gas
'],
      ['id_via_somministrazione' => 'W','descrizione' => 'Per irrigazione
'],
      ['id_via_somministrazione' => 'X','descrizione' => 'Vaginale
'],
      ['id_via_somministrazione' => 'Y','descrizione' => 'Intrauterino
'],
      ['id_via_somministrazione' => 'Z','descrizione' => 'Rettale
'],
    ]);
    }
}