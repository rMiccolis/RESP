<?php

namespace App\Http\Controllers;



use App\Models\Gravidanza;
use App\Models\History\AnamnesiFisiologica;
use App\Models\History\AnamnesiPtProssima;
use App\Models\History\AnamnesiPtRemotum;
use App\Models\History\AnamnesiPt;
use App\Models\History\AnamnesiPtCodificate;
use App\Models\History\AnamnesiFm;
use App\Models\History\AnamnesiFmCodificate;
use App\Models\Icd9\Icd9GrupDiagCodici;
use App\Models\Icd9\Icd9BlocDiagCodici;
use App\Models\Icd9\Icd9CatDiagCodici;
use App\Models\Icd9\Icd9DiagCodici;
use App\Models\Parente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Anamnesi;
use App\Models\Patient\Pazienti;
use Auth;
use function MongoDB\BSON\toJSON;
use PDF;
use phpDocumentor\Reflection\Types\This;
use App\Models\CurrentUser\User;

use Session;

class AnamnesiController extends Controller
{

    static $forTest_boolean;

    public function index()
    {

        $this->fillicd9gruopdiagcode();
        $this->setAnamnesi();

        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $user = Pazienti::where('id_utente', $id)->first();
        $anamnesiFamiliare = Anamnesi::where('id_paziente', $id)->get();
        $parente = Parente::where('id_paziente', $id)->get();
        $anamnesiFisiologica = AnamnesiFisiologica::where('id_paziente', $id)->first();
        $anamnesiPatologica = AnamnesiPt::where('id_paziente', $userid)->first()->id;
        $anamnesiPatologicaCompleta = AnamnesiPt::where('id_paziente', $userid)->first();
        $anamnesiPatologicaRemota = AnamnesiPtCodificate::where([
            'id_anamnesi_pt' => $anamnesiPatologica,
            'stato' => 'remota'
        ])
        ->Join('tbl_icd9_diag_codici', 'tbl_anamnesi_pt_codificate.codice_diag', '=', 'tbl_icd9_diag_codici.codice_diag')
        ->get();
        $anamnesiPatologicaProssima = AnamnesiPtCodificate::where([
            'id_anamnesi_pt' => $anamnesiPatologica,
            'stato' => 'prossima'
        ])
        ->Join('tbl_icd9_diag_codici', 'tbl_anamnesi_pt_codificate.codice_diag', '=', 'tbl_icd9_diag_codici.codice_diag')
        ->get();
        $anamnesiFam = AnamnesiFm::where('id_paziente', $userid)->first();
        $icd9groupcode = Icd9GrupDiagCodici::orderBy('codice')->get();
        $gravidanza = Gravidanza::where('id_paziente', $id)->get();
        $printthis = false;

        $user_modifiedAnamfam = AnamnesiFm::where('id_paziente', $id)->first()->id_anamnesi_log ? $this->nameUserRole(AnamnesiFm::where('id_paziente', $id)->first()->id_anamnesi_log) : "Nessuno";

        $user_modifiedAnamfis = AnamnesiFisiologica::where('id_paziente', $id)->first()->id_anamnesi_log ? $this->nameUserRole(AnamnesiFisiologica::where('id_paziente', $id)->first()->id_anamnesi_log) : "Nessuno";

        $user_modifiedAnamPatRem = AnamnesiPt::where('id_paziente', $id)->first()->id_anamnesi_remota_log ? $this->nameUserRole(AnamnesiPt::where('id_paziente', $id)->first()->id_anamnesi_remota_log) : "Nessuno";

        $user_modifiedAnamPatPros = AnamnesiPt::where('id_paziente', $id)->first()->id_anamnesi_prossima_log ? $this->nameUserRole(AnamnesiPt::where('id_paziente', $id)->first()->id_anamnesi_prossima_log) : "Nessuno";

        return view('pages.anamnesi',compact('user','userid','anamnesiFamiliare', 'parente', 'anamnesiFisiologica','anamnesiPatologicaCompleta', 'anamnesiPatologicaRemota', 'anamnesiPatologicaProssima', 'anamnesiFam', 'icd9groupcode', 'gravidanza', 'printthis', 'user_modifiedAnamfam', 'user_modifiedAnamfis', 'user_modifiedAnamPatRem', 'user_modifiedAnamPatPros'));
    }

