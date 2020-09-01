<?php

use Illuminate\Database\Seeder;
use App\Models\Drugs\CodiceATC;

class CodiciATCTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $json = File::get("database/data/CodiciATC.json");
      $data = json_decode($json);
      foreach ($data as $obj) {
          CodiceATC::create(array(
              'id_codiceATC' => $obj->id_codiceATC,
              'descrizione' => $obj->descrizione,
              'livello' => $obj->livello
          ));
      }
    }
}
