<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\InvestigationCenter;

use App\Models\CodificheFHIR\ObservationStatus;
use App\Models\CodificheFHIR\ObservationCode;
use App\Models\CodificheFHIR\ObservationCategory;
use App\Models\CodificheFHIR\ObservationInterpretation;
use App\Models\Patient\Pazienti;
use App\Models\CareProviders\CareProvider;
use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;
use DateTime;
use Carbon\Carbon;
use Date;

/**
 * Class Indagini
 *
 * @property int $id_indagine
 * @property int $id_centro_indagine
 * @property int $id_paziente
 * @property \Carbon\Carbon $indagine_data
 * @property \Carbon\Carbon $indagine_aggiornamento
 * @property string $indagine_stato
 * @property string $indagine_tipologia
 * @property string $indagine_motivo
 * @property string $indagine_referto
 * @property string $indagine_allegato
 * @property int $id_cpp
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\CentriIndagini $tbl_centri_indagini
 * @property \App\Models\Diagnosi $tbl_diagnosi
 * @property \App\Models\Icd9EsamiStrumentiCodici $tbl_icd9_esami_strumenti_codici
 * @property \App\Models\Loinc $tbl_loinc
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class Indagini extends Eloquent {
	
	use Encryptable;
	protected $table = 'tbl_indagini';
	protected $primaryKey = 'id_indagine';
	public $incrementing = false;
	public $timestamps = false;
	protected $casts = [ 
			'id_indagine' => 'int',
			'id_centro_indagine' => 'int',
			'id_paziente' => 'int',
			'id_cpp' => 'int',
            'indagine_referto' => 'int'
	];
	protected $dates = [ 
			'indagine_data',
			'indagine_data_fine',
			'indagine_aggiornamento',
			'indagine_issued' 
	
	];
	protected $encryptable = [ ];
	protected $fillable = [ 
			'id_centro_indagine',
			'id_paziente',
			'id_cpp',
			'careprovider',
			'indagine_data',
			'indagine_data_fine',
			'indagine_aggiornamento',
			'indagine_code',
			'indagine_interpretation',
			'indagine_category',
			'indagine_stato',
			'indagine_issued',
			'indagine_tipologia',
			'indagine_motivo',
			'indagine_referto',
			'codice_ICD',
			'codice_LOINC'	
	];

	public function tbl_centri_indagini() {
		return $this->belongsTo ( \App\Models\InvestigationCenter\CentriIndagini::class, 'id_centro_indagine' );
	}
	public function tbl_diagnosi() {
        return $this->belongsToMany ( 'App\Models\Diagnosis\Diagnosi', 'indagine_diagnosi', 'id_indagine', 'id_diagnosi');
	}
	public function tbl_pazienti() {
		return $this->belongsTo ( \App\Models\Patient\Pazienti::class, 'id_paziente' );
	}
	public function tbl_care_provider() {
		return $this->belongsTo ( App\Models\CareProviders\CareProvider::class, 'id_cpp' );
	}
	public function getReason() {
		return $this->indagine_motivo;
	}
	public function getType() {
		return $this->indagine_tipologia;
	}
	public function getId() {
		return $this->id_indagine;
	}
	public function getIdPaziente() {
		return $this->id_paziente;
	}
	public function getPaziente() {
		$paz = Pazienti::where ( 'id_paziente', $this->id_paziente )->first ();
		return $paz->getFullName ();
	}
	public function getIdCpp() {
		return $this->id_cpp;
	}
	public function getCpp() {
		$cpp = CareProvider::where ( 'id_cpp', $this->id_cpp )->first ();
		return $cpp->getFullName ();
	}
	public function getDataFine() {
		$data = date_format ( $this->indagine_data_fine, "Y-m-d" );
		return $data;
	}
	public function getIssued() {
		$t = $this->indagine_issued;
		date_default_timezone_set ( "Europe/Rome" );
		
		$date = date ( DATE_ATOM, mktime ( date ( "H", strtotime ( $t ) ), date ( "m", strtotime ( $t ) ), date ( "s", strtotime ( $t ) ), date ( "m", strtotime ( $t ) ), date ( "d", strtotime ( $t ) ), date ( "Y", strtotime ( $t ) ) ) );
		return $date;
		// return date(DATE_ATOM, mktime($date));
	}
	public function getCode() {
		return $this->indagine_code;
	}
	public function getCodeDisplay() {
		$dis = ObservationCode::where ( 'Code', $this->indagine_code )->first ();
		return $dis->Display;
	}
	public function getStatus() {
		return $this->indagine_stato;
	}
	public function getStatusDisplay() {
		$dis = ObservationStatus::where ( 'Code', $this->indagine_stato )->first ();
		return $dis->Display;
	}
	public function getCategory() {
		return $this->indagine_category;
	}
	public function getCategoryDisplay() {
		$dis = ObservationCategory::where ( 'Code', $this->indagine_category )->first ();
		return $dis->Display;
	}
	public function getInterpretation() {
		return $this->indagine_interpretation;
	}
	public function getInterpretationDisplay() {
		$dis = ObservationInterpretation::where ( 'Code', $this->indagine_interpretation )->first ();
		return $dis->Display;
	}

    public function getFile($id_file)
    {
        return \App\Models\File::where('id_file',$id_file)->first();
    }

    public function getAllegati()
    {
        return AllegatiIndagini::where('id_indagine', $this->id_indagine)->get();
    }
}