    // ritorna il nome utente con il ruolo
    public function nameUserRole(int $id_user){

          return $user_modified = (User::find($id_user)->getDescription()).': '.(User::find($id_user)->getName()).' '.(User::find($id_user)->getSurname());

    }

    public function fillicd9gruopdiagcode(){

        $group = Icd9GrupDiagCodici::find('a');
        if($group != null){
            return false;
        }else{
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'a';
            $group->gruppo_descrizione = "MALATTIE INFETTIVE E PARASSITARIE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'b';
            $group->gruppo_descrizione = "TUMORI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'c';
            $group->gruppo_descrizione = "MALATTIE ENDOCRINE NUTRIZIONALI, METABOLICHE E DISTURBI IMMUNITARI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'd';
            $group->gruppo_descrizione = "MALATTIE DEL SANGUE E DEGLI ORGANI EMATOPOIETICI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'e';
            $group->gruppo_descrizione = "DISTURBI MENTALI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'f';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA NERVOSO E DEGLI ORGANI DEI SENSI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'g';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA CIRCOLATORIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'h';
            $group->gruppo_descrizione = "MALATTIE DELL'APPARATO RESPIRATORIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'i';
            $group->gruppo_descrizione = "MALATTIE DELL'APPARATO DIGERENTE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'l';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA GENITOURINARIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'm';
            $group->gruppo_descrizione = "COMPLICAZIONI DELLA GRAVIDANZA DEL PARTO E DEL PUERPERIO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'n';
            $group->gruppo_descrizione = "MALATTIE DELLA CUTE E DEL TESSUTO SOTTOCUTANEO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'o';
            $group->gruppo_descrizione = "MALATTIE DEL SISTEMA OSTEOMUSCOLARE E DEL TESSUTO CONNETTIVO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'p';
            $group->gruppo_descrizione = "MALFORMAZIONI CONGENITE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'q';
            $group->gruppo_descrizione = "ALCUNE MANIFESTAZIONI MORBOSE DI ORIGINE PERINATALE";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'r';
            $group->gruppo_descrizione = "SINTOMI, SEGNI E STATI MORBOSI MAL DEFINITI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 's';
            $group->gruppo_descrizione = "TRAUMATISMI E AVVELENAMENTI";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 't';
            $group->gruppo_descrizione = "ALTRO";
            $group->save();
            $group = new Icd9GrupDiagCodici;
            $group->codice = 'u';
            $group->gruppo_descrizione = "CLASSIFICAZIONE SUPPLEMENTARE DEI FATTORI CHE INFLUENZANO LO STATO DI SALUTE E IL RICORSO AI SERVIZI SANITARI";
            $group->save();
            return true;
        }
    }

    public function setAnamnesi(){

        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();
        $anamnesiFisiologica = AnamnesiFisiologica::where('id_paziente', $id)->first();
        $anamnesiPatologicaRemota = AnamnesiPtRemotum::where('id_paziente', $id)->first();
        $anamnesiPatologicaProssima = AnamnesiPtProssima::where('id_paziente', $id)->first();

        if($anamnesiFisiologica == null){

            $fisiologica = new AnamnesiFisiologica;
            $fisiologica->id_paziente = $userid;
            $fisiologica->id_anamnesi_log = $auth_id;
            $fisiologica->dataAggiornamento = Carbon::now();
            $fisiologica->save();
        }

        if($anamnesiPatologicaRemota == null){

            $remota = new AnamnesiPtRemotum;
            $remota->id_paziente = $userid;
            $remota->id_anamnesi_log = $auth_id;
            $remota->save();
        }
        if($anamnesiPatologicaProssima == null){

            $prossima = new AnamnesiPtProssima;
            $prossima->id_paziente = $userid;
            $prossima->id_anamnesi_log = $auth_id;
            $prossima->save();
        }
    }

