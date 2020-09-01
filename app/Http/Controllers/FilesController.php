<?php

namespace App\Http\Controllers;

use App\Models\Log\AuditlogLog;
use Illuminate\Http\Request;
use App\Models\File;
use Redirect;
use Auth;
use Input;
use Storage;
use ZipArchive;
use App;
use App\Classes\IPFS;

class FilesController extends Controller
{
    /**
    * Carica un file associandolo alla cartella dell'utente loggato
    */
    public function uploadFile(Request $request){
        $file = $request->file('nomefile');

        $ipfs = new IPFS("https://ipfs.infura.io", "8080", "5001");

        $path = Storage::disk('public')->putFileAs("/patient/".Input::get('idPaz'), $file, $file->getClientOriginalName(), 'public');
        $path = storage_path()."/app/public/".$path;

        $hash = $ipfs->add($path);

        Storage::deleteDirectory("/patient/".Input::get('idPaz'));
           
        $file_model = File::create([
            'id_paziente' => Input::get('idPaz'),
            'hash' => $hash,
            'id_audit_log' => Input::get('idLog'),
            'file_nome' => $file->getClientOriginalName(),
            'file_commento' => Input::get('comm'),
        ]);
            
        $file_model->save();
        return Redirect::back();
	}

    /**
     * Carica un file associandolo alla cartella dell'utente loggato
     */
    public function uploadFileFromIndagini(Request $request)
    {
        $file = $request->file('nomefile');

        $path = Storage::disk('public')->putFileAs("/patient/".Input::get('idPaz'), $file, $file->getClientOriginalName(), 'public');
        $path = storage_path()."/app/public/".$path;

        $ipfs = new IPFS("https://ipfs.infura.io", "8080", "5001");
        $hash = $ipfs->add($path);
        Storage::deleteDirectory("/patient/".Input::get('idPaz'));

        if ($request->has('id_visiting')) {
            $id_visiting = request()->input('id_visiting');
        }
        else {
            $id_visiting = Auth::user()->id_utente;
        }

        $log = $this->buildLog('Files', $request->ip(), $id_visiting);

        $file_model = File::create([
            'id_paziente' => Input::get('idPaz'),
            'hash' => $hash,
            'id_audit_log' => $log->id_audit,
            'file_nome' => $file->getClientOriginalName(),
            'file_commento' => Input::get('comm'),
        ]);

        $file_model->save();

        /*Restituisce l'id del file appena caricato. tutte le where inserite consentono di selezionare
        esattamente quel file. Con una query del tipo
        SELECT MAX(id_file)
        FROM tbl_files
        WHERE idPaz = ...
        Si potrebbe ottenere (erroneamente) l'id di un file che per assurdo è stato caricato da
        un altro care provider nello stesso istante.
        Viene aggiunta la funziona max() per evitare ambiguità nel caso in cui ci fossero più file con
        stesso nome e stesso commento.*/
        $nextId = File::where('id_paziente', Input::get('idPaz'))->where('file_nome',$file->getClientOriginalName())->where('file_commento',Input::get('comm'))->max('id_file');

        return response("<p>File salvato con successo<p/><input id='idFileCaricato' name='idFileCaricato' hidden type='text' value='".$nextId."' />");
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
        $log->save();
        return $log;
    }

    /**
    * Cancella un file tra quelli associati ad un paziente
    */
    public function deleteFile(){
        Storage::disk('public')->delete('patient/'.Input::get('id_patient').'/'.Input::get('name'));
        App\Models\InvestigationCenter\AllegatiIndagini::where('id_file', Input::get('id_file'))->delete();
        File::where('id_file', Input::get('id_file'))->first()->delete();
        return Redirect::back();
    }

    /**
    * Aggiorna il livello di confidenzialità associato ad un file
    */
    public function updateFileConfidentiality(){
        $file = File::where('file_nome', Input::get('name'))->where('id_paziente', Input::get('id_patient'))->first();
        $file->id_file_confidenzialita = Input::get('updateConfidentiality');
        $file->save();
        return Redirect::back();
    }
    
    /*
    * Permette il download di un'immagine
    */
    public function downloadImage($photo_id){

        $user       = Auth::user();
        $user_id    = $user->patient()->first()->id_paziente;
        
        //Controllo che sia il proprietario di questa immagine. Download solo per lui
        $is_owner = File::where('id_file', $photo_id)->where('id_paziente', $user_id)->first();
        
        if($is_owner)
        {
            $img_name   = $is_owner->file_nome;
            $ipfs = new IPFS("https://ipfs.infura.io", "8080", "5001");
            $fileContent = $ipfs->cat($is_owner->hash);
            Storage::put($img_name, $fileContent);
            return response()->download(storage_path("app/public/".$img_name))->deleteFileAfterSend(true);
        }
        else
        {
            App::abort(403, 'Access denied ;)');
        }
    }

     /*
    * Permette il download di più files
    */
    public function downloadMultipleFiles($filesId){

        $files = explode("_", $filesId);
        $user       = Auth::user();
        $user_id    = $user->patient()->first()->id_paziente;
        
        $nome_cognome = $user->patient()->first()->paziente_nome."_".$user->patient()->first()->paziente_cognome;

        $zip = new ZipArchive;

        $output = $nome_cognome.".zip";
        

        for ($i = 1; $i < count($files); $i++){

        //Controllo che sia il proprietario di questa immagine. Download solo per lui
        $is_owner = File::where('id_file', $files[$i])->where('id_paziente', $user_id)->first();

        if($is_owner)
        {
            $img_name   = $is_owner->file_nome;
            $ipfs = new IPFS("https://ipfs.infura.io", "8080", "5001");
            $fileContent = $ipfs->cat($is_owner->hash);
            Storage::put($img_name, $fileContent);
            if ($zip->open($output, ZipArchive::CREATE) == TRUE){
                // dd("ciao");
                $zip->addFile(storage_path("app/public/".$img_name), $img_name);
                $zip->close();
            }
            unlink(storage_path("app/public/".$img_name));
            // return response()->download(storage_path("app/public/".$img_name))->deleteFileAfterSend(true);
        }
        else
        {
            App::abort(403, 'Access denied ;)');
        }
    }
    
    
    return response()->download(public_path($output))->deleteFileAfterSend(true);
}



}
