<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\Patient\Taccuino;
use App\Models\Log\AuditlogLog;
use App\Models\File;
use App\Models\Model3dMan;
use App\Classes\IPFS;
use \Illuminate\Database\QueryException;
use \Illuminate\Support\Facades\File as FilePHP;
use Storage;
use Validator;
use Redirect;
use Auth;
use DB;
use Input;

class TaccuinoController extends Controller
{

 /*
 *	non aggiunge id visita e id taccuino che verranno aggiunti manualmente dopo 
 */
private function addMan($paziente, $selected_places) {
	$man3d = new Model3dMan;
	if($selected_places != "[]") {
		$man3d->selected_places = $selected_places;
	} else {
		$man3d->selected_places = "empty";
	}
	
	$man3d->id_paziente = $paziente;
	$man3d->id_visita = 0;
	$man3d->id_taccuino = 0;
	$man3d->save();
	// $man3dId = $man3d->id_3d;

	return $man3d;
}

private function addTaccuino($paziente, $descrizione, $data, $front, $back, $drawn_2d, $man3dId) {
	$taccuino = new Taccuino;

	if($descrizione == ""){
		$descrizione = "Nessun commento.";
	}

	$taccuino->id_paziente = $paziente;
	$taccuino->taccuino_descrizione = $descrizione;
	$taccuino->taccuino_data = $data;
	$taccuino->taccuino_report_anteriore = $front;
	$taccuino->taccuino_report_posteriore = $back;
	$taccuino->taccuino_2d_drawn = $drawn_2d;
	$taccuino->id_3d = $man3dId;

	$taccuino->save();
	$idTaccuino = $taccuino->id_taccuino;
	
	Model3dMan::where('id_3d', $man3dId)->update(['id_taccuino' => $idTaccuino]);

	return $idTaccuino;
}


	public function uploadFile($file, $idPaziente, $idLog, $descrizione){
        

        $ipfs = new IPFS("https://ipfs.infura.io", "8080", "5001");

        // $path = Storage::disk('public')->putFileAs("/patient/".$idPaziente, $file, $file->getClientOriginalName(), 'public');
        // $path = storage_path()."/app/public/".$path;
		
		$hash = $ipfs->add($file);
		// dd($hash);
		// $path1 = storage_path()."/app/public/patient/".$idPaziente;
		// $response = FilePHP::deleteDirectory($path1);

		try {
			$file_model = new File;
			$file_model->id_paziente = $idPaziente;
			$file_model->hash = $hash;
			$file_model->id_audit_log = $idLog;
			$file_model->file_nome = $file->getClientOriginalName();
			$file_model->file_commento = $descrizione;
				
			$file_model->save();
		} catch(QueryException $e) { //duplicate entry
			$file_model = DB::table('tbl_files')->where('hash', $hash)->first();
		}
				
        return $file_model->id_file;
	}

		/**
	* Aggiunge una nuova segnalazione all'interno
	* del taccuino del paziente
	*/
	public function addReporting(Request $request){

		$descrizione = Input::get('textarea'); //$request->input('description');
		$front = Input::get('dataURLFront');
		$back = Input::get('dataURLBack');
		$data = Input::get('datan');
		$selected_places = Input::get('meshes');
		
		$paziente = Pazienti::where('id_utente', Auth::id())->first()->id_paziente;
		$drawn_2d = Input::get('drawn_2d');
			
		$man3d = $this->addMan($paziente, $selected_places);
		$idTaccuino = $this->addTaccuino($paziente, $descrizione, $data, $front, $back, $drawn_2d, $man3d->id_3d);
		

		$files = $request->file('files');

		if(!empty($files)) {
			foreach($files as $file) {				
				$id_file = $this->uploadFile($file, $paziente, Input::get('idLog'), $descrizione);
				$man3d->files()->syncWithoutDetaching([
					$id_file => [
						'id_taccuino' => $idTaccuino,
						'id_visita'	  => $man3d->id_visita
					]
					]);
			}
		}

		
		return Redirect::back()->with("Success");
	}

	/**
	* Rimuove un valore tra i record del Taccuino
	*/
	public function removeReporting(){
		$reporting = Taccuino::find(Input::get('id_taccuino'));
		$man = Model3dMan::find($reporting->id_3d);
		
		$file = Model3dMan::find($reporting->id_3d)->files()->get();
		// $file = File::all();
		//dd($file);
		foreach($file as $f){
			// dd($f->men());
			$f->men()->detach($man->id_3d);
		}
		
		$man->delete();

		$reporting->delete();
		return Redirect::back()->with('reporting_deleted');
	}
}
