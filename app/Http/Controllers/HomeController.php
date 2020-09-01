<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Patient\Taccuino;
use App\Models\Patient\Pazienti;
use App\Models\Model3dMan;
use App\Models\Log\AuditlogLog;
use App\Controllers\PazienteController;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware ( 'auth' );
		// \App\Http\Controllers\CookieController::setCookie();
	}

	/*
    * Costruisce un nuovo record log per la pagina che si sta per visualizzare
    */
	public function buildLog($actionName, $ip, $id_visiting){
		
        $log = AuditlogLog::create([ 'audit_nome' => $actionName,
            'audit_ip' => $ip,
            'id_visitato' => $id_visiting,
            'id_visitante' => Auth::user()->id_utente,
            'audit_data' => date('Y-m-d H:i:s'),
        ]);

        $bool=$log->save();

        return $log;
    }	
	
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(\Illuminate\Http\Request $request) {
		$user = Auth::user ();
		if($user->isImpersonating()) {
			if($request->route()->named('patient-home')) {
				return redirect()->route('patient-summary');
			}
			else {
				$user->stopImpersonating();
			}
		}

		if ($user->getRole () == $user::PATIENT_ID) { // Dovrebbe essere il paziente
			$paziente = $user->patient ()->first ()->id_paziente;
			$records = Taccuino::where ( 'id_paziente', $paziente )->get ();
			$men3D = Model3dMan::where([
				['id_paziente', '=', $paziente],
				['id_taccuino', '<>', 0]
			])->get();
			$id_visiting = Auth::user()->id_utente;
			$idLog = $this->buildLog('Files', $request->ip(), $id_visiting);
			$userFiles = [];
        	foreach($men3D as $man){
            // dd($man->files()->first()->pivot);
            if($man->files()->first() != null) {
                $fi = $man->files()->get();
                foreach($fi as $f){
                    array_push($userFiles, $f);
                    
                }
            }
        }
        $number = count($userFiles);
		return view ( 'pages.taccuino' )->with ( ['records' => $records, 'men3D'=> $men3D, 'idLog' => $idLog, 'userFiles' => $userFiles, 'number' => $number] );




		} else if ($user->getRole () == $user::CAREPROVIDER_ID) {
			return redirect ()->route ( 'patients-list' );
		} else if ($user->getRole () == $user::EMERGENCY_ID) {
			return redirect ()->route ( 'search-patient' );
		} 
		else if ($user->getRole () == $user::AMMINISTRATORI_ID) {
			return redirect ()->route ( 'amm' );
		}
		
		return "Login Error Occured";
	}
}
