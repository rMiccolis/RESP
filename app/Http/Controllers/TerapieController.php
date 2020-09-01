<?php
namespace App\Http\Controllers;

use Illuminate\ Http\ Request;
use App\ Http\ Controllers\ Controller;
use App\Models\Patient\Pazienti;
use App\Models\CurrentUser\User;
use App\Models\Drugs\Terapie;
use App\Models\Drugs\Farmaci;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\CareProviders\CppPaziente;

use Validator;
use Redirect;
use Auth;
use DB;
use Input;
use Session;


class TerapieController extends Controller
{

  /**
  * ritorna alla modal info sulla terapia per la modfica (JQUERY)
  */
  public function getTerapia($id, $tipoTP){

    $id_user = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

    $terapia = Terapie::find($id);

    if($id_user === $terapia->id_paziente){

      if($tipoTP == 0) {
        return response()->json(['id_terapie' => $terapia->id_terapie,
        'id_farmaco' => $terapia->id_farmaco_codifa,
        'tipo_terapia' => $terapia->tipo_terapia,
        'somministrazione' => $terapia->getFarmaco()->getTipologiaSomministrazione(),
        'forma_farmaceutica' => $terapia->getFarmaco()->getFormaFarmaceutica(),
        'id_diagnosi' => $terapia->id_diagnosi,
        'verificatosi' => $terapia->data_evento->format('Y-m-d'),
        'livello_confidenzialita' => $terapia->id_livello_confidenzialita,
        'note' => $terapia->note
      ]);


    }
    if($tipoTP == 1 || $tipoTP == 2) {
      return response()->json([
        'id_terapie' => $terapia->id_terapie,
        'id_farmaco' => $terapia->id_farmaco_codifa,
        'tipo_terapia' => $terapia->tipo_terapia,
        'somministrazione' => $terapia->getFarmaco()->getTipologiaSomministrazione(),
        'forma_farmaceutica' => $terapia->getFarmaco()->getFormaFarmaceutica(),
        'dataInizio' => $terapia->data_inizio->format('Y-m-d'),
        'dataFine' => $terapia->data_fine->format('Y-m-d'),
        'diagnosi' => $terapia->id_diagnosi,
        'livello_confidenzialita' => $terapia->id_livello_confidenzialita,
        'note' => $terapia->note
      ]);
    }
  }
}

/**
* ritorna terapie trovate
*/
public function searchTerapia($tipo, $txtSearch){

  $id_user = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

  $confidenzialita_auth = Auth::user()->isImpersonating() ? CppPaziente::where('id_cpp', Session::get('beforeImpersonate'))->where('id_paziente', $id_user)->first()->assegnazione_confidenzialita : 0;

  $terapie = Terapie::where('id_paziente' , $id_user)->get();

  $terapie_search = collect([]);

  $check = 0;

      foreach ($terapie as $terapia) {

        if($tipo == 1) {if(str_contains(strtolower($terapia->note), strtolower($txtSearch))){ $check = 1;}}
        if($tipo == 2) {if(str_contains(strtolower($terapia->getPrescrittore()), strtolower($txtSearch))){ $check = 1;}}
        if($tipo == 3) {if(str_contains(strtolower($terapia->getFarmaco()), strtolower($txtSearch))){ $check = 1;}}

        if($check == 1 && (($confidenzialita_auth != 0 && $confidenzialita_auth >= $terapia->id_livello_confidenzialita) || ($confidenzialita_auth == 0))) {
          $check = 0;
          $terapie_search->push(['id_terapie' => $terapia->id_terapie,
          'id_farmaco' => $terapia->id_farmaco_codifa,
          'nome_farmaco' => $terapia->getFarmaco()->descrizione_breve,
          'tipo_terapia' => $terapia->tipo_terapia,
          'principio_attivo' => $terapia->tipo_terapia == 0 ? $terapia->getFarmaco()->getPrincipioAttivo() : '',
          'atc' => $terapia->tipo_terapia == 0 ? $terapia->getFarmaco()->getATC() : '',
          'dataInizio' => $terapia->tipo_terapia == 0 ? '' : $terapia->data_inizio->format('d/m/Y'),
          'dataFine' => $terapia->tipo_terapia == 0 ? '' : $terapia->data_fine->format('d/m/Y'),
          'id_diagnosi' => $terapia->id_diagnosi,
          'diagnosi' => $terapia->tipo_terapia == 0 ? '' : $terapia->getDiagnosi() ,
          'verificatosi' => $terapia->tipo_terapia == 0 ? $terapia->data_evento->format('d/m/Y') : '',
          'prescrittore'  => $terapia->getPrescrittore(),
          'livello_confidenzialita' => $terapia->id_livello_confidenzialita,
          'note' => $terapia->note]);
        }
      }

    return $terapie_search->toJson();

}

