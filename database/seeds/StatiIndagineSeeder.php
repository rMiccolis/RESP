<?php

use Illuminate\Database\Seeder;
use App\Models\StatiIndagine;

class StatiIndagineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/StatiIndagine.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            StatiIndagine::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
