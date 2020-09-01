<?php

use Illuminate\Database\Seeder;
use App\Models\Diagnosis\StatiDiagnosi;

class StatiDiagnosiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/StatiDiagnosi.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            StatiDiagnosi::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
