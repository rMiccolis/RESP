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
use App\Models\InvestigationCenter\Indagini;
use App\Models\Patient\ParametriVitali;
use App\Models\EsamiObiettivi;
use App\Models\Parente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Anamnesi;
use App\Models\Patient\Pazienti;
use Auth;
use function MongoDB\BSON\toJSON;
use PDF;
use phpDocumentor\Reflection\Types\This;

use Session;

class AlgoritmoDiagnosticoController extends Controller
{

    public function avviaAlgoritmoDiagnostico()
    {
        
        $arrAlgDescr = array(); 
        $arrAlgCode = array();

        /*
        * Array contenente le patologie diagnosticate.* Questo array contiene le patologie ordinate nello stesso ordine della struttura contenente tutti i punteggi
        */
        $arrayPatologie = array("426.0","429.3","426.89","427.81","427.69","427.89","427.0","427.1","427.32","427.31","397.0","428.0","746.6","424.1","745.4","746.02","745.5","785.2","424.0","242.90","395.1","424.2","394.0","424.3","747.0","417.0","747.29");
        /*
        * Variabile contenente il numero di patologie.
        */
        $numPatologie = count($arrayPatologie);

        /*
        Matrice contenente i vaolri relativi le patologie:
        SESSO = M, F, NULL
        ETA = < e > che indica se la patologica ha una minore o maggiore incidenza di una certa soglia
              n indica che non è bloccato, cioè viene assegnato il punteggio minimo oltre la soglia
              s indica che è bloccato, cioè viene asseganto il punteggio 0 oltre la soglia
        MORTALITA = alto, basso, NULL
        EVOLUZIONE = si, no
        */
        $patologieIncidenza = array("SESSO" => array("M","NULL","NULL","NULL","NULL","NULL","NULL","NULL","M","M","F","NULL","NULL","NULL","NULL","NULL","NULL",
                                                     "NULL","M","NULL","NULL","F","F","NULL","NULL","NULL","NULL"),
                                    "ETA" => array(">n40","NULL","NULL",">n50",">n50","<n12","NULL",">n50",">n50",">n50",">n40",">n40",">n50",">n60",">n12",">n30",           ">n50","NULL",">n50",">n70",">n40","NULL",">n40","NULL","<s1","NULL", "NULL"),
                                    "MORTALITA" => array("alto","alto","alto","alto","alto","basso","NULL","alto","alto","alto","alto","alto","basso","alto","NULL"                 ,"basso","basso","NULL","basso","NULL","basso","alto","basso","alto","basso","NULL", "basso"),
                                    "EVOLUZIONE" => array("si","no","no","no","no","no","no","no","no","no","si","si","no","si","no","no","no","no","no","no","no",                 "no","no","no","no","no", "no"));

        //array coefficienti
        $arrayCoeffIncidenza=array();

        //array punteggi
        $arrayPunteggi= array();

        /*
            Struttura contenente codici e punteggi dell'anamnesi, esami e farmaci per ogni patologia diagnosticabile.       
        */
        $strutturaPunteggiPatologie = array("426.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("414.8", "401.9", "746.9", "420.90"                                                                                                                ,"516.9","999.9", "276.9"),
                                                                                        "PUNTEGGI" => array("4", "4", "3", "3", "4", "4", "3")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"      => array("CODICI"   => array("780.2", "909.4", "780.97", "780.93",                                                              "789.09", "785.1", "780.79"),
                                                                                            "PUNTEGGI" => array("3", "3", "2", "2", "2", "2", "2")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","89.50", "89.43", "88.55", "37.26"),
                                                                             "PUNTEGGI" => array("4", "5", "3", "3", "3"))
                                                ),

