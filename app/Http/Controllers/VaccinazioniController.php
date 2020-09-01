<?php
namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CareProviders\CppPaziente;
use App\Models\CurrentUser\User;
use App\Models\Vaccine\Vaccini;
use App\Models\Vaccine\Vaccinazione;
use App\Models\Patient\Pazienti;

class VaccinazioniController extends Controller
{
	/*
	* Gestisce l'aggiunta di una nuova vaccinazione
	*/
    public function addVaccinazione($vacc, $data, $reazione, $richiamo, $idPaz, $cpp){
			
			$today = getdate();
			
			$anno = $today["year"];
			$mese = $today["mon"];
			$giorno = $today["mday"];
			
			//viene aggiunto lo 0 davanti al giorno ed al mese se questo è inferiore a 10
			if ($today["mon"] < 10) {
				$mese = "0" . $today["mon"];
			}
			
			if ($today["mday"] < 10) {
				$giorno = "0" . $today["mday"];
			}
			
			$dataAgg = $anno . "-" . $mese . "-" . $giorno;
			
			$vaccinazione;
			//se è un careprovider ad effettuare l'inserimento salvo anche il suo id altrimenti salvo 0 
			if ($cpp != -1){
				$vaccinazione = Vaccinazione::create([
			   'id_paziente' => $idPaz,
               'id_vaccino' => $vacc+1,
			   'id_cpp' => $cpp,
			   'vaccinazione_data' => $data,
			   'vaccinazione_reazioni' => $reazione,
			   'vaccinazione_aggiornamento' => $dataAgg,
               'vaccinazione_stato' => 'completed',
			   'vaccinazione_richiamo' => $richiamo
			   ]);
			} else {
				$vaccinazione = Vaccinazione::create([
			   'id_paziente' => $idPaz,
               'id_vaccino' => $vacc+1,
			   'id_cpp' => 0,
			   'vaccinazione_data' => $data,
			   'vaccinazione_reazioni' => $reazione,
			   'vaccinazione_aggiornamento' => $dataAgg,
                'vaccinazione_stato' => 'completed',
			   'vaccinazione_richiamo' => $richiamo
			   ]);
			}

			   
				$vaccinazione->save();
				return Redirect::back();
		} 
	
	/*
	* Gestisce la modifica della vaccinazione selezionata
	*/
	public function modVaccinazione($vacc, $data, $reazione, $richiamo, $idVacc){
		
		$today = getdate();
		
		$anno = $today["year"];
		$mese = $today["mon"];
		$giorno = $today["mday"];
		//viene aggiunto lo 0 davanti al giorno ed al mese se questo è inferiore a 10
		if ($today["mon"] < 10) {
			$mese = "0" . $today["mon"];
		}
		
		if ($today["mday"] < 10) {
			$giorno = "0" . $today["mday"];
		}
		
		$dataAgg = $anno . "-" . $mese . "-" . $giorno;
		
		$match = [
			'id_vaccinazione' => $idVacc
		];
		
		$editVaccinazione = \DB::table('tbl_vaccinazione')->where($match)->update([
	   'id_vaccino' => $vacc+1,
	   'vaccinazione_data' => $data,
	   'vaccinazione_reazioni' => $reazione,
	   'vaccinazione_aggiornamento' => $dataAgg,
	   'vaccinazione_richiamo' => $richiamo
		]);
		   
		return Redirect::back();
	} 
       
	/**
     * Gestice l'eliminazione della vaccinazione selezionata
     */
    public function delVaccinazione($idVacc){
        
		$match = [
            'id_vaccinazione' => $idVacc
        ];
        
        $deleteVaccinazione = \DB::table('tbl_vaccinazione')->where($match)->delete();
        
        return Redirect::back();
    }
}
?>