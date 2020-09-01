<?php

use Illuminate\Database\Seeder;
use App\Models\Drugs\FormaFarmaceutica;

class FormeFarmaceuticheTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $json = File::get("database/data/FormeFarmaceutiche.json");
      $data = json_decode($json);
      foreach ($data as $obj) {
          FormaFarmaceutica::create(array(
              'id_forma_farmaceutica' => $obj->id_forma_farmaceutica,
              'descrizione' => $obj->descrizione,
          ));
      }
    }
}
