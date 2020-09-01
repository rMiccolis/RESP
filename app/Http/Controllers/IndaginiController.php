<?php
namespace App\Http\Controllers;

use App\IndagineDiagnosi;
use App\Models\CareProviders\CppDiagnosi;
use App\Models\Diagnosis\Diagnosi;
use App\Models\InvestigationCenter\Indagini;
use App\Models\InvestigationCenter\IndaginiEliminate;
use App\Models\InvestigationCenter\AllegatiIndagini;
use Auth;
use Carbon\Carbon;
use Redirect;

class IndaginiController extends Controller
{

    private function addDiagnosiFromIndagini($idPaz, $Cpp, $motivo, $tipoDiagnosi)
    {
        $today = getdate();

        $anno = $today["year"];
        $mese = $today["mon"];
        $giorno = $today["mday"];

        if ($today["mon"] < 10) {
            $mese = "0" . $today["mon"];
        }

        if ($today["mday"] < 10) {
            $giorno = "0" . $today["mday"];
        }

        $data = $anno . "-" . $mese . "-" . $giorno;

        $st;
        if ($tipoDiagnosi == 0) {
            $st = 'Confermata';
        }
        else if ($tipoDiagnosi == 1) {
            $st = 'Sospetta';
        }
        else if ($tipoDiagnosi == 2) {
            $st = 'Esclusa';
        }

        $cppSt = $Cpp . "/(" . $st . ")";

        $cppDiagnosi = CppDiagnosi::create([
            'diagnosi_stato' => $tipoDiagnosi,
            'careprovider' => $cppSt
        ]);

        $diagnosi = Diagnosi::create([
            'id_paziente' => $idPaz,
            'diagnosi_inserimento_data' => $data,
            'diagnosi_aggiornamento_data' => $data,
            'diagnosi_patologia' => $motivo,
            'diagnosi_stato' => $tipoDiagnosi,
            'diagnosi_guarigione_data' => $data
        ]);

        $cppDiagnosi->save();
        $diagnosi->save();

        return Diagnosi::where('id_paziente',$idPaz)->where('diagnosi_patologia',$motivo)->max('id_diagnosi');
    }

