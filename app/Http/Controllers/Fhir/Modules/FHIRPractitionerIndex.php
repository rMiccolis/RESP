<?php
namespace App\Http\Controllers\Fhir\Modules;


use App\Models\CareProviders\CareProvider;

/**
 * Classe per la gestione della pagina FHIR sul lato care provider
 */
class FHIRPractitionerIndex
{

    /**
     * Funzione per il reindirizzamento alla sezione Practitioner
     */
    function Index($id)
    {
        $pratictioner = CareProvider::where('id_cpp', $id)->first();

        return view("pages.fhir.Practitioner.indexPractitionerHome", [
            "data_output" => $pratictioner
        ]);
    }

}