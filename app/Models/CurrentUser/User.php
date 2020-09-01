<?php

namespace App\Models\CurrentUser;

use App\Models\File;
use App\Traits\Encryptable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Patient\Pazienti;
use App\Models\UtentiTipologie;
use App\Models\Domicile\Comuni;
use App\Models\Patient\StatiMatrimoniali;
use App\Models\Patient\PazientiVisite;
use App\Models\Patient\ParametriVitali;
use App\Models\Diagnosis\Diagnosi;
use App\Models\CareProviders\CppDiagnosi;
use App\Models\CareProviders\CppPaziente;
use App\Models\CareProviders\CppPersona;
use App\Models\CareProviders\CareProvider;
use App\Models\Diagnosis\DiagnosiEliminate;
use App\Models\InvestigationCenter\Indagini;
use App\Models\InvestigationCenter\CentriIndagini;
use App\Models\InvestigationCenter\CentriContatti;
use App\Models\Emergency\Emergency;
use App\Models\Vaccine\Vaccinazione;
use App\Models\Drugs\Terapie;

use DB;
use Auth;

use Session;

class User extends Authenticatable {
	use Notifiable;
	use Encryptable;
	protected $table = 'tbl_utenti';
	protected $primaryKey = 'id_utente';
	public $timestamps = false;
	const PATIENT_ID = "ass";
	const PATIENT_DESCRIPTION = "Assistito";
	const CAREPROVIDER_ID = "cpp";
	const AMMINISTRATORI_ID = "amm";
	const EMERGENCY_ID = "118";
	protected $casts = [
			'utente_tipologia' => 'int',
			'utente_stato' => 'int'
	];
	protected $dates = [
			'utente_scadenza'
	];
	protected $hidden = [
			'utente_password'
	];
	protected $encryptable = [
			'utente_nome',
			'utente_email'
	];
	protected $fillable = [

			'id_tipologia',
			'utente_nome',
			'utente_password',
			'utente_stato',
			'utente_scadenza',
			'utente_email'

	];

	/**
	 * Identifica l'oggetto che definisce l'account dell'utente loggato.
	 * Es. Paziente, CareProvider, etc...
	 */
	private $_user_concrete_account = null;

	/**
	 * Recupera i dati dell'utente loggato nel caso sia un paziente.
	 */
	public function data_patient() {
		return $this->patient;
}


	public function dataCareProvider() {
	    return $this->care_providers;
    }

	/*
	 * Restituisce il ruolo dell'utente loggato.
	 */
	public function getRole() {
		return $this->user_type->tipologia_nome;
	}

	/*
	 * Restituisce la descrizione del ruolo dell'utente loggato.
	 */
	public function getDescription() {
		return $this->user_type->tipologia_descrizione;
	}

	/**
	 * Al momento ho voluto disattivare la funzionalit� per ricordare l'accesso via token.
	 * Attualmente si memorizza il token in una colonna, soluzione che rischia di avere
	 * tanti valori NULL su molti utenti che NON desiderano memorizzare il proprio login.
	 * E' necessario informarsi meglio per capire se via DB � l'unico modo "(sicuro)" di
	 * consentire questa funzionalit�.
	 * Rimuovere questa funzione per riattivare il RememberMe. Ci sar� un errore di DB
	 * in fase di logout.
	 */
	public function setAttribute($key, $value) {
		$isRememberTokenAttribute = $key == $this->getRememberTokenName ();
		if (! $isRememberTokenAttribute) {
			parent::setAttribute ( $key, $value );
		}
	}
	public function getEmailForPasswordReset() {
		return $this->utente_email;
	}