  /**
  * ritorna alla modal info sul farmaco (JQUERY)
  */

  public function getFarmaco($id){

    if(Auth::id() != NULL){

      $farmaco = Farmaci::find($id);

      return response()->json(['nome_farmaco'=> $farmaco->descrizione_breve,
      'somministrazione' => $farmaco->getTipologiaSomministrazione(),
      'forma_farmaceutica' => $farmaco->getFormaFarmaceutica(),
      'atc' => $farmaco->getATC(),
      'principio_attivo' => $farmaco->getPrincipioAttivo(),
    ]);
    }
  }

  /**
  * aggiunge una terapia
  */
  public function aggiungiTerapia(Request $request){

    if(Input::get('tipo_terapia') == 0){

      $validator = Validator::make(Input::all(), [
        'id_farmaco_codifa' => 'required|numeric',
        'verificatosi' => 'required|date',
        'motivo_note' => 'required'
      ],
      [
        'id_farmaco_codifa.required' => 'Il campo Farmaco è obbligatorio!',
        'id_farmaco_codifa.numeric' => 'Il campo Farmaco è obbligatorio!',
        'verificatosi.required' => 'Il campo "Verificatosi" è obbligatorio!',
        'verificatosi.date' => 'Il campo "Verificatosi" deve contenere una data valida!',
        'motivo_note.required' => 'Il campo Motvo è obbligatorio!'

      ]);
    }

    if(Input::get('tipo_terapia') == 1 || Input::get('tipo_terapia') == 2){

      $validator = Validator::make(Input::all(), [
        'id_farmaco_codifa' => 'required|numeric',
        'tipo_terapia' => 'required|numeric',
        'dataInizio' => 'required|date',
        'dataFine' => 'required|date|after:dataInizio',
        'diagnosi' => 'required|numeric'
      ],
      [
        'id_farmaco_codifa.required' => 'Il campo "Farmaco" è obbligatorio!',
        'id_farmaco_codifa.numeric' => 'Il campo "Farmaco" è obbligatorio!',
        'tipo_terapia.required' => 'Il campo "Terapia" è obbligatorio!',
        'tipo_terapia.required' => 'Il campo "Terapia" è obbligatorio!',
        'dataInizio.required' => 'Il campo "Data Inzio" è obbligatorio!',
        'dataInizio.date' => 'Il campo "Data Inzio" deve contenere una data valida!',
        'dataFine.required' => 'Il campo "Data Fine" è obbligatorio!',
        'dataFine.date' => 'Il campo "Data Fine" deve contenere una data valida!',
        'dataFine.after' => 'Il campo "Data Fine" deve Contenere una data successiva a "Data Inizio"'
      ]);
    }
    if ($validator->fails()) {
      return Redirect::back()->withErrors($validator);
    }

    $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
    $paziente = Pazienti::where('id_utente', Auth::id())->first();

    $terapia = Terapie::create([
      'id_paziente' => Pazienti::where('id_utente', $id)->first()->id_paziente,
      'dataAggiornamento' => Carbon::now(),
      'tipo_terapia' => Input::get('tipo_terapia'),
      'id_farmaco_codifa' => Input::get('id_farmaco_codifa'),
      'id_prescrittore' => Auth::id(),
      'data_inizio' => Input::get('tipo_terapia') == 0 ? NULL : Input::get('dataInizio'),
      'data_fine' => Input::get('tipo_terapia') == 0 ? NULL : Input::get('dataFine'),
      'id_diagnosi' => Input::get('tipo_terapia') == 0 ? NULL : Input::get('diagnosi'),
      'data_evento' => Input::get('tipo_terapia') == 1 ? NULL :Input::get('verificatosi'),
      'id_livello_confidenzialita' => Input::get('livello_confidenzialita'),
      'note' => Input::get('motivo_note')
    ]);
    $terapia->save();
    return Redirect::back();

  }
  /**
  * permette di modificare una terapia
  */
  public function modificaTerapia(Request $request){

    if(Input::get('tipo_terapia_mod') == 0){

      $validator = Validator::make(Input::all(), [
        'id_farmaco_codifa_mod' => 'required|numeric',
        'verif_mod' => 'required|date',
        'note_diagnosi' => 'required'
      ],
      [
        'id_farmaco_codifa_mod.required' => 'Il campo "Farmaco" è obbligatorio!',
        'id_farmaco_codifa_mod.numeric' => 'Il campo "Farmaco" è obbligatorio!',
        'verif_mod.required' => 'Il campo "Verificatosi" è obbligatorio!',
        'verif_mod.date' => 'Il campo "Verificatosi" è obbligatorio!',
        'note_diagnosi.required' => 'Il campo "Motivo" è obbligatorio!'

      ]);
    }

    if(Input::get('tipo_terapia_mod') == 1 || Input::get('tipo_terapia_mod') == 2){

      $validator = Validator::make(Input::all(), [
        'id_farmaco_codifa_mod' => 'required|numeric',
        'tipo_terapia_mod' => 'required|numeric',
        'data_Inizio' => 'required|date',
        'data_Fine' => 'required|date|after:data_Inizio',
        'diagnosi_mod' => 'required|numeric',
        'note_diagnosi' => 'required'
      ],
      [
        'id_farmaco_codifa_mod.required' => 'Il campo "Farmaco" è obbligatorio!',
        'id_farmaco_codifa_mod.numeric' => 'Il campo "Farmaco" è obbligatorio!',
        'tipo_terapia_mod.required' => 'Il campo "Terapia" è obbligatorio!',
        'tipo_terapia_mod.required' => 'Il campo "Terapia" è obbligatorio!',
        'data_Inizio.required' => 'Il campo "Data Inzio" è obbligatorio!',
        'data_Inizio.date' => 'Il campo "Data Inzio" deve contenere una data valida!',
        'data_Fine.required' => 'Il campo "Data Fine" è obbligatorio!',
        'data_Fine.date' => 'Il campo "Data Fine" deve contenere una data valida!',
        'data_Fine.after' => 'Il campo "Data Fine" deve Contenere una data successiva a "Data Inizio"',
        'diagnosi_mod.required' => 'Il campo "Diagnosi" è obbligatorio!',
        'diagnosi_mod.numeric' => 'Il campo "Diagnosi" è obbligatorio!',
        'note_diagnosi.required' => 'Il campo "Motvo" è obbligatorio!'

      ]);
    }

    if ($validator->fails()) {
      return Redirect::back()->withErrors($validator);
    }

    $terapia = Terapie::find(Input::get('id_terapia_mod'));

    $terapia->tipo_terapia = Input::get('tipo_terapia_mod');
    $terapia->id_prescrittore = Auth::id();
    $terapia->id_farmaco_codifa = Input::get('id_farmaco_codifa_mod');
    $terapia->data_inizio =  Input::get('data_Inizio');
    $terapia->data_fine =  Input::get('data_Fine');
    $terapia->id_diagnosi =  Input::get('diagnosi_mod');
    $terapia->data_evento =  Input::get('verif_mod');
    $terapia->id_livello_confidenzialita = Input::get('livello_confidenzialita_mod');
    $terapia->note =  Input::get('note_diagnosi');
    $terapia->dataAggiornamento = Carbon::now();
    $terapia->save();
    return Redirect::back();

  }

  /**
  *
  * elimina la terapia selezionata
  */
  public function eliminaTerapia(Request $terapia){

    $terapia = Terapie::find(Input::get('id_terapia_msg'));
    $terapia->delete();
    return Redirect::back();
  }

  /**
  *
  * sposta la terapia selezionata in terapie concluse
  */
  public function spostaTerapia(Request $terapia){

    $terapia = Terapie::find(Input::get('id_terapia_msg'));
    $terapia->tipo_terapia = 2;
    $terapia->save();
    return Redirect::back();
  }

  public function getDocIsImpersonate(){

    if($request->session()->has('impersonate')) {
      $user = Auth::onceUsingId($request->session()->get('impersonate'));
      return $user->getName().' '.$user->getSurname();
    }
    $user = Pazienti::where('id_utente', Auth::id())->first();
    return $user->getName().' '.$user->getSurname();
  }

}