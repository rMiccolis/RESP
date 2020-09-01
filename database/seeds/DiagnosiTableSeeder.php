<?php
use Illuminate\Database\Seeder;

class DiagnosiTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_diagnosi')->insert([
            [
                'id_diagnosi' => '1',
                'id_paziente' => '2',
                'verificationStatus' => 'provisional',
                'severity' => '24484000',
                'code' => '122003',
                'bodySite' => '106004',
                'stageSummary' => '786005',
                'evidenceCode' => '109006',
                'note' => 'null',
                'diagnosi_inserimento_data' => '2018-03-02',
                'diagnosi_aggiornamento_data' => '2018-03-02',
                'diagnosi_patologia' => 'Influenza',
                'diagnosi_stato' => '2',
                'diagnosi_guarigione_data' => '2018-12-14'
            ]
        ]);

        DB::table('tbl_diagnosi')->insert([
            [
                'id_diagnosi' => '2',
                'id_paziente' => '2',
                'verificationStatus' => 'differential',
                'severity' => '6736007',
                'code' => '127009',
                'bodySite' => '107008',
                'stageSummary' => '1523005',
                'evidenceCode' => '122003',
                'note' => 'null',
                'diagnosi_inserimento_data' => '2017-03-02',
                'diagnosi_aggiornamento_data' => '2017-03-02',
                'diagnosi_patologia' => 'Raffreddore',
                'diagnosi_stato' => '1',
                'diagnosi_guarigione_data' => '2017-12-14'
            ]
        ]);

        DB::table('tbl_diagnosi')->insert([
            [
                'id_diagnosi' => '3',
                'id_paziente' => '2',
                'verificationStatus' => 'refuted',
                'severity' => '255604002',
                'code' => '122003',
                'bodySite' => '106004',
                'stageSummary' => '786005',
                'evidenceCode' => '109006',
                'note' => 'null',
                'diagnosi_inserimento_data' => '2016-03-02',
                'diagnosi_aggiornamento_data' => '2016-03-02',
                'diagnosi_patologia' => 'Mal di gola',
                'diagnosi_stato' => '0',
                'diagnosi_guarigione_data' => '2016-12-14'
            ]
        ]);
      
    }
}
