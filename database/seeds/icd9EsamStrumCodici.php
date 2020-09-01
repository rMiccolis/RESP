<?php
use Illuminate\Database\Seeder;

class icd9EsamStrumCodici extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path().'/database/seeds/sql/ICD9EsamStrumCode.sql';
    	$sql = file_get_contents($path);
    	DB::unprepared($sql);
    }
}
