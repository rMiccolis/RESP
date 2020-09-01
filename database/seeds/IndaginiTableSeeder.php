<?php
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IndaginiTableSeeder extends Seeder
{
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_indagini')->insert([
               'id_indagine' => 1,
                'id_centro_indagine' => 1,
                'id_paziente' => 2,
                'id_cpp' => 1,
                'careprovider' => 'Bob Kelso',
                'indagine_data' => '2018-02-06',
            'indagine_data_fine' => Carbon::now(new DateTimeZone('Europe/Rome')),
                'indagine_aggiornamento' => '2018-04-03',
                'referto_stato' => 'corrected',
                'indagine_stato' => '2',
            'indagine_issued' => Carbon::now(new DateTimeZone('Europe/Rome')),
                'indagine_category' => 'procedure',
                'indagine_code' => '10155-0',
                'indagine_interpretation'=> 'B',
                'indagine_tipologia' => 'Tipologia indagine 1',
                'indagine_motivo' => 'Motivo indagine 1'
        ]);
        
        DB::table('tbl_indagini')->insert([
               'id_indagine' => 2,
                'id_centro_indagine' => 2,
                'id_paziente' => 2,
                'id_cpp' => 2,
                'careprovider' => 'Pippo Kelso',
                'indagine_data' => '2017-02-06',
            'indagine_data_fine' => Carbon::now(new DateTimeZone('Europe/Rome')),
                'indagine_aggiornamento' => '2017-04-03',
                'referto_stato' => 'final',
            'indagine_stato' => '1',
            'indagine_issued' => Carbon::now(new DateTimeZone('Europe/Rome')),
            'indagine_category' => 'exam',
            'indagine_code' => '10161-8',
            'indagine_interpretation'=> 'D',
            'indagine_tipologia' => 'Tipologia indagine 1',
            'indagine_motivo' => 'Motivo indagine 1'
                ]);
    }
}