    /**
     * aggiunge una indagine richiesta
     */
    public function addIndagineRichiesta($tipo, $tipoDiagnosi, $motivo, $Cpp, $idCpp, $idPaz, $stato)
    {
        $data = Carbon::today();

        //stabilisco il numero di motivazioni inserite
        $motiviConDate = explode(",", $motivo);
        $nMotivi = sizeof($motiviConDate);

        $tipiMotivi = explode(",", $tipoDiagnosi);

        $diagnosi = Diagnosi::where('id_paziente',$idPaz)->get();
        $ret=0;

        if ($idCpp == '0') {
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $data,
                'indagine_stato' => $stato,
                'indagine_aggiornamento' => $data,
                'indagine_tipologia' => $tipo,
            ]);
        }
        else{
            $indagine = Indagini::create([
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $data,
                'indagine_stato' => $stato,
                'indagine_aggiornamento' => $data,
                'indagine_tipologia' => $tipo,
            ]);
        }

        $indagine->save();

        //recupero l'id dell'ultima indagine inserita
        $idIndagine = Indagini::where('careprovider',$Cpp)->where('careprovider',$Cpp)->max('id_indagine');

        $indice = 0;

        //controllo che le motivazioni siano nuove o già inserite
        foreach ($motiviConDate as $motivDate){
            $newMotivo = explode("--", $motivDate);
            if($newMotivo[1] != "0"){
                foreach ($diagnosi as $d) {
                    if (($d->diagnosi_inserimento_data == ($newMotivo[1])) && ($d->diagnosi_patologia == $newMotivo[0])) {
                        $ret = $d->id_diagnosi;
                    }
                }
            }else{
                //aggiungo nuova motivazione alla tabella tbl_diagnosi
                $ret = $this->addDiagnosiFromIndagini($idPaz, $Cpp, $newMotivo[0], $tipiMotivi[$indice]);
            }

            $indagineDiagnosi = \App\Models\IndagineDiagnosi::create([
                'id_indagine' => $idIndagine,
                'id_diagnosi' => $ret,
            ]);

            $indagineDiagnosi->save();

            $indice++;
        }

        return Redirect::back();
    }

    /**
     * aggiunge una indagine programmata
     */
    public function addIndagineProgrammata($tipo, $tipoDiagnosi, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis)
    {
        //stabilisco il numero di motivazioni inserite
        $motiviConDate = explode(",", $motivo);
        $nMotivi = sizeof($motiviConDate);

        $tipiMotivi = explode(",", $tipoDiagnosi);

        $diagnosi = Diagnosi::where('id_paziente',$idPaz)->get();
        $ret=0;

        if ($idCpp == '0'){
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => NULL
            ]);
        }
        else{
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => NULL
            ]);
        }

        $indagine->save();

        //recupero l'id dell'ultima indagine inserita
        $idIndagine = Indagini::where('careprovider',$Cpp)->where('careprovider',$Cpp)->max('id_indagine');

        $indice = 0;

        //controllo che le motivazioni siano nuove o già inserite
        foreach ($motiviConDate as $motivDate){
            $newMotivo = explode("--", $motivDate);
            if($newMotivo[1] != "0"){
                foreach ($diagnosi as $d) {
                    if (($d->diagnosi_inserimento_data == ($newMotivo[1])) && ($d->diagnosi_patologia == $newMotivo[0])) {
                        $ret = $d->id_diagnosi;
                    }
                }
            }else{
                //aggiungo nuova motivazione alla tabella tbl_diagnosi
                $ret = $this->addDiagnosiFromIndagini($idPaz, $Cpp, $newMotivo[0], $tipiMotivi[$indice]);
            }

            $indagineDiagnosi = \App\Models\IndagineDiagnosi::create([
                'id_indagine' => $idIndagine,
                'id_diagnosi' => $ret,
            ]);

            $indagineDiagnosi->save();

            $indice++;
        }

        return Redirect::back();
    }

    /**
     * aggiunge una indagine completata
     */
    public function addIndagineCompletata($tipo, $tipoDiagnosi, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis, $referto, $allegato, $referto_stato)
    {
        //stabilisco il numero di motivazioni inserite
        $motiviConDate = explode(",", $motivo);
        $nMotivi = sizeof($motiviConDate);

        $tipiMotivi = explode(",", $tipoDiagnosi);

        $diagnosi = Diagnosi::where('id_paziente',$idPaz)->get();
        $ret=0;

        if($referto == "null") $referto = NULL;
        if($allegato == "null") $allegato = NULL;

        if ($idCpp == '0') {
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'referto_stato' => $referto_stato,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto
            ]);
        }
        else{
            $indagine = Indagini::create([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_data' => $dataVis,
                'indagine_aggiornamento' => $dataVis,
                'referto_stato' => $referto_stato,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto
            ]);
        }

        $indagine->save();

        //recupero l'id dell'ultima indagine inserita
        $idIndagine = Indagini::where('careprovider',$Cpp)->where('careprovider',$Cpp)->max('id_indagine');

        $indice = 0;

        //controllo che le motivazioni siano nuove o già inserite
        foreach ($motiviConDate as $motivDate){
            $newMotivo = explode("--", $motivDate);
            if($newMotivo[1] != "0"){
                foreach ($diagnosi as $d) {
                    if (($d->diagnosi_inserimento_data == ($newMotivo[1])) && ($d->diagnosi_patologia == $newMotivo[0])) {
                        $ret = $d->id_diagnosi;
                    }
                }
            }else{
                //aggiungo nuova motivazione alla tabella tbl_diagnosi
                $ret = $this->addDiagnosiFromIndagini($idPaz, $Cpp, $newMotivo[0], $tipiMotivi[$indice]);
            }

            $indagineDiagnosi = \App\Models\IndagineDiagnosi::create([
                'id_indagine' => $idIndagine,
                'id_diagnosi' => $ret,
            ]);

            $indagineDiagnosi->save();

            $indice++;
        }

        if($allegato!=null)
        {
            $allegati = explode("-", $allegato);
            for($i=0;$i<sizeof($allegati);$i++)
            {
                $allegatoIndagine = AllegatiIndagini::create([
                    'id_file' => $allegati[$i],
                    'id_indagine' => $idIndagine
                ]);
            }
        }

        return Redirect::back();
    }

    /**
     * modifica una indagine richiesta
     */
    public function ModIndagineRichiesta($id, $tipo, $tipoDiagnosi, $motivo, $Cpp, $idCpp, $idPaz, $stato)
    {
        $data = Carbon::today();
        
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::where('id_paziente',$idPaz)->get();
        $ret = '0';
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                }
            }
        }
        else {
            $ret = $this->addDiagnosiFromIndagini($idPaz, $Cpp, $motivo, $tipoDiagnosi);
        }
        
        $match = [
            'id_indagine' => $id
        ];
        
        if ($idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'referto_stato' => 'unknown',
                'indagine_referto' => NULL
            ]);
        }
        else
        {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $data,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'referto_stato' => 'unknown',
                'indagine_referto' => NULL
            ]);
        }

        \App\Models\InvestigationCenter\AllegatiIndagini::where('id_indagine',$id)->delete();

        return Redirect::back();
    }

    /**
     * modifica una indagine programmata
     */
    public function ModIndagineProgrammata($id, $tipo, $tipoDiagnosi, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis)
    {
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::where('id_paziente',$idPaz)->get();
        $ret = '0';
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                }
            }
        }
        else {
            $ret = $this->addDiagnosiFromIndagini($idPaz, $Cpp, $motivo, $tipoDiagnosi);
        }
        
        $match = [
            'id_indagine' => $id
        ];

        if ($idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'referto_stato' => 'unknown',
                'indagine_referto' => NULL
            ]);
        }
        else
        {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'referto_stato' => 'unknown',
                'indagine_referto' => NULL
            ]);
        }

        \App\Models\InvestigationCenter\AllegatiIndagini::where('id_indagine',$id)->delete();
        
        return Redirect::back();
       
    }
    
    /**
     * modifica una indagine completata
     */
    public function ModIndagineCompletata($id, $tipo, $tipoDiagnosi, $motivo, $Cpp, $idCpp, $idPaz, $stato, $idCentr, $dataVis, $referto, $allegato)
    {
        
        $var = explode("--", $motivo);
        $diagnosi = array();
        $diagnosi = Diagnosi::where('id_paziente',$idPaz)->get();
        $ret = '0';

        if($referto == "null") $referto = NULL;
        if($allegato == "null") $allegato = NULL;
        
        if (sizeof($var) > 1) {
            foreach ($diagnosi as $d) {
                if (($d->diagnosi_inserimento_data == ($var[1])) && ($d->id_paziente == $idPaz) && ($d->diagnosi_patologia == $var[0])) {
                    $ret = $d->id_diagnosi;
                }
            }
        }
        else {
            $ret = $this->addDiagnosiFromIndagini($idPaz, $Cpp, $motivo, $tipoDiagnosi);
        }
        
        $match = [
            'id_indagine' => $id
        ];

        if ($idCpp == '0') {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto
            ]);
        }
        else
        {
            $editIndagine = \DB::table('tbl_indagini')->where($match)->update([
                'id_diagnosi' => $ret,
                'id_paziente' => $idPaz,
                'id_cpp' => $idCpp,
                'careprovider' => $Cpp,
                'indagine_aggiornamento' => $dataVis,
                'indagine_stato' => $stato,
                'indagine_tipologia' => $tipo,
                'indagine_motivo' => $var[0],
                'id_centro_indagine' => $idCentr,
                'indagine_referto' => $referto
            ]);
        }

        \App\Models\InvestigationCenter\AllegatiIndagini::where('id_indagine',$id)->delete();
        if($allegato!=null)
        {
            $allegati = explode("-", $allegato);
            for($i=0;$i<sizeof($allegati);$i++)
            {
                $allegatoIndagine = AllegatiIndagini::create([
                    'id_file' => $allegati[$i],
                    'id_indagine' => Indagini::max('id_indagine')
                ]);
            }
        }

        return Redirect::back();
    }

    /**
     * elimina l'indagine selezionata
     */
    public function eliminaIndagine($getIdIndagine, $idUtente)
    {
        $match = [
            'id_indagine' => $getIdIndagine
        ];

        \DB::table('tbl_indagini')->where($match)->update([
            'indagine_stato' => '3'
        ]);
        
        $indagineElim = IndaginiEliminate::create([
            'id_utente' => $idUtente,
            'id_indagine' => $getIdIndagine
        ]);
        
        $indagineElim->save();

        /*Dato che le indagini eliminate vengono solo contrassegnate con stato "3"
        induce ad una situazione di recupero. Pertanto non vengono eliminati i riferimenti in
        AllegatiIndagine*/
        
        return Redirect::back();
    }
}
