<?php
namespace App\Http\Controllers;

use App\Models\InvestigationCenter\IndaginiEliminate;
use Redirect;
use App\Models\CareProviders\CppDiagnosi;
use App\Models\Diagnosis\Diagnosi;
use App\Models\Diagnosis\DiagnosiEliminate;

use Auth;
use Session;

class DiagnosiController extends Controller
{

    /**
     * elimina la diagnosi selezionata
     */
    public function eliminaDiagnosi($getIdDiagnosi, $idPaziente)
    {
//        $indagini = \App\Models\InvestigationCenter\Indagini::where('id_paziente',$idPaziente)->where('id_diagnosi',$getIdDiagnosi)->get();
//
//        foreach($indagini as $indagine)
//        {
//            $match = [
//                'id_indagine' => $indagine->id_indagine
//            ];
//
//            \DB::table('tbl_indagini')->where($match)->update([
//                'indagine_stato' => '3'
//            ]);
//
//            $indagineElim = IndaginiEliminate::create([
//                'id_utente' => $idPaziente,
//                'id_indagine' => $indagine->id_indagine
//            ]);
//
//            $indagineElim->save();
//        }

        $match = [
            'id_diagnosi' => $getIdDiagnosi
        ];
        
        $edited_character = \DB::table('tbl_diagnosi')->where($match)->update([
            'diagnosi_stato' => 3
        ]);
        
        $edited_character = \DB::table('tbl_cpp_diagnosi')->where($match)->update([
            'diagnosi_stato' => 3
        ]);
        
        $diagnosiElim = DiagnosiEliminate::create([
            'id_utente' => $idPaziente,
            'id_diagnosi' => $getIdDiagnosi
        ]);
        
        $diagnosiElim->save();
        
        return Redirect::back();
    }

    /**
     * aggiunge una diagnosi
     */
    public function aggiungiDiagnosi($stato, $cpp, $idPaz, $patol)
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
        if ($stato == 0) {
            $st = 'Confermata';
        }
        if ($stato == 1) {
            $st = 'Sospetta';
        }
        if ($stato == 2) {
            $st = 'Esclusa';
        }
        
        $cppSt = $cpp . "/(" . $st . ")";
        
        $cppDiagnosi = CppDiagnosi::create([
            'diagnosi_stato' => $stato,
            'careprovider' => $cppSt
        ]);

        $diagnosi = Diagnosi::create([
            'id_paziente' => $idPaz,
            'diagnosi_inserimento_data' => $data,
            'diagnosi_aggiornamento_data' => $data,
            'diagnosi_patologia' => $patol,
            'diagnosi_stato' => $stato,
            'diagnosi_guarigione_data' => $data
        ]);
        
        $cppDiagnosi->save();
        $diagnosi->save();
        
        return Redirect::back();
    }

    /**
     * permette di modificare una diagnosi
     */
    public function modificaDiagnosi($idDiagnosi, $stato, $cpp)
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
        
        $carep = CppDiagnosi::all();
        
        $all;
        
        foreach ($carep as $c) {
            if ($c->id_diagnosi == $idDiagnosi) {
                $all = $c->careprovider;
            }
        }
        
        $st;
        if ($stato == 1) {
            $st = 'Sospetta';
        }
        if ($stato == 2) {
            $st = 'Confermata';
        }
        if ($stato == 3) {
            $st = 'Esclusa';
        }
        
        $all = $all . "-" . $cpp . "/(" . $st . ")";
        
        $match = [
            'id_diagnosi' => $idDiagnosi
        ];
        
        $editCppDiagnosi = \DB::table('tbl_cpp_diagnosi')->where($match)->update([
            'diagnosi_stato' => $st,
            'careprovider' => $all
        ]);
        
        $editDiagnosi = \DB::table('tbl_diagnosi')->where($match)->update([
            'diagnosi_aggiornamento_data' => $data,
            'diagnosi_stato' => $stato
        ]);
        
        return Redirect::back();
    }

    public function getDiagnosi(){

          $id_user = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();

          $diagnosi = Diagnosi::where('id_paziente', $id_user)->get();

            return $diagnosi->toJson();

        }
}