    public function store(Request $request)
    {

        $input = request()->input_name;
        switch ($input){
            case "Familiare":
                $this->storeFamiliare($request);
                break;
            case "Parente":
                $this->storeParenti($request);
                break;
            case "Fisiologica":
                $this->storeFisiologica($request);
                break;
            case "PatologicaRemota":
                $this->storePatologicaRemota($request);
                break;
            case "PatologicaProssima":
                $this->storePatologicaProssima($request);
                break;
            case "icd9groupcodeRemota":
                $this->storeicd9groupcodeRemota($request);
                break;
            case "icd9groupcodeProssima":
                $this->storeicd9groupcodeProssima($request);
                break;


        }

        return redirect('/anamnesi');
    }

    public function icd9Bloc(Request $request){

            $data = $request->data;
            $blocDiagCodici = Icd9BlocDiagCodici::whereIn('codice_gruppo', $data)->get();
            return response()->json($blocDiagCodici);

    }

    public function icd9Cat(Request $request){

            $data = $request->data;
            $catDiagCodici = Icd9CatDiagCodici::whereIn('codice_blocco', $data)->get();
            return response()->json($catDiagCodici);

    }

    public function icd9Cod(Request $request){

            $data = $request->data;
            $codDiagCodici = Icd9DiagCodici::whereIn('codice_categoria', $data)->get();
            return response()->json($codDiagCodici);

    }

    public function addPtRemota(Request $request){

            $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
            $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
            $Anamnesi_pt = AnamnesiPt::where('id_paziente', $userid)->first()->id;

            $data = $request->data;

            foreach ($data as $value) {
                $anamnesiPtCodificate = AnamnesiPtCodificate::firstOrNew(array('id_anamnesi_pt' => $Anamnesi_pt,'codice_diag' => $value,'stato' => 'remota'));
                $anamnesiPtCodificate->save();
            }

            $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();

            //aggiorna campo ultimo aggiornamento
            $anamnesi = AnamnesiPt::updateOrCreate(
                ['id_paziente' => $userid],
                ['id_anamnesi_remota_log' => $auth_id,
                  'dataAggiornamento_anamnesi_remota' => Carbon::now()]
            );
    }

    public function addPtProssima(Request $request){

            $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
            $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
            $Anamnesi_pt = AnamnesiPt::where('id_paziente', $userid)->first()->id;

            $data = $request->data;

            foreach ($data as $value) {
                $anamnesiPtCodificate = AnamnesiPtCodificate::firstOrNew(array('id_anamnesi_pt' => $Anamnesi_pt,'codice_diag' => $value,'stato' => 'prossima'));
                $anamnesiPtCodificate->save();
            }

            $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();

            //aggiorna campo ultimo aggiornamento
            $anamnesi = AnamnesiPt::updateOrCreate(
                ['id_paziente' => $userid],
                ['id_anamnesi_prossima_log' => $auth_id,
                  'dataAggiornamento_anamnesi_prossima' => Carbon::now()]
            );
    }

    public function addPtParente(Request $request){

            $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
            $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
            $Anamnesi_fm = AnamnesiFm::where('id_paziente', $userid)->first()->id;

            $data = $request->data;
            $idParente = $request->idParente;

            foreach ($data as $value) {
                $anamnesiFmCodificate = AnamnesiFmCodificate::firstOrNew(array('id_anamnesi_fm' => $Anamnesi_fm, 'id_parente' => $idParente, 'codice_diag' => $value));
                $anamnesiFmCodificate->save();
            }
    }

