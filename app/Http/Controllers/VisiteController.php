<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CppPaziente;
use App\Models\Patient\PazientiVisite;
use App\Models\Log\AuditlogLog;
use App\Models\Patient\ParametriVitali;
use App\Models\CurrentUser\User;
use App\Models\CurrentUser\Recapiti;
use App\Models\Domicile\Comuni;
use App\Models\Patient\Taccuino;
use App\Models\File;
use App\Models\Model3dMan;
use MongoDB\BSON\Javascript;
use App\Classes\IPFS;
use \Illuminate\Support\Facades\File as FilePHP;
use Validator;
use DateTime;
use Storage;
use Redirect;
use Auth;
use DB;
use Input;
use Session;

class VisiteController extends Controller
{

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

public function uploadFile($file, $idPaziente, $idLog, $descrizione){
        

    $ipfs = new IPFS("https://ipfs.infura.io", "8080", "5001");

    // $path = Storage::disk('public')->putFileAs("/patient/".$idPaziente, $file, $file->getClientOriginalName(), 'public');
    // $path = storage_path()."/app/public/".$path;
    
    $hash = $ipfs->add($file);
    // $hash = $ipfs->add($path);
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
     * Funzione che permette di aggiungere una nuova visita
     */
    public function addVisita(Request $request)
    {

        //$paziente = Pazienti::where('id_paziente', Auth::id())->first()->id_paziente;
        $paziente = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $prova = CppPaziente::all();

        foreach($prova as $p){
            if($p->id_paziente == $paziente){
                $cpp = $p->id_cpp;
            }
        }

        $files = $request->file('files');
        // dd($files);

        // dd(Input::all());
        $validator = Validator::make(Input::all(), [
            'add_visita_data' => 'required|date_format:Y-m-d',
            'add_visita_motivazione' => 'required|string',
            'add_visita_osservazioni' =>'required|string',
            'add_visita_conclusioni' =>'required|string',
            'add_parametro_altezza'=>'required|integer',
            'add_parametro_peso'=>'required|integer',
            'add_parametro_pressione_minima'=>'required|integer',
            'add_parametro_pressione_massima'=>'required|integer',
            'add_parametro_frequenza_cardiaca'=>'required|integer'
        ]);


        

        if ($validator->fails()) {
            // dd($validator);
            return Redirect::back()->withErrors($validator);
        }

        $selected_places = Input::get('meshes');
        $man3d = $this->addMan($paziente, $selected_places);

        $visita = new PazientiVisite;
        $visita->id_paziente = $paziente;
        $visita->status = 'finished';
        $visita->class = 'AMB';
        $visita->start_period = Input::get('add_visita_data');
        $visita->end_period = Input::get('add_visita_data');
        $visita->reason = 109006;
        $visita->id_cpp = $cpp;
        $visita->visita_data = Input::get('add_visita_data');
        $visita->visita_motivazione = Input::get('add_visita_motivazione');
        $visita->visita_osservazioni = Input::get('add_visita_osservazioni');
        $visita->visita_conclusioni= Input::get('add_visita_conclusioni');
        $visita->codice_priorita = 1;
        $visita->id_3d = $man3d->id_3d;
        $visita->commento = Input::get('descrizione');

        // dd(Input::get('descrizione'));


        // $visita = PazientiVisite::create([

        //     'id_paziente'=> $paziente,
        //     'status'=>'finished',      //see encounterStatus table
        //     'class' => 'AMB',              //see encounterClass table
        //     'start_period'=> Input::get('add_visita_data'),
        //     'end_period'=>Input::get('add_visita_data'),
        //     'reason'=>109006,      //see encounterReason table
        //     'id_cpp'=> $cpp,
        //     'visita_data'=> Input::get('add_visita_data'),
        //     'visita_motivazione'=> Input::get('add_visita_motivazione'),
        //     'visita_osservazioni'=>Input::get('add_visita_osservazioni'),
        //     'visita_conclusioni'=>Input::get('add_visita_conclusioni'),
        //     'codice_priorità'=>1,
        //     'id_3d'=>$man3d->id_3d
        // ]);
        
        
        
        $paz = Pazienti::all();
        $audit = AuditlogLog::all();

        foreach($paz as $p){
            foreach($audit as $a){
                if($p->id_utente == $a->id_visitato){
                    $f=$a->id_audit;

                }
            }
        }
        
        $date = Input::get('add_visita_data');
        
        // dd($date);
        





        $parametri = ParametriVitali::Create([
            'id_paziente'=> Pazienti::where('id_utente', Auth::id())->first()->id_paziente,
            'id_audit_log'=>$f,
            'parametro_altezza'=> Input::get('add_parametro_altezza'),
            'parametro_peso'=> Input::get('add_parametro_peso'),
            'parametro_pressione_minima'=> Input::get('add_parametro_pressione_minima'),
            'parametro_pressione_massima'=> Input::get('add_parametro_pressione_massima'),
            'parametro_frequenza_cardiaca'=> Input::get('add_parametro_frequenza_cardiaca'),
            'data' => $date,
        ]);


        $parametri->save();
        $visita->save();

        // dd($visita->id_visita);

Model3dMan::where('id_3d', $man3d->id_3d)->update(['id_visita' => $visita->id_visita]);

$descrizione = Input::get('descrizione');
$idLog = Input::get('idLog');
        if(!empty($files)) {
			foreach($files as $file) {				
                $id_file = $this->uploadFile($file, $paziente, $idLog, $descrizione);
                $idTaccuino = Model3dMan::where('id_3d', $man3d->id_3d)->first();
                // dd($idTaccuino->id_taccuino);
                $idTaccuino =  $idTaccuino->id_taccuino;
                $man3d->files()->syncWithoutDetaching([
					$id_file => [
						'id_taccuino' => $idTaccuino,
						'id_visita'	  => $visita->id_visita
					]
					]);
			}
		}

        

        return Redirect::back()->with('visita_added');
    }

}
