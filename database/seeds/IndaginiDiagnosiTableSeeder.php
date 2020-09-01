<?php

use Illuminate\Database\Seeder;

class IndaginiDiagnosiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('indagine_diagnosi')->insert([
            'id_indagine' => 1,
            'id_diagnosi' => 1
        ]);

        DB::table('indagine_diagnosi')->insert([
            'id_indagine' => 2,
            'id_diagnosi' => 2
        ]);

        DB::table('indagine_diagnosi')->insert([
        'id_indagine' => 2,
        'id_diagnosi' => 3
        ]);
    }
}