    public function showPtParente(Request $request){

            $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
            $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
            $Anamnesi_fm = AnamnesiFm::where('id_paziente', $userid)->first()->id;

            $idParente = $request->data;

            $anamnesiFmParente = AnamnesiFmCodificate::where([
                'id_anamnesi_fm' => $Anamnesi_fm,
                'id_parente' => $idParente
            ])
            ->Join('tbl_icd9_diag_codici', 'tbl_anamnesi_fm_codificate.codice_diag', '=', 'tbl_icd9_diag_codici.codice_diag')
            ->get()->toJson();

            echo($anamnesiFmParente);
    }


    public function storeFamiliare(Request $request){

        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;

        $anamnesi = AnamnesiFm::updateOrCreate(
            ['id_paziente' => $userid],
            ['id_anamnesi_log' => $auth_id,
             'dataAggiornamento' => Carbon::now(),
             'anamnesi_familiare_contenuto' => $request->get('testofam')]
        );

        return redirect('/anamnesi');

    }

    public function storeParenti(Request $request){
        //utile per classe test
        AnamnesiController::$forTest_boolean=false;


        $parente = new Parente;

        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $parente->id_paziente = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $parente->nome = $request->input('nome_componente');
        $parente->cognome = $request->input('cognome_componente');
        $parente->grado_parentela = $request->get('grado_parentela');
        $parente->sesso = $request->get('sesso');
        $parente->eta = $request->input('età');
        $parente->data_decesso = $request->input('data_decesso');
        $parente->annotazioni = $request->input('annotazioni');

        AnamnesiController::$forTest_boolean=$parente->save();

        return redirect('/anamnesi');
    }

    public function storeFisiologica(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $fisiologica = AnamnesiFisiologica::find($userid);
        $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();

        if(isset($fisiologica->id_paziente)){
            $fisiologica->delete();
        }



        $fisiologica = new AnamnesiFisiologica;
        $fisiologica->id_paziente = $userid;
        $fisiologica->dataAggiornamento = Carbon::now();
        $fisiologica->id_anamnesi_log = $auth_id;

        //Infanzia
        $fisiologica->tempoParto = $request->get('parto');
        $fisiologica->tipoParto = $request->get('tipoparto');
        $fisiologica->allattamento = $request->get('allattamento');
        $fisiologica->sviluppoVegRel = $request->get('sviluppoVegRel');
        $fisiologica->noteInfanzia = $request->input('noteinfanzia');

        //Scolarità
        $fisiologica->livelloScol = $request->get('livelloScol');

        //Ciclo Mestruale
        $fisiologica->etaMenarca = $request->get('etaMenarca');
        $fisiologica->ciclo = $request->get('ciclo');
        $fisiologica->etaMenopausa = $request->input('etaMenopausa');
        $fisiologica->menopausa = $request->get('menopausa');
        $fisiologica->noteCicloMes = $request->input('noteCicloMes');

        //Stile di vita
        $fisiologica->attivitaFisica = $request->input('attivitaFisica');
        $fisiologica->abitudAlim = $request->input('abitudAlim');
        $fisiologica->ritmoSV = $request->input('ritmoSV');
        $fisiologica->stress = $request->get('stress');
        $fisiologica->fumo = $request->get('fumo');
        $fisiologica->dosiFumo = $request->input('dosiFumo');
        $fisiologica->dataInizioFumo = $request->input('inizioFumo');
        $fisiologica->dataFineFumo = $request->input('fineFumo');
        $fisiologica->alcool = $request->get('alcool');
        $fisiologica->dosiAlcool = $request->input('dosiAlcool');
        $fisiologica->tipoAlcool = $request->get('tipoAlcool');
        $fisiologica->dataInizioAlcool = $request->input('inizioAlcool');
        $fisiologica->dataFineAlcool = $request->input('fineAlcool');
        $fisiologica->droghe = $request->get('droghe');
        $fisiologica->dosiDroghe = $request->input('dosiDroghe');
        $fisiologica->tipoDroghe = $request->get('tipoDroghe');
        $fisiologica->dataInizioDroghe = $request->input('inizioDroghe');
        $fisiologica->dataFineDroghe = $request->input('fineDroghe');
        $fisiologica->caffeina = $request->get('caffeina');
        $fisiologica->dosiCaffeina = $request->input('dosiCaffeina');
        $fisiologica->noteStileVita = $request->input('noteStileVita');

        //Alvo e minzione
        $fisiologica->alvo = $request->get('alvo');
        $fisiologica->minzione = $request->get('minzione');
        $fisiologica->noteAlvoMinz = $request->input('noteAlvoMinz');

        //Professione
        $fisiologica->professione = $request->input('professione');
        $fisiologica->noteAttLav = $request->input('noteAttLav');

        $fisiologica->save();

        //Gravidanza
        if(($request->get('esito') != null) or ($request->input('etaGravidanza') != null) or ($request->input('dataInizioGrav') != null) or
            ($request->input('dataFineGrav') != null) or ($request->get('sessoBambino') != null) or ($request->input('noteGravidanza') != null)){

            $gravidanza = new Gravidanza;
            $gravidanza->id_paziente = $userid;
            $gravidanza->esito = $request->get('esito');
            $gravidanza->eta = $request->input('etaGravidanza');
            $gravidanza->inizio_gravidanza = $request->input('dataInizioGrav');
            $gravidanza->fine_gravidanza = $request->input('dataFineGrav');
            $gravidanza->sesso_bambino = $request->get('sessoBambino');
            $gravidanza->note_gravidanza = $request->input('noteGravidanza');
            $gravidanza->save();
        }



        return redirect('/anamnesi');
    }