	/**
	 * Ritorna il nome dell'utente loggato
	 */
	public function getName() {
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				return $this->data_patient ()->first ()->paziente_nome;
			case $this::CAREPROVIDER_ID :
				return $this->care_providers ()->first ()->cpp_nome;
			case $this::AMMINISTRATORI_ID :
				return $this->administrator ()->first ()->getName ();
			case $this::EMERGENCY_ID :
				return $this->emergencys ()->first ()->emer_nome;
			default :
				break;
		}
	}

	/**
	 * Ritorna il cognome dell'utente loggato
	 */
	public function getSurname() {
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				return $this->data_patient ()->first ()->paziente_cognome;
			case $this::CAREPROVIDER_ID :
				return $this->care_providers ()->first ()->cpp_cognome;
			case $this::AMMINISTRATORI_ID :
				return $this->administrator ()->first ()->getSurname ();
			case $this::EMERGENCY_ID :
				return $this->emergencys ()->first ()->emer_cognome;
			default :
				break;
		}
	}

	/**
	 * Ritorna il codice fiscale dell'utente loggato
	 */
	public function getFiscalCode() {
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				return $this->data_patient ()->first ()->paziente_codfiscale;
			case $this::CAREPROVIDER_ID :
				return $this->care_providers ()->first ()->cpp_codfiscale;
			case $this::EMERGENCY_ID :
				return $this->emergencys ()->first ()->emer_codfiscale;
			default :
				return "Non disponibile";
		}
	}

	/**
	 * Ritorna la data di nascita dell'utente loggato
	 */
	public function getBirthdayDate() {
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				return $this->data_patient ()->first ()->paziente_nascita;
			case $this::CAREPROVIDER_ID :
				return $this->care_providers ()->first ()->cpp_nascita_data;
			case $this::AMMINISTRATORI_ID :
				return $this->administrator ()->first ()->getDataN ();
			case $this::EMERGENCY_ID :
				return $this->emergencys ()->first ()->emer_nascita_data;

			default :
				break;
		}
	}

	/**
	 * Ritorna l'et� dell'utente loggato calcolandola dall'anno attuale e dalla data di nascita
	 */
	public function getAge($date) {
		$age = Carbon::parse ( $date );
		return $age->diffInYears ( Carbon::now () );
	}

	/**
	 * Ritorna il numero di telefono dell'utente loggato
	 */
	public function getTelephone() {
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				return isset ( $this->contacts ()->first ()->contatto_telefono ) ? $this->contacts ()->first ()->contatto_telefono : 'Non pervenuto';
			case $this::CAREPROVIDER_ID :
				return isset ( $this->contacts ()->first ()->contatto_telefono ) ? $this->contacts ()->first ()->contatto_telefono : 'Non pervenuto';
			case $this::AMMINISTRATORI_ID :
				return isset ( $this->contacts ()->first ()->contatto_telefono ) ? $this->contacts ()->first ()->contatto_telefono : 'Non pervenuto';
			case $this::EMERGENCY_ID :
				return isset ( $this->contacts ()->first ()->contatto_telefono ) ? $this->contacts ()->first ()->contatto_telefono : 'Non pervenuto';

			default :
				break;
		}
	}

	/**
	 * Ritorna la mail dell'utente loggato
	 */
	public function getEmail() {
		return $this->utente_email;
	}

	/**
	 * Ritorna il sesso dell'utente loggato
	 */
	public function getGender() {
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				return $this->data_patient ()->first ()->paziente_sesso;
			case $this::CAREPROVIDER_ID :
				return $this->care_providers ()->first ()->cpp_sesso;
			case $this::AMMINISTRATORI_ID :
				return $this->administrator ()->first ()->getSesso ();
			case $this::EMERGENCY_ID :
				return $this->emergencys ()->first ()->emer_sesso;
			default :
				break;
		}
	}

	/**
	 * Ritorna la citt� di nascita dell'utente loggato
	 */
	public function getBirthTown() {
		$result = $this->contacts ()->first ()->id_comune_nascita;
		return Comuni::find ( $result )->comune_nominativo;
	}

	/**
	 * Ritorna la citt� dove risiede l'utente loggato
	 */
	public function getLivingTown() {
		$result = $this->contacts ()->first ()->id_comune_residenza;
		return Comuni::find ( $result )->comune_nominativo;
	}
	public function getCapLivingTown() {
		$result = $this->contacts ()->first ()->id_comune_residenza;
		return Comuni::find ( $result )->comune_cap;
	}
	/**
	 * Gestisce la relazione con il model del emergency nel caso in cui l'utente loggato
	 * sia un emergency.
	 */
	public function emergencys() {
		return $this->hasMany ( \App\Models\Emergency\Emergency::class, 'id_utente' );
	}
	/**
	 * Ritorna l'indirizzo dove risiede l'utente loggato
	 */
	public function getAddress() {
		return $this->contacts ()->first ()->contatto_indirizzo;
	}

	/**
	 * Ritorna lo stato matrimoniale dell'utente loggato
	 */
	public function getMaritalStatus() {
		switch ($this->id_tipologia) {
			case $this::PATIENT_ID :
				return StatiMatrimoniali::where ( 'id_stato_matrimoniale', $this->patient ()->first ()->id_stato_matrimoniale )->first ()->stato_matrimoniale_nome;
			default :
				return 'Undefined';
		}
	}

	/**
	 * Ritorna il gruppo sanguigno e il tipo di rh dell'utente loggato
	 */
	public function getFullBloodType() {
		return $this->data_patient ()->first ()->paziente_gruppo." ".$this->data_patient()->first()->pazinte_rh;
	}

	/**
	 * Associa il valore numerico registrato nel db per i gruppi sanguigni
	 * al valore nominale.
	 */
	private function getBloodGroup($group) {
		switch ($group) {
			case '0' :
				return '0';
				break;
			case '1' :
				return 'A';
				break;
			case '2' :
				return 'B';
				break;
			case '3' :
				return 'AB';
				break;
			default :
				return 'Undefined';
				break;
		}
	}

	/**
	 * Ritorna true se l'utente loggato acconsente alla donazione organi, false altrimenti
	 */
	public function getOrgansDonor() {
		switch ($this->id_tipologia){
			case ($this::PATIENT_ID):
			if($this->data_patient()->first()->paziente_donatore_organi == 0){
				return "Non acconsento";
			}
			else if($this->data_patient()->first()->paziente_donatore_organi == 1){
				return "Acconsento";
			}
		}	
		return 'Non Definito';
	}

	/**
	 * Gestisce la relazione con il model delle tipologie di utente (paziente, care provider, etc...)
	 */
	public function user_type() {
		return $this->belongsTo ( \App\Models\UtentiTipologie::class, 'id_tipologia' );
	}

	/**
	 * Gestisce la relazione con il model dei log per la registrazione delle operazioni effettuate
	 * sulla piattaforma.
	 */
	public function auditlog_logs() {
		return $this->hasMany ( \App\Models\Log\AuditlogLog::class, 'id_visitato' );
	}

	/**
	 * Gestisce la relazione con l'Amministratore nel caso lo fosse
	 *
	 * @return unknown
	 */
	public function administrator() {
		return $this->hasOne ( \App\Amministration::class, 'id_utente' );
	}

	/**
	 * Gestisce la relazione con il model dei care provider nel caso in cui l'utente loggato
	 * sia un care provider.
	 */
	public function care_providers() {
		return $this->hasMany ( \App\Models\CareProviders\CareProvider::class, 'id_utente' );
	}

	/**
	 * Gestisce la relazione con il model dei care provider nel caso in cui l'utente loggato
	 * sia un care provider.
	 */
	public function cpp_persona() {
		return $this->hasMany ( \App\Models\CareProviders\CppPersona::class, 'id_utente' );
	}

	/**
	 * Gestisce la relazione con il model dei pazienti nel caso in cui l'utente loggato
	 * sia un paziente.
	 */
	public function patient() {
		return $this->hasMany ( \App\Models\Patient\Pazienti::class, 'id_utente' );
	}

	/**
	 * Gestisce la relazione con il model PazientiFamiliarita per la gestione delle
	 * relazioni familiari dei pazienti.
	 */
	public function pazienti_familiarita() {
		return $this->hasMany ( \App\Models\Patient\PazientiFamiliarita::class, 'id_parente' );
	}

	/**
	 * Gestisce la relazione con il model Recapiti per il recupero dei contatti, come telefono
	 * o indirizzo, forniti dall'utente loggato.
	 */
	public function contacts() {
		return $this->hasMany ( \App\Models\CurrentUser\Recapiti::class, 'id_utente' );
	}

    /**
     * Gestisce la relazione con il model Terapie per il recupero utente prescrittore.
     */
    public function tbl_terapie() {
        return $this->hasMany(\App\Models\Drugs\Terapie::class, 'id_prescrittore', 'id_utente' );
    }




    /**
     * Ritorna un array contenente la località di tutti i car provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function trovaLocalita() {
        $array = array ();
        $array = CareProvider::all ();

        $r = array ();
        foreach ( $array as $a ) {
            array_push ( $r, $a->cpp_localita_iscrizione );
        }
        return $r;
    }

    /**
     * Ritorna un array contenente i nomi di tutti i car provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function trovaNome() {
        $array = array ();
        $array = CareProvider::all ();

        $r = array ();
        foreach ( $array as $a ) {
            array_push ( $r, $a->cpp_nome );
        }
        return $r;
    }

    /**
     * Ritorna un array contenente i cognomi di tutti i car provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function trovaCognome() {
        $array = array ();
        $array = CareProvider::all ();

        $r = array ();
        foreach ( $array as $a ) {
            array_push ( $r, $a->cpp_cognome );
        }
        return $r;
    }

    /**
     * Ritorna un array contenente i numeri di telefono di tutti i car provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function trovaTelefono() {
        $rec = Recapiti::all ();
        $cpp = CareProvider::all ();
        $all = array ();

        foreach ( $cpp as $c ) {
            foreach ( $rec as $r ) {
                if ($c->id_utente == $r->id_utente) {
                    array_push ( $all, $r->contatto_telefono );
                }
            }
        }
        return $all;
    }

    /**
     * Ritorna un array contenente i ruoli di tutti i car provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function trovaRuolo() {
        $ruolo = User::all ();
        $cpp = CareProvider::all ();
        $all = array ();

        foreach ( $cpp as $c ) {
            foreach ( $ruolo as $r ) {
                if ($c->id_utente == $r->id_utente) {
                    array_push ( $all, $r->id_tipologia );
                }
            }
        }
        return $all;
    }

    /**
     * Ritorna un array contenente tutti i car provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function cpp() {
        $array = CareProvider::all ();
        return $array;
    }

    /**
     * Ritorna il numero di care provider inseriti nel Registro Elettronico Sanitario Personale Multimediale
     */
    public function numero() {
        $array = array ();
        $array = CareProvider::all ();
        $i = 0;

        $r = array ();
        foreach ( $array as $a ) {
            $i = $i + 1;
        }
        return $i;
    }

    public function cppAssociati()
    {
        return DB::table('tbl_care_provider')->join('tbl_cpp_paziente', 'tbl_care_provider.id_cpp', '=', 'tbl_cpp_paziente.id_cpp')->where('tbl_cpp_paziente.id_paziente','=',$this->id_utente)->get();
    }

    /**
     * Ritorna un array contenente tutti i nomi dei car provider associati all'utente loggato
     */
    public function nomeCppAssociato() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $all = array ();
        $info = array ();

        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    array_push ( $info, $c->cpp_nome );
                }
            }
        }

        return $info;
    }

    /**
     * Ritorna un array contenente tutti i cognomi dei car provider associati all'utente loggato
     */
    public function cognomeCppAssociato() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $all = array ();
        $info = array ();

        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    array_push ( $info, $c->cpp_cognome );
                }
            }
        }

        return $info;
    }

    /**
     * Ritorna un array contenente tutti i ruoli dei car provider associati all'utente loggato
     */
    public function ruoloCppAssociato() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $info = array ();
        $ruolo = array ();
        $ruolo = User::all ();
        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    foreach ( $ruolo as $ruol ) {
                        if ($c->id_utente == $ruol->id_utente) {
                            array_push ( $info, $ruol->id_tipologia );
                        }
                    }
                }
            }
        }
        return $info;
    }

    /**
     * Ritorna un array contenente tutti i numeri di telofono dei car provider associati all'utente loggato
     */
    public function telefonoCppAssociato() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $info = array ();
        $rec = array ();

        $rec = Recapiti::all ();

        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    foreach ( $rec as $re ) {
                        if ($c->id_utente == $re->id_utente) {
                            array_push ( $info, $re->contatto_telefono );
                        }
                    }
                }
            }
        }
        return $info;
    }

    /**
     * Ritorna un array contenente tutte le città dei car provider associati all'utente loggato
     */
    public function cittaCppAssociato() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $info = array ();

        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    array_push ( $info, $c->cpp_localita_iscrizione );
                }
            }
        }
        return $info;
    }

    /**
     * Ritorna il numero dei car provider associati all'utente loggato
     */
    public function trovaCppAssociati() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $i = 0;

        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    $i = $i + 1;
                }
            }
        }
        return $i;
    }

    /**
     * Ritorna un array contenente tutti gli id_cpp dei car provider associati all'utente loggato
     */
    public function idCppAssociato($tel) {
        $arrayRecapiti = array ();
        $arrayRecapiti = Recapiti::all ();
        $id_utente = 0;
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $id_cpp = 0;

        foreach ( $arrayRecapiti as $pers ) {
            if ($pers->contatto_telefono == $tel) {
                $id_utente = $pers->id_utente;
            }
        }

        foreach ( $arrayCpp as $cpp ) {
            if ($cpp->id_utente == $id_utente) {
                $id_cpp = $cpp->id_cpp;
            }
        }

        return $id_cpp;
    }

    /**
     * Ritorna la confidenzialità tra il paziente e il Care Provider passati in ingresso alla funzione
     */
    public function confidenzialitaCppAssociato($id_utente, $id_cpp) {
        $arrayCppPaziente = array ();
        $arrayCppPaziente = CppPaziente::all ();
        $arrayPazienti = array ();
        $arrayPazienti = Pazienti::all ();
        $id = 0;
        $conf = 0;

        foreach ( $arrayPazienti as $p ) {
            if ($p->id_paziente == $id_utente) {
                $id = $p->id_paziente;
            }
        }
        foreach ( $arrayCppPaziente as $a ) {
            if (($a->id_cpp == $id_cpp) && ($a->id_paziente == $id)) {
                $conf = $a->assegnazione_confidenzialita;
            }
        }
        return $conf;
    }

    /**
     * Ritorna la mail di un Care Provider passato come parametro della funzione
     */
    public function trovaMail($id_cpp) {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayUser = array ();
        $arrayUser = User::all ();
        $mail = '';
        $id = 0;

        foreach ( $arrayCpp as $cpp ) {
            if ($cpp->id_cpp == $id_cpp) {
                $id = $cpp->id_utente;

                foreach ( $arrayUser as $user ) {
                    if ($user->id_utente == $id) {
                        $mail = $user->utente_email;
                    }
                }
            }
        }

        return $mail;
    }

    /**
     * Ritorna le "Altre informazioni" di tutti i Care Provider associati all'utente
     */
    public function informazioniCppAssociato() {
        $arrayCpp = array ();
        $arrayCpp = CareProvider::all ();
        $arrayPazienti = array ();
        $arrayPazienti = CppPaziente::all ();
        $info = array ();
        $arrayPersona = array ();
        $arrayPersona = CppPersona::all ();

        foreach ( $arrayCpp as $c ) {
            foreach ( $arrayPazienti as $r ) {
                if (($c->id_cpp == $r->id_cpp) && ($this->patient->first ()->id_paziente == $r->id_paziente)) {
                    foreach ( $arrayPersona as $arr ) {
                        if ($c->id_utente = $arr->id_utente) {
                            if ($arr->persona_reperibilita != " ") {
                                array_push ( $info, $arr->persona_reperibilita );
                            } else {
                                array_push ( $info, "--" );
                            }
                        }
                    }
                }
            }
        }
        return $info;
    }

    /**
     * Ritorna le "Altre informazioni" di tutti i Care Provider
     */
    public function trovaInformazioni() {
        $persona = CppPersona::all ();
        $cpp = CareProvider::all ();
        $all = array ();
        $i=0;

        foreach ( $cpp as $c ) {
            foreach ( $persona as $r ) {
                if ($c->id_utente == $r->id_utente) {
                    if ($r->persona_reperibilita != " ") {
                        array_push ( $all, $r->persona_reperibilita );
                    } else {
                        array_push ( $all, "--" );
                    }
                }
            }
        }
        return $all;
    }

    /**
	 * Ritorna un array con tutte le visite effettuate dall'utente loggato
	 */
	public function visiteUser() {
		$array = array ();
		$lista = PazientiVisite::orderBy ( 'visita_data', 'desc' )->get ();
		;
		switch ($this->getRole ()) {
			case $this::PATIENT_ID :
				foreach ( $lista as $la ) {
					if ($la->id_paziente == $this->data_patient ()->first ()->id_paziente) {
						array_push ( $array, $la );
					}
				}
				return $array;

			case $this::CAREPROVIDER_ID :
				foreach ( $lista as $la ) {
					if ($la->id_cpp == $this->care_providers ()->first ()->id_cpp) {
						array_push ( $array, $la );
					}
				}
				return $array;

			default :
				break;
		}
	}

	/**
	 * Restituisce un array multidimensionale in cui le chiavi sono le date delle visite e i valori sono
	 * i parametri vitali
	 */
	public function paramVitaliToDate() {
		$visite = $this->visiteUser ();
		$array = array ();
		$param = ParametriVitali::all ();
		$data = '';
		foreach ( $visite as $v ) {
			foreach ( $param as $p ) {
				if (($v->id_paziente == $p->id_paziente) && ($v->id_visita == $p->id_parametro_vitale)) {
					$data = date ( 'd/m/y', strtotime ( $v->visita_data ) );
					$array ["$data"] = $p;
				}
			}
		}
		return $array;
	}

	/**
	 * Restituisce un array con le data delle visite
	 */
	public function dateVisite() {
		$date = array_keys ( $this->paramVitaliToDate () );
		return $date;
	}

	/**
	 * restituisce un array con tutte le diagnosi del'utente loggato
	 */
	public function diagnosi() {
        return Diagnosi::where('id_paziente', "=", $this->id_utente)->where('diagnosi_stato', '!=', '3')->get();
	}

	/**
     * restituisce un array con tutte le diagnosi del'utente loggato
     */
    public function terapie() {
        return Terapie::where('id_paziente', "=", $this->id_utente)->where('diagnosi_stato', '!=', '3')->get();
    }

	/**
	 * restituisce i cpp che ha contribuito alla diagnosi
	 */
	public function getCppDiagnosi($idDiagnosi) {
		$arrayCppDiagnosi = array ();
		$arrayCppDiagnosi = CppDiagnosi::all ();
		$cpp = 0;

		foreach ( $arrayCppDiagnosi as $c ) {
			if ($c->id_diagnosi == $idDiagnosi) {
				$cpp = $c;
			}
		}

		return $cpp;
	}

	/**
	 * restituisce l'ultimo cpp che contribuito ad una data diagnosi
	 */
	public function lastCppDiagnosi($idDiagnosi) {
		$cpp = ($this->getCppDiagnosi ( $idDiagnosi ))->careprovider;
		$cpp = explode ( "-", $cpp );

		$ret = '';

		foreach ( $cpp as $c ) {
			$ret = $c;
		}

		$ret = explode ( "/", $ret );

		return $ret [0];
	}

	/**
	 * restituisce l'id_paziente dell'utente loggato
	 */
	public function idPazienteUser() {
		$arrayPazienti = array ();
		$arrayPazienti = Pazienti::all ();
		$idPaziente = 0;
		$diagnosi = array ();
		$diagnosi = Diagnosi::all ();

		foreach ( $arrayPazienti as $paz ) {
			if ($paz->id_utente == $this->id_utente) {
				$idPaziente = $paz->id_paziente;
			}
		}

		return $idPaziente;
	}

	/**
	 * restituisce un array con tutte le indagini del'utente loggato
	 */
	public function indagini() {
		$arrayPazienti = Pazienti::all ();
		$idPaziente = 0;
		$indagini = Indagini::all ();

		$ret = array ();

		foreach ( $arrayPazienti as $paz ) {
			if ($paz->id_utente == $this->id_utente) {
				$idPaziente = $paz->id_paziente;
			}
		}

		foreach ( $indagini as $i ) {
			if ($idPaziente == $i->id_paziente) {
				array_push ( $ret, $i );
			}
		}

		return $ret;
	}

	/**
	 * restituisce nome e cognome dei cpp che hanno contribuito ad una diagnosi in una indagine
	 */
	public function cppIndagine($idDiagnosi) {
		$diagnosi = array ();
		$diagnosi = CppDiagnosi::all ();
		$cpp = '';

		foreach ( $diagnosi as $d ) {
			if ($idDiagnosi == $d->id_diagnosi) {
				$cpp = $d->careprovider;
			}
		}
		return $cpp;
	}

	/**
	 * restituisce il nome del centro dove avr� luogo l'indagine
	 */
	public function nomeCentroInd($idCentroInd) {
		$centri = array ();
		$centri = CentriIndagini::all ();
		$ret = '';

		foreach ( $centri as $c ) {
			if ($idCentroInd == $c->id_centro) {
				$ret = $c->centro_nome;
			}
		}

		return $ret;
	}

	/**
	 * restituisce un array con tutti i centri indagini
	 */
	public function centriIndagini() {
		$centri = array ();
		$centri = CentriIndagini::all ();

		return $centri;
	}

	/**
	 * torna il contatto del centro
	 */
	public function contattoCentro($idCentro) {
		$centriCont = array ();
		$centriCont = CentriContatti::all ();
		$ret = array ();

		foreach ( $centriCont as $c ) {
			if ($c->id_centro == $idCentro) {
				array_push ( $ret, $c->contatto_valore );
			}
		}

		return $ret;
	}

	/**
	 * restituisce nome e cognome dei cpp di un dato centro indagini
	 */
	public function cppPersCont($idCentro) {
		$centri = array ();
		$centri = CentriIndagini::all ();
		$a = 0;
		$cpp = array ();
		$cpp = CareProvider::all ();
		$ret = '';

		foreach ( $centri as $c ) {
			if ($c->id_centro == $idCentro) {
				$a = $c->id_ccp_persona;
			}
		}

		foreach ( $cpp as $c ) {
			if ($a == $c->id_cpp) {
				$ret = $c->cpp_nome . ' ' . $c->cpp_cognome;
			}
		}

		return $ret;
	}


	/**
	 * restituisce nome, cognome e id del cpp che ha contribuito ad una data indagine
	 */
	public function cppInd($idDiagnosi) {
		$indagini = Indagini::all ();
		$ret = array ();

		foreach ( $indagini as $ind ) {
			if ($ind->id_diagnosi == $idDiagnosi) {
				$ret = $ind->careprovider . "-" . $ind->id_cpp;
			}
		}

		return $ret;
	}

    /**
     * restituisce un array con tutte le vaccinazioni del'utente loggato
     */
    public function vaccinazioni(){
        $arrayPazienti = array();
        $arrayPazienti = Pazienti::all();
        $idPaziente;
        $vaccinazioni = array();
        $vaccinazioni = Vaccinazione::all();


        $ret = array();

        foreach ($arrayPazienti as $paz) {
            if ($paz->id_utente == $this->id_utente) {
                $idPaziente = $paz->id_paziente;
            }
        }

        foreach ($vaccinazioni as $v) {
            if ($idPaziente == $v->id_paziente) {
                array_push($ret, $v);
            }
        }

        return $ret;
    }

    /*private function files(){
        return File::where('id_paziente', "=", $this->id_utente)->get();
    }

    public function filesNotUsed()
    {
        $allFiles = $this->files();
        $usedFiles = $this->filesUsed();
        $notUsedFiles = array();

        for($i=0;$i<sizeof($allFiles); $i++)
        {
            $found = false;
            $j=0;
            while($j<sizeof($usedFiles) && !$found)
            {
                if($allFiles[$i]->id_file == $usedFiles[$j]->id_file) $found=true;
                $j++;
            }
            if(!$found) array_push($notUsedFiles, $allFiles[$i]);
        }

        return $notUsedFiles;
    }

    public function filesUsed()
    {
        $referti = DB::table('tbl_files')->join('tbl_indagini', 'indagine_referto', '=', 'id_file')->where('tbl_indagini.id_paziente', '=', $this->id_utente)->where('tbl_indagini.indagine_stato', '!=', '3')->get();
        $allegati = DB::table('tbl_files')->join('tbl_indagini', 'indagine_allegato', '=', 'id_file')->where('tbl_indagini.id_paziente', '=', $this->id_utente)->where('tbl_indagini.indagine_stato', '!=', '3')->get();

        $merged = array();

        for($i=0; $i<sizeof($merged); $i++)
        {
            $found = false;
            $j=1;
            while($j<$i && !$found)
            {
                if($merged[$i]->id_file == $merged[$j]->id_file)
                {
                    unset($merged[$j]);
                    $merged = array_values($merged);
                    $found = true;
                }
                $j++;
            }
        }

        return array_values($merged);
    }*/

	/**
	 * Inizio metodi per la gestione dell'impersonificazione
	 */
	public function setImpersonating($id) {
        Session::put('impersonate', (int)$id);
        Session::put('beforeImpersonate', Auth::user()->id_utente);
    }

    public function stopImpersonating() {
        Session::forget('impersonate');
        Session::forget('beforeImpersonate');
    }

    public function isImpersonating() {
        return Session::has('impersonate');
    }
}