                                "429.3" => array("ANAMNESI_FISIOLOGICA"     => array("CODICI"   => array("E008.9"),
                                                                                        "PUNTEGGI" => array("5")),

                                                "ANAMNESI_PATOLOGICA_REMOTA"        => array("CODICI"   => array("427.89", "426.0", "427.61", "427.0"),
                                                                                     "PUNTEGGI" => array("5", "3", "2", "2")),
                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("87.44","88.72", "89.50","89.52"),
                                                                             "PUNTEGGI" => array("5","3", "5", "4"))
                                                ),

                                "426.89" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("998.9", "410.0", "429.9", "427.2", "Y05.0",                                                                          "972.1"),
                                                                                        "PUNTEGGI" => array("3", "3", "3", "2", "2", "3")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"      => array("CODICI"   => array("786.09", "785.1", "780.4", "780.79"),
                                                                                             "PUNTEGGI" => array("4", "4", "4", "4")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("80281-9", "X00025-9", "8890-6"),
                                                                             "RISPOSTA" => array("LA25139-9","XX0026-7","XX0033-3"),
                                                                             "PUNTEGGI" => array("4","4", "4")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","89.50"),
                                                                             "PUNTEGGI" => array("4","5")),
                                                "FARMACI_ASSUNTI"   => array("CODICI"   => array("cf085"),
                                                                             "PUNTEGGI" => array("3"))
                                                ),

                                "427.81" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                    "ANAMNESI_PATOLOGICA_PROSSIMA"      => array("CODICI"   => array("789.09", "909.4", "438.85", "                                                                             780.97", "782.62", "780.79"),
                                                                                                 "PUNTEGGI" => array("3", "3", "3", "3", "3", "3")),

                                                    "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("X00015-0"),
                                                                             "RISPOSTA" => array("XX0016-8"),
                                                                             "PUNTEGGI" => array("3")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52", "37.26", "89.50"),
                                                                             "PUNTEGGI" => array("4", "3", "5")),
                                                "FARMACI_ASSUNTI"   => array("CODICI"   => array("cf067", "cf085", "cf046", "cf071"),
                                                                             "PUNTEGGI" => array("3", "3", "3", "3"))
                                                ),

                                "427.69" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("429.2", "746.9", "401.9"),
                                                                                        "PUNTEGGI" => array("4", "4", "4")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"      => array("CODICI"   => array("785.1", "786.51", "427.2", "427.89",                                                               "Y04.0", "850.5", "728.87"),
                                                                                                 "PUNTEGGI" => array("4", "4", "4", "4", "4", "3", "3")),

                                                  "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array("303.90", "304.20", "304.40", "305.1", "E008.9"),
                                                                                        "PUNTEGGI" => array("4", "4", "4", "4", "3")),

                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52", "89.50"),
                                                                             "PUNTEGGI" => array("4","5")),
                                                "FARMACI_ASSUNTI"   => array("CODICI"   => array("cf119"),
                                                                             "PUNTEGGI" => array("4"))
                                                ),

                                "427.89" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("285.9", "194.0", "458.9", "785.50", "415.1",                                                                      "414.8", "428.0"),
                                                                                        "PUNTEGGI" => array("5", "3", "4", "4", "4", "4", "4")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("780.6","300.00","785.50","785.1",                                                                 "786.09","438.85","780.8","780.97",                                                                 "789.09","909.4"),
                                                                                        "PUNTEGGI" => array("4","3","3","4","4","4","4","4","4","2")),

                                                  "ANAMNESI_FISIOLOGICA"        => array("CODICI"   => array("E008.9","11449-6"),
                                                                                         "PUNTEGGI" => array("3","3")),

                                                "ESAMI_LAB"         => array("CODICI"   => array("69742-5")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52", "89.50"),
                                                                             "PUNTEGGI" => array("4","5")),
                                                "FARMACI_ASSUNTI"   => array("CODICI"   => array("cf066","cf117","cf130"),
                                                                             "PUNTEGGI" => array("3","3","3"))
                                                ),

                                "427.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("429.9"),
                                                                                        "PUNTEGGI" => array("4")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("785.0", "785.1", "786.09", "789.09",                                                          "786.06", "438.85", "909.4", "355.1"),
                                                                                             "PUNTEGGI" => array("5", "4", "4", "4", "4", "4", "4", "4")),

                                                  "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52", "89.50"),
                                                                             "PUNTEGGI" => array("4","5"))
                                                ),

                                "427.1" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("410.0", "429.2", "394.9", "429.9",                                                            "746.89", "426.7", "745.2", "759.82", "875.0"),
                                                                                        "PUNTEGGI" => array("5", "5", "4", "4", "2", "2", "1", "1", "3")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("785.1", "786.09", "438.85", "909.4"),
                                                                                             "PUNTEGGI" => array("4", "4", "4", "4")),

                                                   "ANAMNESI_FISIOLOGICA"   => array("CODICI"   => array("303.90", "304.20", "304.40", "305.1", "309.9"),
                                                                                     "PUNTEGGI" => array("4", "4", "4", "4", "4")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("45644-2","X00015-0"),
                                                                             "RISPOSTA" => array("LA00033-6","XX0016-8"),
                                                                             "PUNTEGGI" => array("3","4")),
                                                "ESAMI_LAB"         => array("CODICI"   => array("17861-6","32698-3","2774-8")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","88.72","87.44","88.55","89.50"),
                                                                             "PUNTEGGI" => array("4","3","3","3","3"))
                                                ),

                                "427.32" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("242.90", "410.0", "394.9", "390",                                                                                  "429.2", "420.90", "519.9"),
                                                                                        "PUNTEGGI" => array("4", "4", "4", "4", "4", "4", "3")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("427.2", "785.1", "909.4", "786.09",                                                              "789.09", "780.79", "401.9"),
                                                                                             "PUNTEGGI" => array("5", "4", "4", "4", "4", "4", "3")),

                                                   "ANAMNESI_FISIOLOGICA"   => array("CODICI"   => array("303.90", "304.20", "304.40", "305.1", "278.00"),
                                                                                     "PUNTEGGI" => array("4", "4", "4", "4", "4")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("8866-6"),
                                                                             "RISPOSTA" => array("XX0021-8"),
                                                                             "PUNTEGGI" => array("4")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","88.72","87.44","88.55","89.50"),
                                                                             "PUNTEGGI" => array("4","3","3","3","5"))
                                                ),

                                "427.31" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("998.9", "429.2", "428.0", "390",                                                          "746.9", "420.90", "427.81", "242.90", "250.90", "516.9"),
                                                                                        
                                                                                        "PUNTEGGI" => array("5", "4", "5", "4", "4", "4", "4", "2", "2", "2")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("401.9", "785.1", "427.2", "780.4",                                                    "786.09", "780.79", "789.09", "780.8", "780.57"),
                                                                                             "PUNTEGGI" => array("4", "5", "5", "3", "3", "3", "3", "3",                 "1")),

                                                   "ANAMNESI_FISIOLOGICA"   => array("CODICI"   => array("278.00", "303.90", "304.40", "309.9"),
                                                                                     "PUNTEGGI" => array("2", "1", "1", "1")),

                                            
                                                "ESAMI_LAB"         => array("CODICI"   => array("27353-2","3026-2","3053-6")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","89.50"),
                                                                             "PUNTEGGI" => array("4","5"))
                                                ),

                                "397.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("416.0", "782.3", "427.32", "427.31"),
                                                                                        
                                                                                        "PUNTEGGI" => array("5", "4", "3", "3")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("780.79", "785.0", "789.01", "Y04.0", "780.8"),
                                                                                             "PUNTEGGI" => array("3", "4", "4", "5", "3")),

                                                  "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("32447-5","18115-6","80281-9"),
                                                                             "RISPOSTA" => array("XX0030-9","XX0038-2","LA25139-9"),
                                                                             "PUNTEGGI" => array("2","4","4")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","87.44","89.68"),
                                                                             "PUNTEGGI" => array("1","1","5"))
                                                ),

                                "428.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("401.9", "429.2", "427.2", "242.90",                                                           "425.8", "410.0", "250.90"),
                                                                                        
                                                                                        "PUNTEGGI" => array("5", "5", "5", "4", "4", "4", "4")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("780.79", "782.3", "786.09", "780.8"),
                                                                                             "PUNTEGGI" => array("5", "4", "3", "3")),

                                                  "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array("303.90", "305.1", "V69.0", "278.00"),
                                                                                     "PUNTEGGI" => array("5", "5", "4", "4")),

                                                  "ANAMNESI_FAMILIARE"  => array("CODICI"   => array("428.0"),
                                                                                     "PUNTEGGI" => array("2")),


                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("8462-4","8480-6", "X00022-6", "8866-6", "8866-6","8866-6", "69428-1", "69428-1", "69428-1","39107-8", "44968-6", "44968-6", "39107-8","39107-8", "55407-1", "55407-1", "55407-1","X00015-0", "80276-9", "80276-9", "18113-1", "18115-6", "80281-9", "80319-7","80319-7","33455-7", "33455-7", "32449-1","32447-5","32447-5", "80271-0"),
                                                                             "RISPOSTA" => array("XX0041-6","XX0042-4","XX0024-2","XX0019-2", "XX0021-8", "XX0018-4", "XX0012-7","XX0013-5", "XX0014-3", "LA17206-6", "XX0002-8","XX0003-6", "LA17198-5", "LA17205-8", "LA11841-6","LA11842-4", "LA11844-0", "XX0016-8","LA18244-6","LA25116-7", "XX0036-6", "XX0038-2", "LA25144-9", "LA19732-9", "LA25244-7", "XX0004-4","XX0005-1","XX0032-5","XX0030-9", "XX0034-1", "XX0031-7"),
                                                                             "PUNTEGGI" => array("2","3","3","2","2","2","1","2","3","1","1","1","2","3","1","2","3","1","4","2","2","2","2","2","2","5","5","2","2","3","2")),
                                                "ESAMI_LAB"         => array("CODICI"   => array("30934-4","17861-6","2823-3","2951-2","32698-3","2075-0","3094-0","2160-0","27353-2","1751-7")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","87.44","88.72"),
                                                                             "PUNTEGGI" => array("1","1","5")),
                                                "FARMACI_ASSUNTI"   => array("CODICI"   => array("cf119","cf071","cf093","cf051","cf070"),
                                                                             "PUNTEGGI" => array("3","3","3","3","3"))
                                                ),

                                "746.6" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("421.9", "401.9", "394.9", "390"),
                                                                                        
                                                                                        "PUNTEGGI" => array("4", "1", "5", "4")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("780.79", "786.09", "786.2", "785.1",                                          "782.3"),
                                                                                             "PUNTEGGI" => array("4", "4", "3", "3", "2")),

                                                  "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("18113-1","80281-9"),
                                                                             "RISPOSTA" => array("XX0036-6","LA25139-9"),
                                                                             "PUNTEGGI" => array("4","4")),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.72","87.44","89.52","89.59"),
                                                                             "PUNTEGGI" => array("5","1","1","3"))
                                                ),

                                "424.1" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("390", "581.81", "746.9", "714.0", "272.4",                                                                         "909.2", "710.0", "731.0"),
                                                                                        
                                                                                        "PUNTEGGI" => array("4", "3", "3", "2", "2", "2", "2", "2")),

                                                  "ANAMNESI_PATOLOGICA_PROSSIMA"    => array("CODICI"   => array("909.4", "413.0", "786.09"),
                                                                                             "PUNTEGGI" => array("5", "5", "4")),

                                                  "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("8866-6","8866-6","18112-3","80281-9"),
                                                                             "RISPOSTA" => array("XX0019-2","XX0020-0","XX0035-8", "LA25139-9"),
                                                                             "PUNTEGGI" => array("4","4","4","4")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.68","88.55"),
                                                                             "PUNTEGGI" => array("5","3"))
                                                ),

                                "745.4" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("758.0", "041.9"),
                                                                                        
                                                                                        "PUNTEGGI" => array("3", "3")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("786.05", "427.2", "782.61", "782.5",                                                             "780.8"),
                                                                                             "PUNTEGGI" => array("4", "4", "4", "3", "2")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FAMILIARE"    => array("CODICI"   => array("746.9"),
                                                                                             "PUNTEGGI" => array("2")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("42160-2","80282-7","80278-5"),
                                                                             "RISPOSTA" => array("XX0040-8", "LA25146-4","LA25126-6"),
                                                                             "PUNTEGGI" => array("4","2","5")),
                                            
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.72","37.23","88.92"),
                                                                             "PUNTEGGI" => array("5","4","3"))
                                                ),

                                "746.02" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("764.90"),
                                                                                        
                                                                                        "PUNTEGGI" => array("4")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("787.3", "782.5", "789.09", "909.4",                                                              "785.1", "780.79", "786.05"),
                                                                                             "PUNTEGGI" => array("4", "4", "4", "4", "4", "4", "4")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FAMILIARE"    => array("CODICI"   => array("747.3"),
                                                                                             "PUNTEGGI" => array("2")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("18114-9","80281-9"),
                                                                             "RISPOSTA" => array("XX0037-4", "LA25139-9"),
                                                                             "PUNTEGGI" => array("5","5")),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","87.44","88.72","88.97"),
                                                                             "PUNTEGGI" => array("1","1","5","3"))
                                                ),

                                "745.5" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("758.0", "759.89", "279.11", "759.89",                                                                              "759.82", "427.31", "427.32", "434.91"),
                                                                                        
                                                                                        "PUNTEGGI" => array("3", "2", "2", "2", "2", "3", "3", "2")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("427.2", "780.79", "429.3", "782.5",                                                              "786.09", "780.8",),
                                                                                             "PUNTEGGI" => array("5", "5", "2", "2", "3", "2")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("80278-5"),
                                                                             "RISPOSTA" => array("LA25124-1"),
                                                                             "PUNTEGGI" => array("5")),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.72"),
                                                                             "PUNTEGGI" => array("5"))
                                                ),

                                "785.2" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("746.9"),
                                                                                        
                                                                                        "PUNTEGGI" => array("5")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array(),
                                                                             "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("80281-9","80278-5"),
                                                                             "RISPOSTA" => array("LA25139-9","LA25122-5"),
                                                                             "PUNTEGGI" => array("5","5"))
                                                ),

                                "424.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("759.82", "737.31", "359.1", "242.00",                                                                              "401.9"),
                                                                                        
                                                                                        "PUNTEGGI" => array("4", "3", "3", "3", "4")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("785.1", "786.09", "786.02", "780.79",                                                              "346.91", "789.09"),
                                                                                         "PUNTEGGI" => array("3", "3", "3", "3", "3", "3")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FAMILIARE"    => array("CODICI"   => array("424.0"),
                                                                                             "PUNTEGGI" => array("2")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("80281-9"),
                                                                             "RISPOSTA" => array("LA25139-9"),
                                                                             "PUNTEGGI" => array("5")),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("87.44","89.52"),
                                                                             "PUNTEGGI" => array("1","1"))
                                                ),


                                "242.90" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("783.21", "799.25", "296.30", "314.8",                                                                              "242.00"),
                                                                                        
                                                                                        "PUNTEGGI" => array("5", "4", "4", "4", "5")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("780.79", "780.8", "782.3", "785.1",                                                            "427.2", "787.03", "787.02", "009.2"),
                                                                                         "PUNTEGGI" => array("5", "4", "4", "3", "3", "3", "3", "3")),

                                                "ANAMNESI_FISIOLOGICA"  => array("CODICI"   => array("606.9", "628.9"),
                                                                                             "PUNTEGGI" => array("3", "3")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("32479-8","X00015-0","X00022-6","44968-6","44968-6",                                                "77701-1","8699-1","8699-1","32431-9","32431-9"),
                                                                             "RISPOSTA" => array("XX0029-1","XX0016-8","XX0023-4","XX0001-0","XX0003-6",                  "LA23605-1","XX0006-9","XX0007-7","XX0008-5","XX0009-3"),
                                                                             "PUNTEGGI" => array("5", "3","3","3","3","4","5","5","5","5")),
                                                "ESAMI_LAB"         => array("CODICI"   => array("30341-2","27975-2","3053-6","3026-2")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.71","92.01"),
                                                                             "PUNTEGGI" => array("5","5"))
                                                ),

                                "395.1" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("785.2", "746.9", "421.9", "390",                                                                           "759.82", "720.0", "097.9", "401.9"),
                                                                                        
                                                                                        "PUNTEGGI" => array("4", "4", "4", "4", "3", "3", "3", "5")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("780.79", "786.09", "413.0", "909.4",                                                           "427.2", "787.03"),
                                                                                         "PUNTEGGI" => array("5", "5", "4", "4", "4", "4")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("18112-3","80281-9","80280-1"),
                                                                             "RISPOSTA" => array("XX0035-8", "LA25138-1","LA25133-2"),
                                                                             "PUNTEGGI" => array("4","4","4")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.68","87.44","89.52","89.59","37.23"),
                                                                             "PUNTEGGI" => array("5","1","1","3","3"))
                                                ),

                                "424.2" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("420.90", "746.9", "783.1", "041.09",                                                                           "259.2", "212.7", "010.90"),
                                                                                         "PUNTEGGI" => array("1", "2", "3", "2", "2", "2", "1")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("785.0", "789.06", "780.79", "782.0"),
                                                                                         "PUNTEGGI" => array("4", "4", "4", "4")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("18115-6","80281-9","80282-7","80282-7"),
                                                                             "RISPOSTA" => array("XX0038-2", "LA25139-9","LA25146-4","LA25132-4"),
                                                                             "PUNTEGGI" => array("5","5","5","5")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","87.44","88.72","37.23"),
                                                                             "PUNTEGGI" => array("1","1","5","3"))
                                                ),

                                "394.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("398.90", "362.64", "746.9", "421.9",                                                                               "427.31", "359.3", "782.3"),
                                                                                         "PUNTEGGI" => array("5", "3", "3", "3", "3", "3", "2")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array("401.9", "786.09", "789.09"),
                                                                                         "PUNTEGGI" => array("5", "5", "1")),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("33455-7","33455-7","39107-8","X00027-5","80281-9"),
                                                                             "RISPOSTA" => array("XX0004-4", "XX0005-1","LA17198-5","X00027-5","LA25138-1"),
                                                                             "PUNTEGGI" => array("3","3","3","3","3")),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("89.52","88.72","87.44","37.23"),
                                                                             "PUNTEGGI" => array("1","5","1","3"))
                                                ),

                                "424.3" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("746.81", "746.6", "390", "259.2",                                                                                  "427.31"),
                                                                                         "PUNTEGGI" => array("4", "4", "1", "1", "1")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FAMILIARE"    => array("CODICI"   => array("421.9"),
                                                                                         "PUNTEGGI" => array("2")),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("66618-0","18114-9","80282-7"),
                                                                             "RISPOSTA" => array("LA00133-6","XX0037-4","LA25150-6"),
                                                                             "PUNTEGGI" => array("4","5","5")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.72","87.44","88.97","88.55","88.76"),
                                                                             "PUNTEGGI" => array("5","1","3","3","1"))
                                                ),

                                "747.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("799.02", "518.84", "644.20"),
                                                                                         "PUNTEGGI" => array("4", "4", "4")),

                                                "ANAMNESI_PATOLOGICA_PROSSIMA"  => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("8462-4","8480-6","18114-9"),
                                                                             "RISPOSTA" => array("XX0041-6","XX0042-4","XX0037-4"),
                                                                             "PUNTEGGI" => array("4","4","5")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.72","87.44","89.68"),
                                                                             "PUNTEGGI" => array("5","1","4"))
                                                ),

                                "417.0" => array("ANAMNESI_PATOLOGICA_REMOTA"   => array("CODICI"   => array("338.11", "442.89"),
                                                                                         "PUNTEGGI" => array("3", "3")),

                                                 "ANAMNESI_PATOLOGICA_PROSSIMA"     => array("CODICI"   => array("388.30", "372.00", "376.30"),
                                                                                             "PUNTEGGI" => array("3", "3", "3")),

                                                 "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("80281-9"),
                                                                             "RISPOSTA" => array("LA25139-9"),
                                                                             "PUNTEGGI" => array("4")),
                                                
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.41","88.97","87.41"),
                                                                             "PUNTEGGI" => array("5","2","2"))
                                                ),

                                "747.29" => array("ANAMNESI_PATOLOGICA_REMOTA"  => array("CODICI"   => array("440.9", "097.9", "Y03.0", "421.0"),
                                                                                         "PUNTEGGI" => array("3", "3", "3", "3")),

                                                 "ANAMNESI_PATOLOGICA_PROSSIMA"     => array("CODICI"   => array("789.09"),
                                                                                             "PUNTEGGI" => array("5")),

                                                 "ANAMNESI_FISIOLOGICA"    => array("CODICI"   => array(),
                                                                                        "PUNTEGGI" => array()),

                                                "ESAMI_OBIETTIVI"   => array("CODICI"   => array("80281-9"),
                                                                             "RISPOSTA" => array("LA25138-1"),
                                                                             "PUNTEGGI" => array("5")),
                                                "ESAMI_STRUMENTALI" => array("CODICI"   => array("88.72","88.97","88.41","88.42","37.23"),
                                                                             "PUNTEGGI" => array("5","3","3","3","3"))
                                                )
                                );

        /*
        * Matrice contenente le patologie con il relativo punteggio totale, ovvero 
        * il punteggio dato dalla moltiplicazione del coefficiente per il punteggio.
        */
        $matricePatologiePunteggi = array("PATOLOGIE" =>array("426.0","429.3","426.89","427.81","427.69","427.89","427.0","427.1","427.32","427.31","397.0",                                                    "428.0","746.6","424.1","745.4","746.02","745.5","785.2","424.0","242.90","395.1","424.2","394.0",                                                  "424.3","747.0","417.0","747.29"),
                                       "PUNTEGGI_SOMMA" =>array("59","34","56","45","70","85","46","86","97","80","51","154","48","58","48","54","48","15","44",                    "107","81","59","58","40","35","28","39"),
                                    "PUNTEGGIO_TOTALE" => array());


        //Recupero i dati circa le informazioni del paziene e la sua storia clinica
        $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
        $userid = Pazienti::where('id_utente', $id)->first()->id_paziente;

        //informazioni paziente
        $patient_sesso = Pazienti::where('id_paziente', $userid)->first()->paziente_sesso;
        $patient_dataNascita = Pazienti::where('id_paziente', $userid)->first()->paziente_nascita;
        $today = new \Datetime(date('Y-m-d'));
        $patient_eta = $today->diff($patient_dataNascita)->y;
        $patient_peso = ParametriVitali::where('id_paziente', $userid)->first()->parametro_peso;
        $patient_altezza = ParametriVitali::where('id_paziente', $userid)->first()->parametro_altezza;

        //array codici Anamnesi
        $anamnesiPatologica = AnamnesiPt::where('id_paziente', $userid)->first()->id;
        $arrayCodeAnamPatRem = AnamnesiPtCodificate::where([
                'id_anamnesi_pt' => $anamnesiPatologica,
                'stato' => 'remota'
            ])->pluck('codice_diag')->toArray();
        
        $arrayCodeAnamPatPross = AnamnesiPtCodificate::where([
            'id_anamnesi_pt' => $anamnesiPatologica,
            'stato' => 'prossima'
            ])->pluck('codice_diag')->toArray();

        $anamnesiFamiliare = AnamnesiFm::where('id_paziente', $userid)->first()->id;
        $arrayCodePatFam = AnamnesiFmCodificate::where([
            'id_anamnesi_fm' => $anamnesiPatologica
            ])->pluck('codice_diag')->toArray();

        //array codici esami obiettivi
        $arrayCodeEsOb = EsamiObiettivi::where('id_paziente', $userid)->pluck('codice_risposta_loinc')->toArray();

        //array codici esami strumentali
        $arrayCodeEsStr = Indagini::where('id_paziente', $userid)->pluck('codice_ICD')->toArray();

        //Anmanesi fisiologica fumo
        $fisiologica_fumo = AnamnesiFisiologica::where('id_paziente', $userid)->first()->fumo;
        $fisiologica_fumoAnnoInizio = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dataInizioFumo;
        $fisiologica_fumoAnnoFine = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dataFineFumo;
        $fisiologica_fumoQuantita = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dosiFumo;

        //Anmanesi fisiologica alcool
        $fisiologica_alcool = AnamnesiFisiologica::where('id_paziente', $userid)->first()->alcool;
        $fisiologica_alcoolAnnoInizio = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dataInizioAlcool;
        $fisiologica_alcoolAnnoFine = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dataFineAlcool;
        $fisiologica_alcoolQuantita = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dosiAlcool;
        $fisiologica_alcoolTipo = AnamnesiFisiologica::where('id_paziente', $userid)->first()->tipoAlcool;

        //Anmanesi fisiologica droga
        $fisiologica_droghe = AnamnesiFisiologica::where('id_paziente', $userid)->first()->droghe;
        $fisiologica_drogaAnnoInizio = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dataInizioDroghe;
        $fisiologica_drogaAnnoFine = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dataFineDroghe;
        $fisiologica_drogaQuantita = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dosiDroghe;
        $fisiologica_drogaTipo = AnamnesiFisiologica::where('id_paziente', $userid)->first()->tipoDroghe;

        //Anmanesi fisiologica caffeina
        $fisiologica_caffeina = AnamnesiFisiologica::where('id_paziente', $userid)->first()->caffeina;
        $caffeinaQuantita = AnamnesiFisiologica::where('id_paziente', $userid)->first()->dosiCaffeina;

        //Anmanesi fisiologica stress
        $fisiologica_stress = AnamnesiFisiologica::where('id_paziente', $userid)->first()->stress;

        //Anamnesi fisiologica attivita fisica
        $fisiologica_attivitaFisica = AnamnesiFisiologica::where('id_paziente', $userid)->first()->attivitaFisica;

        //Anmanesi fisiologica gravidanza
        $fisiologica_GravidanzaEta = Gravidanza::where('id_paziente', $userid)->pluck('eta')->toArray();

        /*
        * Setto le variaibli con il valore di ritorno per ogni funzione, e in base a questi valori 
        * viene crreato l'array dei codici relativi l'anamnesi Fisiologica.
        */
        $varAbusoAlcool = $this->calcoloPuntAbusoAlcool($fisiologica_alcool,$this->calcoloDurataAbuso($fisiologica_alcoolAnnoInizio,$fisiologica_alcoolAnnoFine),$fisiologica_alcoolQuantita,$patient_sesso,$patient_eta,$fisiologica_alcoolTipo);
        $varAbusoFumo = $this->calcoloPuntAbusoFumo($fisiologica_fumo,$this->calcoloDurataAbuso($fisiologica_fumoAnnoInizio,$fisiologica_fumoAnnoFine),$fisiologica_fumoQuantita);
        $varAbusoDroga = $this->calcoloPuntAbusoDroga($fisiologica_droghe,$this->calcoloDurataAbuso($fisiologica_drogaAnnoInizio,$fisiologica_drogaAnnoFine),$fisiologica_drogaQuantita,$fisiologica_drogaTipo);
        $varcalcoloPuntAbusoCaffeina = $this->calcoloPuntAbusoCaffeina($fisiologica_caffeina,$caffeinaQuantita);
        $varVitaSedentaria = $this->calcoloPuntVitaSedentaria($fisiologica_attivitaFisica);
        $varAttivitaFisica = $this->calcoloPuntAttivitaFisica($fisiologica_attivitaFisica);
        $varbmi = $this->calcoloPuntBmi($patient_peso,$patient_altezza);
        $varStress = $this->calcoloPuntStress($fisiologica_stress);
        $varcalcoloPuntGravidanza = $this->calcoloPuntGravidanza($fisiologica_GravidanzaEta,$userid);

        $matricePuntAnamFisio = array("PATOLOGIE" =>array("305.1","303.90","304.20","304.40","V69.0","E008.9","278.00","309.9","11449-6"),
                                    "PUNTEGGIO" => array($varAbusoFumo,$varAbusoAlcool,$varAbusoDroga,$varcalcoloPuntAbusoCaffeina,$varVitaSedentaria,$varAttivitaFisica,$varbmi,$varStress,$varcalcoloPuntGravidanza));

        
        /*
        * Richiamo della funzione che somma i coefficienti.
        */
        $patIncidSesso = array();
        $patIncidEta = array();
        $patIncidMort = array();
        $patIncidEvol = array();
        for($i=0;$i<$numPatologie;$i++){
            $patIncidSesso[$i]=$patologieIncidenza['SESSO'][$i];
            $patIncidEta[$i]=$patologieIncidenza['ETA'][$i];
            $patIncidMort[$i]=$patologieIncidenza['MORTALITA'][$i];
            $patIncidEvol[$i]=$patologieIncidenza['EVOLUZIONE'][$i];
            $arrayCoeffIncidenza[$i]=$this->sommaCoeffIncidenza($patient_eta, $patIncidEta[$i], $patient_sesso, $patIncidSesso[$i], $patIncidMort[$i], $patIncidEvol[$i]);
        }


        $arrayPunteggioEsOb= array();
        $arrayPunteggioAnamFam= array();
        $arrayPunteggioAnamRem= array();
        $arrayPunteggioAnamPros= array();
        $arrayPunteggioAnamFisio= array();      
        $arrayPunteggioEsStr= array();

        //Calcolo il punteggio in base ai codici ICD prensenti nell'anamnesi familiare, patologica remota e prossima
        $arrayPunteggioAnamFam = $this->calcoloPunteggioAnamFam($arrayCodePatFam,$strutturaPunteggiPatologie,$arrayPatologie,$arrayPunteggioAnamFam,'ANAMNESI_FAMILIARE','CODICI',$numPatologie);
        $arrayPunteggioAnamRem = $this->calcoloPunteggio($arrayCodeAnamPatRem,$strutturaPunteggiPatologie,$arrayPatologie,$arrayPunteggioAnamRem,'ANAMNESI_PATOLOGICA_REMOTA','CODICI',$numPatologie);
        $arrayPunteggioAnamPros = $this->calcoloPunteggio($arrayCodeAnamPatPross,$strutturaPunteggiPatologie,$arrayPatologie,$arrayPunteggioAnamPros,'ANAMNESI_PATOLOGICA_PROSSIMA','CODICI',$numPatologie);
        $arrayPunteggioAnamFisio = $this->calcoloPunteggioAnamInfo($matricePuntAnamFisio,$strutturaPunteggiPatologie,$arrayPatologie,$arrayPunteggioAnamFisio,$numPatologie);
        $arrayPunteggioEsOb = $this->calcoloPunteggio($arrayCodeEsOb,$strutturaPunteggiPatologie,$arrayPatologie,$arrayPunteggioEsOb,'ESAMI_OBIETTIVI','RISPOSTA',$numPatologie);
        $arrayPunteggioEsStr = $this->calcoloPunteggio($arrayCodeEsStr,$strutturaPunteggiPatologie,$arrayPatologie,$arrayPunteggioEsStr,'ESAMI_STRUMENTALI','CODICI',$numPatologie);   


        /* Somma in arrayPunteggi tutti i punteggi ricavati dalle varie funzioni 
        * e calcola la percentuale di una determinata patologia in base al punteggio_somma 
        * (la somma di tutti i punteggi relativi all'anamnesi, esami di una patologia) 
        * e il reale punteggio ottenuto in base al paziente.
        */
        $arrayPunteggiPerc = array();
        for($i=0;$i<$numPatologie;$i++){
            $arrayPunteggi[$i]=$arrayPunteggioAnamFam[$i]+$arrayPunteggioAnamRem[$i]+$arrayPunteggioAnamPros[$i]+$arrayPunteggioAnamFisio[$i]+$arrayPunteggioEsOb[$i]+$arrayPunteggioEsStr[$i];
            if($arrayPunteggi[$i]!=0){
                $arrayPunteggiPerc[$i] = ($arrayPunteggi[$i]*100) / ($matricePatologiePunteggi['PUNTEGGI_SOMMA'][$i]);
            }else{
                $arrayPunteggiPerc[$i] = 0;
            }
        }

        /*
        * Moltiplico il coefficiente per la percentuale ottenuta. 
        */

        $arrayPunteggioTotale = array();
        $arrayPunteggioTotale = $this->calcolaTotale($arrayCoeffIncidenza,$arrayPunteggiPerc);
        for($i=0;$i<$numPatologie;$i++){
            $matricePatologiePunteggi['PUNTEGGIO_TOTALE'][$i]=$arrayPunteggioTotale[$i];
        }


        /*
        * BubbleSort. Ordina in base al coefficiente più alto la relativa patologia
        */
        $size = count($matricePatologiePunteggi['PUNTEGGIO_TOTALE']);
            for ($i=0; $i<$size; $i++) {
                for ($j=0; $j<$size-1-$i; $j++) {
                    if ($matricePatologiePunteggi['PUNTEGGIO_TOTALE'][$j+1] > $matricePatologiePunteggi['PUNTEGGIO_TOTALE'][$j]) {                      
                        $this->swap($matricePatologiePunteggi['PUNTEGGIO_TOTALE'], $j, $j+1);
                        $this->swap($matricePatologiePunteggi['PATOLOGIE'], $j, $j+1);
                    }
                }
            }

        $codDiagCodici = Icd9DiagCodici::whereIn('codice_diag', $matricePatologiePunteggi['PATOLOGIE'])->get();

        $arrayPatOrdinate = array();

        for ($i=0; $i<count($codDiagCodici); $i++) {
            for ($k=0; $k<count($codDiagCodici); $k++) {
                if($matricePatologiePunteggi['PATOLOGIE'][$i] == $codDiagCodici[$k]->codice_diag){
                    $arrayPatOrdinate[$i] = $codDiagCodici[$k];
                }
            }
        }

        return response()->json($arrayPatOrdinate);
    }


    function swap(&$arr, $a, $b) {
        $tmp = $arr[$a];
        $arr[$a] = $arr[$b];
        $arr[$b] = $tmp;
    }

    /*
    * Funzione che calcola il punteggio totale per ogni patologia: Coefficiente*Punteggio
    */
    function calcolaTotale($coeff,$punteg){
        $totale = array();
        $sizeCoeff = (count($coeff));
        for($i=0;$i<$sizeCoeff;$i++){
            $totale[$i] = $coeff[$i]*$punteg[$i];
        }
        return $totale;
    }

    /*
    * Funzione che dato un codice presente nell'anamnesi, ricerca il suo relativo punteggio 
    * e lo aggiunge nella posizione j dell'arrayPunteggi.
    */
    function calcoloPunteggio($codePatDatabase,$struttura,$patologie,$punteggi,$anamnesi,$campo,$numPatologie){
    $sizeStruttura = count($struttura); 
    $sizeCodeDatabase = count($codePatDatabase);
    $punteggi = array();
    for($i=0;$i<$numPatologie;$i++){
        $punteggi[$i] = 0;
    }
        for($i=0;$i<$sizeCodeDatabase;$i++){
            for($j=0;$j<$sizeStruttura;$j++){
                $pat=$patologie[$j];
                if(!empty($struttura[$pat][$anamnesi][$campo])){
                    $size1 = count($struttura[$pat][$anamnesi][$campo]);
                    for($k=0;$k<$size1;$k++){
                        if($codePatDatabase[$i]==($struttura[$pat][$anamnesi][$campo][$k])){
                            $punteggi[$j] +=($struttura[$pat][$anamnesi]['PUNTEGGI'][$k]);
                        }                   
                    }
                }
            }               
        }
        return $punteggi;
    }

    /*
    * Funzione che determina il punteggio delle patologie presente nell'anamnesi familiare del paziente. 
    * Se una patologia è presente più di 3 volte nell'anamnesi familiare, il punteggio relativo ad essa sarà 3;
    * altrimenti è uguale al numero di volte presenti (0, 1, 2). 
    */
    function calcoloPunteggioAnamFam($codePatDatabase,$struttura,$patologie,$punteggi,$anamnesi,$campo,$numPatologie){
    $sizeStruttura = count($struttura); 
    $countsCodePat = array_count_values($codePatDatabase);
    $array = array();
    $punteggi = array();
    for($i=0;$i<$numPatologie;$i++){
        $punteggi[$i] = 0;
    }
    $sizeCodeDatabase = count($codePatDatabase);
        for($i=0;$i<$sizeCodeDatabase;$i++){
            for($j=0;$j<$sizeStruttura;$j++){
                $pat=$patologie[$j];
                if(!empty($struttura[$pat][$anamnesi][$campo])){
                    $size1 = count($struttura[$pat][$anamnesi][$campo]);
                    for($k=0;$k<$size1;$k++){
                        if($codePatDatabase[$i]==($struttura[$pat][$anamnesi][$campo][$k])){
                            if(!in_array($codePatDatabase[$i], $array)){
                                if($countsCodePat[$codePatDatabase[$i]]>4){
                                    $punteggi[$j] += 3;     
                                }else 
                                    $punteggi[$j] += $countsCodePat[$codePatDatabase[$i]];  
                                array_push($array, $codePatDatabase[$i]);
                            }
                        }                   
                    }
                }
            }               
        }
        return $punteggi;
    }


    /*
    * Funzione che dato un codice presente nell'anamnesi, ricerca il suo relativo punteggio 
    * e lo aggiunge nella posizione j dell'arrayPunteggi.
    */
    function calcoloPunteggioAnamInfo($matrice,$struttura,$patologie,$punteggi,$numPatologie){
    $sizeStruttura = count($struttura); 
    $sizeMatrice = count($matrice['PATOLOGIE']);
    $punteggi = array();
    for($i=0;$i<$numPatologie;$i++){
        $punteggi[$i] = 0;
    }
        for($i=0;$i<$sizeMatrice;$i++){
            for($j=0;$j<$sizeStruttura;$j++){
                $pat=$patologie[$j];
                if(!empty($struttura[$pat]['ANAMNESI_FISIOLOGICA']['CODICI'])){
                    $size1 = count($struttura[$pat]['ANAMNESI_FISIOLOGICA']['CODICI']);
                    for($k=0;$k<$size1;$k++){
                        if($matrice['PATOLOGIE'][$i]==($struttura[$pat]['ANAMNESI_FISIOLOGICA']['CODICI'][$k])){
                            $punt = ($struttura[$pat]['ANAMNESI_FISIOLOGICA']['PUNTEGGI'][$k]) * $matrice['PUNTEGGIO'][$i];
                            $punteggi[$j] += $punt;
                        }
                                          
                    }
                }
            }               
        }
        return $punteggi;
    }


    /*
    * Funzione che somma i coefficienti relativi l'incidenza per una singola patologia
    */
    function sommaCoeffIncidenza($pazEta, $patEta, $pazSesso, $patSesso, $patMortal, $patEvoluz)
    {
        return $this->calcoloCoeffIncidEta($pazEta, $patEta) + $this->calcoloCoeffIncidSesso($pazSesso, $patSesso) + $this->calcoloCoeffIncidMortalita($patMortal, $patEvoluz);
    }


    /*Funzione che ritorna il coefficiente relativo l'età in base all'età del paziente
    * l'incidenza dell'età di una patologia può essere maggiore o minore di una certa soglia. 
    * Per alcune patologie, l'incidenza può essere pari a 0 se non è presente nel range. 
    */
        function calcoloCoeffIncidEta($eta, $pat) 
        { 
        $costPerc = array( "4", "4.1", "4.2", "4.3", "4.4", "4.5", "4.6", "4.7", "4.8", "4.9", "5");
        $INTER_ETA = 10;
        $COEFF_INIZ = 0.70;
        $segno = substr($pat, 0, 1);
        $blocco = substr($pat, 1, 1);
        $patEta = substr($pat, 2, 4);
        $coeff = 0;
        if($pat!="NULL"){
            if($blocco=="n"){
                $coeffBlocco = $COEFF_INIZ;
            }else if($blocco=="s"){
                $coeffBlocco = 0;
            }
            if($segno==">"){
                if($eta<$patEta){
                    $coeff = $coeffBlocco;
                    }else{
                    $etaSott = $eta - $patEta;
                    $divisore = $etaSott / $INTER_ETA;
                    $coeff = $COEFF_INIZ + ((($COEFF_INIZ * $costPerc[$divisore])/100)*$etaSott);
                }
            }else if($segno=="<"){
                if($eta>$patEta){
                    $coeff = $coeffBlocco;
                    }else{
                    $etaSott = $patEta - $eta;
                    $divisore = $etaSott / $INTER_ETA;
                    $coeff = $COEFF_INIZ + ((($COEFF_INIZ * $costPerc[$divisore])/100)*$etaSott);
                }
            }
        }
        return $coeff;
        }


        //funzione che calcola il coefficente in base all'incidenza del sesso
    //1,33 rappresenta il sesso con l'incidenza maggiore
    function calcoloCoeffIncidSesso($patient_sesso, $patIncSesso)
    {
        if ($patient_sesso == $patIncSesso) {
            $coeff = 1.33;
        }else {
            $coeff = 0.66;
        }

    return $coeff;
    }


    //funzione che calcola il coefficente in base alla mortalità e all'evoluzione 
    //1,33 rappresenta la mortalità più alta che aumenta a 2,66 se l'evoluzione della malattia è rapida
    function calcoloCoeffIncidMortalita ($patologiaMortalita, $patologiaEvoluzione)
    {
        if ($patologiaMortalita == "alto"){
            if ($patologiaEvoluzione == "si"){
                $coeff = 2.66;
            } else {
                $coeff = 1.33;
            }
        }else if($patologiaMortalita == "basso"){
            $coeff = 0.66;
        }else{
            $coeff = 0;
        }
    return $coeff;
    }

    /*
    * Fuznione che restituisce il numero di anni dell'abuso
    */
        function calcoloDurataAbuso ($dataInizio, $dataFine){
            $numeroAnniEMesi=0;
            if(isset($dataInizio)){
                (int) $inizioAnno = substr($dataInizio, 0, 4);
                if(isset($dataFine)){  
                    $dataFine = date('Y/m/d'); 
                    (int) $fineAnno = substr($dataFine, 0, 4);
                }else{
                    (int) $fineAnno = substr($dataFine, 0, 4);
                }

                if (substr($dataInizio, 5, 1) == "0"){
                    (int) $inizioMese = substr($dataInizio, 6, 1);
                } else {
                    (int) $inizioMese = substr($dataInizio, 5, 2);
                }

                if (substr($dataFine, 5, 1) == "0"){
                    (int) $fineMese = substr($dataFine, 6, 1);
                } else {
                    (int) $fineMese = substr($dataFine, 5, 2);
                }
        
                $diffAnni = $fineAnno - $inizioAnno;
                $diffMesi = 0;
                if ($inizioMese <= $fineMese){
                    $diffMesi = $fineMese - $inizioMese;
                } else {
                    $tempDiff = 12 - $inizioMese;
                    $diffMesi = $tempDiff + $fineMese;
                    
                    if ($diffAnni != 0) {
                        $diffAnni = $diffAnni - 1 ;
                    }
                }   

                $numeroAnniEMesi = "".$diffAnni.".".$diffMesi."";
            }
            return $numeroAnniEMesi;
        }

    /*
    * Fuznione che verifica se il paziente abusa di fumo
    */
    function calcoloPuntAbusoFumo($fumo, $durataFumo, $quantitaFumo){
        $coefficente = 0;
        if (isset($fumo) & isset($quantitaFumo)){
            $coefficente = calcoloPuntAbuso(20, 30, $durataFumo, $quantitaFumo);
            if ($coefficente > 2){
                $coefficente = 2;
            }
        }
        return $coefficente;
    }


    function calcoloPuntAbuso($quantitativoMax, $punteggioMax, $durata, $quantita){
            $consumoAnnuo = $durata * ($quantita/$quantitativoMax);
            $percentuale = (100 * $consumoAnnuo)/$punteggioMax;
            $coefficente = (2 * $percentuale)/100;
            return $coefficente;
    }

    /*
    * Fuznione che verifica se il paziente abusa di alcool
    */
    function calcoloPuntAbusoAlcool($alcool, $durataAlcool, $quantitaAlcool, $sesso, $eta, $tipoAlcol){
        $COST_VINO = 125;
        $COST_BIRRA = 330;
        $COST_SUPERALCOLICO = 40;
        $coefficente = 0;
        $abuso = false;
        (int) $eta;
        if(isset($alcool) && isset($quantitaAlcool) && isset($tipoAlcol)){
            if($eta > 65){
                    $unita = 1;
            } else if ($sesso == "F"){
                    $unita = 2;
            } else {
                    $unita = 3;
            }

            if ($tipoAlcol == "Vino"){
                $maxTipoAlcol = $unita * $COST_VINO;
                if (($quantitaAlcool * $COST_VINO) > $maxTipoAlcol) {
                    $quantitàAssunta = $quantitaAlcool * $COST_VINO;
                    $abuso = true;
                }
            } else if ($tipoAlcol == "Birra"){
                $maxTipoAlcol = $unita * $COST_BIRRA;
                if (($quantitaAlcool * $COST_BIRRA) > $maxTipoAlcol) {
                    $quantitàAssunta = $quantitaAlcool * $COST_BIRRA;
                    $abuso = true;
                }                                   
            } else if ($tipoAlcol == "Superalcolico"){
                $maxTipoAlcol = $unita * $COST_SUPERALCOLICO;
                if (($quantitaAlcool * $COST_SUPERALCOLICO) > $maxTipoAlcol) {
                    $quantitàAssunta = $quantitaAlcool * $COST_SUPERALCOLICO;
                    $abuso = true;
                }
            }

            if ( $abuso = true){
                $coefficente = calcoloPuntAbuso($maxTipoAlcol, 35, $durataAlcool, $quantitàAssunta);
                    if ($coefficente > 2){
                $coefficente = 2;
                    }
            }
        }
    return $coefficente;
    }


    function calcoloPuntAbusoDroga($droga, $durataDroga, $quantitaDroga, $tipoDroga){
        $coefficente = 0;
        $COST_COCAINA = 100;
        $COST_ANFETAMINA = 50;
        $COST_LSD = 0.25;
        $COST_CANNABINOIDI = 4000;
        $COST_METADONE = 15;
        $COST_MDMA = 1.5;
        if (isset($droga) && isset($quantitaDroga) && isset($tipoDroga)){
            if ($tipoDroga == "Cocaina"){
                $abuso = $COST_COCAINA;

            } else if ($tipoDroga == "Anfetamina"){
                $abuso = $COST_ANFETAMINA;

            } else if ($tipoDroga == "LSD"){
                $abuso = $COST_LSD;

            } else if ($tipoDroga == "Cannabinoidi"){
                $abuso = $COST_CANNABINOIDI;

            } else if ($tipoDroga == "Metadone"){
                $abuso = $COST_METADONE;

            } else if ($tipoDroga == "MDMA"){
                $abuso = $COST_MDMA;

            }

            $coefficente = calcoloPuntAbuso($abuso, 20, $durataDroga, $quantitaDroga);

            if ($coefficente > 2){
                $coefficente = 2;
            }

        }
        return $coefficente;
    }

    function calcoloPuntVitaSedentaria($attivitaFisica){
        if ($attivitaFisica == "sedentario (distanza percorsa giornalmente a piedi inferiore a un km)"){
            $punteggio = 1;
            }else{
                $punteggio = 0;
            }   
            return $punteggio;
    }

    function calcoloPuntAttivitaFisica($attivitaFisica){
            if ($attivitaFisica == "moderata (attivita' giornaliera superiore a un km, ma inferiore a mezzora di camminata veloce)"){
            $punteggio = 1.25;
            }else if ($attivitaFisica == "adeguata (equivalente o superiore a mezzora di camminata veloce)"){
            $punteggio = 1.50;
            }else if ($attivitaFisica == "sportiva (tre-sei ore di allenamento settimanali)"){
            $punteggio = 1.75;
            }else if ($attivitaFisica == "intensa (oltre sei ore di allenamento settimanali)"){
            $punteggio = 2;
            }else{
                $punteggio = 0;
            }

            return $punteggio;
        }

    /*
    * Fuznione che verifica se il paziente abusa di caffeina
    */
    function calcoloPuntAbusoCaffeina($caffeina, $quantitaCaffeina){
        $punteggio = 0;
        if(isset($caffeina) && isset($quantitaCaffeina)){
            $caffeina = $quantitaCaffeina * 85;
                if($caffeina>=300){
                    $punteggio = 1;
                }else{
                    $punteggio = 0;
                }
        }
        return $punteggio;
    }


    /*
    * Funzione che ritorna -1 se sottopeso, 0 se normale e 1 se sovrappeso
    */
    function calcoloPuntBmi ($peso, $altezza){
        $valore=0;
        if((($peso!=0) && (is_numeric($peso)))&&(($altezza!=0) && (is_numeric($altezza)))){
            $descr;
            $bmi = ($peso/(($altezza)*($altezza)));

            if ($bmi < 16.5){
                $descr = "Sottopeso di grado severo";
                $valore = 0;
            }else if ($bmi >= 16.5 && $bmi <= 18.4){
                $descr = "Sottopeso";
                $valore = 0;
            }else if ($bmi >= 18.5 && $bmi <= 24.9){
                $descr = "Normale";
                $valore = 0;
            }else if ($bmi >= 25 && $bmi <= 30){
                $descr = "Sovrappeso";
                $valore = 1;
            }else if ($bmi >= 30.1 && $bmi <= 34.9){
                $descr = "Obesita' di primo grado";
                $valore = 1.33;
            }else if ($bmi >= 35 && $bmi <= 40){
                $descr = "Obesita' di secondo grado";
                $valore = 1.66;
            }else{
                $descr = "Obesita' di terzo grado";
                $valore = 2;
            }
        }
        
    return $valore;
    }


    /*
    * Funzione che verifica se il paziente è ancora in gravidanza.
    */
    function calcoloPuntGravidanza($gravidanzaEta,$id_paziente){
        $element = array();
        if(!empty($gravidanzaEta)){
            $element = $gravidanzaEta[0];
            $size_gravidanzaEta = count($gravidanzaEta);
            for($i=0; $i<$size_gravidanzaEta; $i++){
                $element = max($gravidanzaEta[$i],$element);
            }

            $fine = Gravidanza::where('id_paziente', $userid)->first()->fine_gravidanza;

            if(!isset($fine)){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }


    /*
    * Funzione che verifica se il paziente è stressato.
    */
    function calcoloPuntStress($stress){
        if($stress=="si"){
            return 1;
        }else{
            return 0;
        }
    }
}