    public function storePatologicaRemota(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;

        $anamnesi = AnamnesiPt::updateOrCreate(
            ['id_paziente' => $userid],
            ['id_anamnesi_remota_log' => $auth_id,
              'dataAggiornamento_anamnesi_remota' => Carbon::now(),
              'anamnesi_remota_contenuto' => $request->get('testopat')]
        );

        return redirect('/anamnesi');
    }

    public function storeicd9groupcodeRemota(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $anamnesiPtRemota = AnamnesiPtRemotum::find($userid);
        $oldanamPtRemota = $anamnesiPtRemota->anamnesi_remota_contenuto;

        $anamnesiPtRemota->delete();

        $anamnesiPtRemota = new AnamnesiPtRemotum;
        $anamnesiPtRemota->id_paziente = $userid;
        $anamnesiPtRemota->anamnesi_remota_contenuto = $oldanamPtRemota;

        if($request->get('icd9groupcode') != null){
            $anamnesiPtRemota->icd9_group_code = implode("_",$request->get('icd9groupcode')) . "_";
        }

        $anamnesiPtRemota->save();



        return redirect('/anamnesi');
    }

    public function storePatologicaProssima(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $auth_id = Auth::user()->isImpersonating() ? Session::get('beforeImpersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;

        $anamnesi = AnamnesiPt::updateOrCreate(
            ['id_paziente' => $userid],
            ['id_anamnesi_prossima_log' => $auth_id,
            'dataAggiornamento_anamnesi_prossima' => Carbon::now(),
            'anamnesi_prossima_contenuto' => $request->get('testopatpp')]
        );

        return redirect('/anamnesi');
    }

    public function storeicd9groupcodeProssima(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $anamnesiPtProssima = AnamnesiPtProssima::find($userid);
        $oldanamPtProssima = $anamnesiPtProssima->anamnesi_prossima_contenuto;

        $anamnesiPtProssima->delete();

        $anamnesiPtProssima = new AnamnesiPtProssima;
        $anamnesiPtProssima->id_paziente = $userid;
        $anamnesiPtProssima->anamnesi_prossima_contenuto = $oldanamPtProssima;

        if($request->get('icd9groupcode') != null){
            $anamnesiPtProssima->icd9_group_code = implode("_",$request->get('icd9groupcode')) . "_";
        }



        $anamnesiPtProssima->save();



        return redirect('/anamnesi');
    }

    public function spostaPtProssima(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;
        $Anamnesi_pt = AnamnesiPt::where('id_paziente', $userid)->first()->id;



        $data = $request->data;

        foreach ($data as $value) {
            $anamnesi = AnamnesiPtCodificate::where([
                ['id_anamnesi_pt', $Anamnesi_pt],
                ['codice_diag', $value]
            ])->first();

            $anamnesi->stato = 'remota';
            $anamnesi->save();
        }

    }

    public function update(Request $request, $id){

        $input = request()->input_name;

        switch ($input) {
            case "UpdateParente":
                $this->updateParente($request, $id);
                break;
            case "UpdateGravidanze";
                $this->updateGravidanze($request, $id);
                break;
        }

        return redirect('/anamnesi');
    }

    public function updateParente(Request $request, $id){

        $parente = Parente::find($id);
        $parente->nome = $request->input('nome_componente');
        $parente->cognome = $request->input('cognome_componente');
        $parente->grado_parentela = $request->get('grado_parentela');
        $parente->sesso = $request->get('sesso');
        $parente->eta = $request->input('età');
        $parente->data_decesso = $request->input('data_decesso');
        $parente->annotazioni = $request->input('annotazioni');
        $parente->save();

        return redirect('/anamnesi');
    }

    public function updateGravidanze($request, $id){

        $gravidanza = Gravidanza::find($id);
        $gravidanza->esito = $request->get('esito');
        $gravidanza->eta = $request->input('etaGravidanza');
        $gravidanza->inizio_gravidanza = $request->input('dataInizioGrav');
        $gravidanza->fine_gravidanza = $request->input('dataFineGrav');
        $gravidanza->sesso_bambino = $request->get('sessoBambino');
        $gravidanza->note_gravidanza = $request->input('noteGravidanza');
        $gravidanza->save();
        return redirect('/anamnesi');
    }

    public function delete(Request $request, $id){

        $input = request()->input_name;

        switch ($input) {
            case "DeleteParente":
                $this->deleteParente($request,$id);
                break;
            case "DeleteGravidanze":
                $this->deleteGravidanze($request,$id);
                break;
        }

        return redirect('/anamnesi');
    }

    public function deleteParente(Request $request, $id){

        $parente = Parente::find($id);
        $parente->delete();

        return redirect('/anamnesi');
    }

    public function deleteGravidanze($id){

        $gravidanza = Gravidanza::find($id);
        $gravidanza->delete();

        return redirect('/anamnesi');
    }

    public function printAnamnesi(Request $request){
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

        $user = Pazienti::where('id_utente', $id)->first();
        $parente = Parente::where('id_paziente', $id)->get();
        $gravidanza = Gravidanza::where('id_paziente', $id)->get();


        //PRINT ANAMNESI FAMILIARE
        $anamFamiliare_cont  = $request->input('anamFamiliare');

        $Parente = "";
        foreach($parente as $p){
            if($request->input('anamAnnotazioni'.$p->id_parente) != null or $request->input('anamEta'.$p->id_parente)) {
                $Parente = $Parente . $request->input('anamAnnotazioni' . $p->id_parente) . " a " . $p->grado_parentela . " a " . $request->input('anamEta' . $p->id_parente) . " anni" . "<br>";
            }
        }

        $anamnesifamiliare = "";
        if($anamFamiliare_cont != null or $Parente != null)
            $anamnesifamiliare = "<h2>Anamnesi familiare</h2><hr> " . $anamFamiliare_cont . "<br>" . $Parente;

        //PRINT ANAMNESI FISIOLOGICA
        $parto = "";
        if($request->input('Parto') != null){
           $parto = "Nato da parto " . $request->input('Parto') . ", ";
        }

        $tipoParto = "";
        if($request->input('tipoParto') != null){
            $tipoParto = "tipo parto " . $request->input('tipoParto') . ", ";
        }

        $allattamento = "";
        if($request->input('Allattamento') != null){
            $allattamento = "allattamento " . $request->input('Allattamento') . ", ";
        }

        $sviluppoVegRel = "";
        if($request->input('sviluppoVegRel') != null){
            $sviluppoVegRel= "sviluppo vegetativo e relazionale: " . $request->input('sviluppoVegRel') . ", ";
        }

        $noteInfanzia = "";
        if($request->input('noteInfanzia') != null){
            $noteInfanzia= "note infanzia " . $request->input('noteInfanzia') . ".<br>";
        }

        $livelloScol = "";
        if($request->input('livScol') != null){
            $livelloScol= "Livello scolastico " . $request->input('livScol') . ".<br>";
        }

        $attivitaFisica = "";
        if($request->input('attivitaFisica') != null){
            $attivitaFisica= "Attività fisica " . $request->input('attivitaFisica') . ", ";
        }

        $abitudAlim = "";
        if($request->input('abitudAlim') != null){
            $abitudAlim= "abitudini alimentari " . $request->input('abitudAlim') . ", ";
        }

        $fumo = "";
        if($request->input('fumo') != null){
            $fumo= "fumo " . $request->input('fumo') . ", ";
        }

        $freqFumo = "";
        if($request->input('freqFumo') != null){
            $freqFumo= "con una frequenza/quantità di " . $request->input('freqFumo') . ", ";
        }

        $alcool = "";
        if($request->input('alcool') != null){
            $alcool= "alcool " . $request->input('alcool') . ", ";
        }

        $freqAlcool = "";
        if($request->input('freqAlcool') != null){
            $freqAlcool= "con una frequenza/quantità di " . $request->input('freqAlcool') . ", ";
        }

        $droghe = "";
        if($request->input('droghe') != null){
            $droghe= "droghe " . $request->input('droghe') . ", ";
        }

        $freqDroghe = "";
        if($request->input('freqDroghe') != null){
            $freqDroghe= "con una frequenza/quantità di " . $request->input('freqDroghe') . ", ";
        }

        $noteStileVita = "";
        if($request->input('noteStileVita') != null){
            $noteStileVita= "note stile di vita " . $request->input('noteStileVita') . ".<br>";
        }

        $professione = "";
        if($request->input('professione') != null){
            $professione= "Professione </strong>" . $request->input('professione') . ", ";
        }

        $noteAttLav = "";
        if($request->input('noteAttLav') != null){
            $noteAttLav= "note professione " . $request->input('noteAttLav') . ".<br>";
        }

        $alvo = "";
        if($request->input('alvo') != null){
            $alvo= "Alvo " . $request->input('alvo') . ", ";
        }

        $minzione = "";
        if($request->input('minzione') != null){
            $minzione= "minzione " . $request->input('minzione') . ", ";
        }

        $noteAlvoMinz = "";
        if($request->input('noteAlvoMinz') != null){
            $noteAlvoMinz= "note alvo/minzione " . $request->input('noteAlvoMinz') . ".<br>";
        }

        $cicloMesturale = "";
        $Gravidanze = "";
        if($user->paziente_sesso == "F" or $user->paziente_sesso == "female"){

            $etaMenarca = "";
            if($request->input('etaMenarca') != null){
                $etaMenarca= "Età menarca " . $request->input('etaMenarca') . " anni, ";
            }

            $ciclo = "";
            if($request->input('ciclo') != null){
                $ciclo= "ciclo " . $request->input('ciclo') . ", ";
            }

            $etaMenopausa = "";
            if($request->input('etaMenopausa') != null){
                $etaMenopausa= "età menopausa " . $request->input('etaMenopausa') . " anni, ";
            }

            $menopausa = "";
            if($request->input('menopausa') != null){
                $menopausa= "menopausa " . $request->input('menopausa') . ", ";
            }

            $noteCiclo = "";
            if($request->input('noteCiclo') != null){
                $noteCiclo= "note ciclo " . $request->input('noteCiclo') . ".<br>";
            }

            $cicloMesturale = $etaMenarca . $ciclo . $etaMenopausa . $menopausa . $noteCiclo;


            foreach ($gravidanza as $g){
                $Gravidanze = $Gravidanze . "Gravidanza con esito " . $request->input('esitoGrav'.$g->id_gravidanza) . " all'età di " . $request->input('etaGrav'.$g->id_gravidanza) . " anni, " .
                                            "inizio gravidanza " . $request->input('inizioGrav'.$g->id_gravidanza) . ", fine gravidanza " . $request->input('fineGrav'.$g->id_gravidanza) . ", sesso bambino " . $request->input('sessoBambinoGrav'.$g->id_gravidanza) . ", note gravidanza" . $request->input('noteGrav'.$g->id_gravidanza) . ".<br>";

            }


        }

        if($parto != null or $tipoParto != null or $allattamento != null or $sviluppoVegRel != null or $noteInfanzia != null or $livelloScol != null or $attivitaFisica != null or $abitudAlim != null or $fumo != null or $freqFumo != null or $alcool != null or $freqAlcool != null or $droghe != null or $freqDroghe != null or $noteStileVita != null or $professione != null or $noteAttLav != null or $alvo != null or $minzione != null or $noteAlvoMinz != null or $cicloMesturale != null or $Gravidanze != null) {
            $anamnesifisiologica = "<h2>Anamnesi fisiologica</h2><hr>" . $parto . $tipoParto . $allattamento . $sviluppoVegRel . $noteInfanzia . $livelloScol . $attivitaFisica . $abitudAlim . $fumo . $freqFumo . $alcool . $freqAlcool . $droghe . $freqDroghe . $noteStileVita . $professione . $noteAttLav . $alvo . $minzione . $noteAlvoMinz . $cicloMesturale . $Gravidanze;
        }

        //PRINT ANAMNESI PAT. REMOTA
        $anamPatRemota_cont  = $request->input('anamPatRemota');
        if ($anamPatRemota_cont != null){
            $anamPatRemota_cont = $anamPatRemota_cont;
        }

        if($request->input('icd9PatRemota') != null)
            $anamPatRemota_icd9  = "<br><br><strong>Patologie remote raggruppate per Categorie Diagnostiche (MDC): </strong><br>". $request->input('icd9PatRemota');



        $anamnesipatologicaremota = "";



        if($anamPatRemota_cont != null or $anamPatRemota_icd9 != null) {


            $anamnesipatologicaremota = "<h2>Anamnesi patologica remota</h2><hr>" . $anamPatRemota_cont . $anamPatRemota_icd9;
        }

        //PRINT ANAMNESI PAT. PROSSIMA
        $anamPatProssima_cont  = $request->input('anamPatProssima');
        if ($anamPatProssima_cont != null){
            $anamPatProssima_cont = "- " . $anamPatProssima_cont;
        }

        $anamPatProssima_icd9 = "";
        if($request->input('icd9PatProssima') != null)
            $anamPatProssima_icd9  = "<br><br><strong>Patologie prossime raggruppate per Categorie Diagnostiche (MDC): </strong><br>". $request->input('icd9PatProssima');


        if($anamPatProssima_cont != null or $anamPatProssima_icd9 != null) {
            $anamnesipatologicaprossima = "<h2>Anamnesi patologica prossima</h2><hr>" . $anamPatProssima_cont . $anamPatProssima_icd9;
        }

        $nomePaziente = "";
        if($user->paziente_sesso == "female" or $user->paziente_sesso == "F"){

            $nomePaziente = "<h1>Sig.ra $user->paziente_nome $user->paziente_cognome</h1>";
        }else{

            $nomePaziente = "<h1>Sig. $user->paziente_nome $user->paziente_cognome</h1>";
        }

        $print = $nomePaziente .  $anamnesifamiliare . $anamnesifisiologica . $anamnesipatologicaremota . $anamnesipatologicaprossima;

        $pdf = PDF::loadhtml($print);

        return $pdf->stream('result.pdf');
    }


}
