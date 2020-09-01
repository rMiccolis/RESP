<?php
use App\Models\Patient\Pazienti;
use App\Models\Drugs\Terapie;
/*
 |--------------------------------------------------------------------------
 | Web Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register web routes for your application. These
 | routes are loaded by the RouteServiceProvider within a group which
 | contains the "web" middleware group. Now create something great!
 |
 */



/**
 * Route per l'index
 */
Route::get ( '/', function () {
	return view ( 'welcome' );
} );

/**
 * Route per la pagina principale della web application
 */
Route::get ( '/home', 'HomeController@index' )->name ( 'home' );

/**
 * Routes per la registrazione di Pazienti e Care Provider
 */
Route::get ( '/register', function () {
	return view ( 'auth.register' );
} );
Route::get ( '/register/patient', 'Auth\RegisterController@showPatientRegistrationForm' )->name ( 'register_patient' );
Route::post ( '/register/patient', 'Auth\RegisterController@registerPatient' );
Route::get ( '/register/careprovider', 'Auth\RegisterController@showCareProviderRegistrationForm' )->name ( 'register_careprovider' );
Route::post ( '/register/careprovider', 'Auth\RegisterController@registerCareprovider' );



/*
 *
 * Auth::routes(); chiama e istanzia le seguenti funzioni/url
 * $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
 * $this->post('login', 'Auth\LoginController@login');
 * $this->post('logout', 'Auth\LoginController@logout')->name('logout');
 * * Registration Routes...
 * $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
 * $this->post('register', 'Auth\RegisterController@register');
 * * Password Reset Routes...
 * $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
 * $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
 * $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
 * $this->post('password/reset', 'Auth\ResetPasswordController@reset');
 */
Auth::routes ();

/**
 * Route per effettuare l'update della password
 */
Route::post ( '/user/updatepassword', 'UserController@updatePassword' );

/**
 * Route per effettuare l'update del consenso alla donazione organi da parte
 * del paziente.
 */
Route::post ( '/pazienti/updateOrgansDonor', 'PazienteController@updateOrgansDonor' );

/**
 * Route per effettuare l'update del consenso alla donazione organi da parte
 * del paziente.
 */
Route::post ( '/pazienti/updateGrpSanguigno', 'PazienteController@updateGrpSanguigno' );

/**
 * Route per effettuare l'update dell'anagrafica del paziente
 */
Route::post ( '/pazienti/updateAnagraphic', 'PazienteController@updateAnagraphic' );

/**
 * Route per aggiungere un numero telefonico di un conoscente/familiare ad un paziente
 */
Route::post ( '/pazienti/addContact', 'PazienteController@addContact' );

/**
 * Route per aggiungere un numero telefonico di emergenza di un conoscente/familiare ad un paziente
 */
Route::post ( '/pazienti/addEmergencyContact', 'PazienteController@addEmergencyContact' );

/**
 * Route per rimuovere un numero telefonico di un conoscente/familiare ad un paziente
 */
Route::post ( 'pazienti/removeContact', 'PazienteController@removeContact' );

/**
 * Route per l'inserimento di una nuova segnalazione all'interno del taccuino
 */
Route::post ( '/pazienti/taccuino/addReporting', 'TaccuinoController@addReporting' );

/**
 * Route per la rimozione di una segnalazione all'interno del taccuino
 */
Route::post ( '/pazienti/taccuino/removeReporting', 'TaccuinoController@removeReporting' );

/**
 * Route per la gestione dell'invio di mail di suggerimento
 */
Route::get ( '/send-suggestion', 'MailController@sendSuggestion' );

/**
 * Route per l'upload di un file associandolo ad un paziente
 */
Route::post ( '/uploadFile', 'FilesController@uploadFile' );
Route::post ( '/uploadFileFromIndagini', 'FilesController@uploadFileFromIndagini' );

/**
 * Route per la rimozione di un file associato ad un paziente
 */
Route::post ( '/deleteFile', 'FilesController@deleteFile' );

/**
 * Route per il download di un immagine
 */
Route::get ( '/downloadImage/{id_photo}', 'FilesController@downloadImage');

/**
 * Route per il download di più file in formato zip
 */
Route::get ( '/downloadMultipleFiles/{filesID}', 'FilesController@downloadMultipleFiles');

/**
 * Route per l'aggiornamento del livello di confidenzialit�
 * associato ad un file
 */
Route::post ( '/updateFileConfidentiality', 'FilesController@updateFileConfidentiality' );

/**
 * Route per l'inserimento da parte di un careprovider di un nuovo centro.
 */
Route::post ( '/addstructure', 'CareProviderController@addStructure' );

/**
 * Route per l'eliminazione di una terapia
 */
Route::post('/eliminaTerapia','TerapieController@eliminaTerapia');

 /**
 * Route per aggiungere una terapia
 */
Route::get('/aggiungiTerapia','TerapieController@aggiungiTerapia');

 /**
 * Route per modificare una terapia
 */
Route::post('/modificaTerapia','TerapieController@modificaTerapia');

/**
* Route per spostare una terapia in terapie concluse
*/
Route::post('/spostaTerapia','TerapieController@spostaTerapia');

/**
* Route per modificare una terapia per l'edit
*/
Route::get('/terapia/{id}/{tipoTP}','TerapieController@getTerapia');

/**
* Route per cercare una terapia
*/
Route::get('/searchTerapia/{tipo}/{txtSearch}','TerapieController@searchTerapia');


/**
* Route per richiedere info sul farmaco
*/
Route::get('/farmaco/{id}','TerapieController@getFarmaco');

 /*
 * Routes base per le varie pagine e reindirizza gli utenti non loggati alla homepage
 */
Route::group (
    ['middleware' => 'auth'
    ], function ()
    {
        Route::group (
            ['middleware' => ['careprovider']
            ], function ()
            {
                Route::get ( '/patients-list', 'CareProviderController@showPatientsList' )->name ( 'patients-list' );
                Route::get ( '/structures', 'CareProviderController@showStructures' )->name ( 'structures' );
                Route::get ( '/fhirPatient', 'ResourceFHIRController@indexPatient' );
                Route::get ( '/patient-visit/{idToImpersonate}', 'CareProviderController@showPatientVisit' )->name ( 'visite' );
                Route::get ( '/fhirCareProviderIndexHome/{id}', 'Fhir\Modules\FHIRPractitionerIndex@Index');
                Route::group (
                        ['middleware' => ['impersonate']
                        ], function ()
                    {
                        Route::get ( '/patient-home', 'HomeController@index' )->name ( 'patient-home' );
                        Route::get ( '/visits', 'PazienteController@showVisits' )->name ( 'visite' )->middleware('consent:3');
                        Route::get ( '/patient-summary-cp', 'PazienteController@showPatientSummary' )->name ( 'patient-summary-cp' );

                        Route::resource('/anamnesi','AnamnesiController',['except' => ['create', 'show','store', 'destroy']]);
                        Route::post('/anamnesi','AnamnesiController@store');
                        Route::patch('/anamnesi/{id}', 'AnamnesiController@update')->name('Update');
                        Route::delete('/anamnesi/{id}', 'AnamnesiController@delete')->name('Delete');
                        Route::post('/anamnesiprint','AnamnesiController@printAnamnesi');

                        /*Route::get('/IoMT', 'IoMTController@index')->name('IoMT');
                        Route::post('/IoMT', 'IoMTController@store')->name('IoMTStore');*/
                        Route::get ( '/terapie_farmacologiche', 'PazienteController@showTerapie' )->name ( 'terapie_farmacologiche' );
                        Route::get ( '/indagini', 'PazienteController@showIndagini' )->name ( 'indagini' ) -> middleware('consent:8');
                        Route::get ( '/diagnosi', 'PazienteController@showDiagnosi' )->name ( 'diagnosi' );
                        Route::get ( '/files', 'PazienteController@showFiles' )->name ( 'files' );
                        Route::get ( '/taccuino', 'PazienteController@showTaccuino' )->name ( 'taccuino' );
                        Route::get ( '/careproviders', 'PazienteController@showCareProviders' )->name ( 'careproviders' )->middleware('consent:2');
                        Route::get ( '/calcolatrice-medica', 'PazienteController@showCalcolatriceMedica' )->name ( 'calcolatrice-medica' );
                        Route::get ( '/utility', function () {
                            return view ( 'pages.utility' );
                        })->name ( 'utility' );
                    }
                );
            }
        );

      Route::group (
            ['middleware' => ['impersonate']
            ], function ()
            {
                Route::get ( '/patient-home', 'HomeController@index' )->name ( 'patient-home' );
                Route::get ( '/visits', 'PazienteController@showVisits' )->name ( 'visite' )->middleware('consent:3');
                Route::get ( '/patient-summary-cp', 'PazienteController@showPatientSummary' )->name ( 'patient-summary-cp' );

                Route::resource('/anamnesi','AnamnesiController',['except' => ['create', 'show','store', 'destroy']]);
                Route::post('/anamnesi','AnamnesiController@store');
                Route::patch('/anamnesi/{id}', 'AnamnesiController@update')->name('Update');
                Route::delete('/anamnesi/{id}', 'AnamnesiController@delete')->name('Delete');
                Route::post('/anamnesiprint','AnamnesiController@printAnamnesi');

                Route::get('/IoMT', 'IoMTController@index')->name('IoMT');
                Route::post('/IoMT', 'IoMTController@store')->name('IoMTStore');

                Route::get ( '/indagini', 'PazienteController@showIndagini' )->name ( 'indagini' ) -> middleware('consent:8');
                Route::get ( '/diagnosi', 'PazienteController@showDiagnosi' )->name ( 'diagnosi' );
                Route::get ( '/files', 'PazienteController@showFiles' )->name ( 'files' );
                Route::get ( '/taccuino', 'PazienteController@showTaccuino' )->name ( 'taccuino' );
                Route::get ( '/careproviders', 'PazienteController@showCareProviders' )->name ( 'careproviders' )->middleware('consent:2');
                Route::get ( '/calcolatrice-medica', 'PazienteController@showCalcolatriceMedica' )->name ( 'calcolatrice-medica' );
                Route::get ( '/utility', function () {
                    return view ( 'pages.utility' );
                })->name ( 'utility' );
            }
        );


	// Inizio Route Paziente
	
	Route::get('/vaccinazioni','PazienteController@showVaccinazioni')->name('vaccinazioni');
    Route::get('/addVacc/{vacc}/{data}/{reazione}/{richiamo}/{idPaz}/{cpp}', 'VaccinazioniController@addVaccinazione');
	Route::get('/delVacc/{idVacc}','VaccinazioniController@delVaccinazione');
	Route::get('/modVacc/{vacc}/{data}/{reazione}/{richiamo}/{idVacc}', 'VaccinazioniController@modVaccinazione');
	Route::get ( '/calcolatrice-medica', 'PazienteController@showCalcolatriceMedica' )->name ( 'calcolatrice-medica' );
	Route::get ( '/patient-summary','PazienteController@showPatientSummary' )->name ( 'patient-summary' );
	Route::get ( '/taccuino', 'PazienteController@showTaccuino' )->name ( 'taccuino' );
	Route::get ( '/files', 'PazienteController@showFiles' )->name ( 'files' );
	Route::get ( '/visits', 'PazienteController@showVisits' )->name ( 'visite' );//->middleware('consent:3');
	Route::get ( '/diagnosi', 'PazienteController@showDiagnosi' )->name ( 'diagnosi' );
	Route::get ( '/indagini', 'PazienteController@showIndagini' )->name ( 'indagini' );// -> middleware('consent:8');
	Route::get ( '/impostazioniSicurezza', 'PazienteController@showSecuritySettings' )->name ( 'securitySettings' );
	Route::get ( '/terapie_farmacologiche', 'PazienteController@showTerapie' )->name ( 'terapie_farmacologiche' );

	// Inizio Routes Care Provider
	Route::get ( '/patients-list', 'CareProviderController@showPatientsList' )->name ( 'patients-list' );
	Route::get ( '/structures', 'CareProviderController@showStructures' )->name ( 'structures' );
    Route::get ( '/fhirPatient', 'ResourceFHIRController@indexPatient' );
    Route::get ( '/patient-visit/{idToImpersonate}', 'CareProviderController@showPatientVisit' )->name ( 'visite' );
	Route::get ( '/fhirCareProviderIndexHome/{id}', 'Fhir\Modules\FHIRPractitionerIndex@Index');

//	Route::get ( '/patient-summary-cp', 'PazienteController@showPatientSummary' )->name ( 'patient-summary' );


        //Inizio Routes Emergency
	Route::get('/search-patient', 'EmergencyController@showPatientSearch')->name('search-patient');
	Route::get('/report-patient', 'EmergencyController@showPatientReport')->name('report-patient');
	Route::get ( '/PrivacyPolicy', function () {
		return view ( 'includes.template_PrivacyPolicy' );
	} );


		/**
		 * Route per la gestione della sezione Amministratori
		 */
		Route::get( '/administration/ControlPanel', 'AdministratorController@indexControlPanel' )->name('amm');
		Route::get( '/administration/CareProviders', 'AdministratorController@indexCareProviders' );
		Route::post ( '/administration/CareProviders/Update', 'AdministratorController@updateCppStatus');
		Route::get( '/administration/PatientsList', 'AdministratorController@getPatients' );
		Route ::post('/administration/PatientsList/Active', 'AdministratorController@updatePStatus');
		Route::get( '/administration/Administrators', 'AdministratorController@indexAmministration' );
		Route ::post('/administration/SA', 'AdministratorController@addAuditLog');
		Route ::post('/administration/ActivityCreate', 'AdministratorController@createActivityAdmin');
		Route ::post('/administration/AdminCreate', 'AdministratorController@addAdmin');
		Route::post('/administration/registerpatient', 'AdministratorController@registerPatientFromAdmin')->name('registerPatientAmm');
        Route::post('/administration/registercpp', 'AdministratorController@registerCareproviderFromAdmin')->name('registerCppAmm');
		Route:: post('/administration/AdminDelete', 'AdministratorController@destroy');
		Route::post( '/user/deleating', 'UserController@deleteUser' );
		Route::get( '/administration/Trattamenti', 'AdministratorController@indexTrattamenti' );
		Route::post( '/administration/updateTrattamentiP', 'AdministratorController@updateTrattamentiP' );
		Route::post( '/administration/updateTrattamentiCP', 'AdministratorController@updateTrattamentiCP' );
} );

Route::get('/cookie-page', 'CookieController@index');

Route::get ( '/fhirPractictioner', 'ResourceFHIRController@indexPractictioner' );
/*
 * Route::get('Patient/{id}', 'Fhir\Modules\FHIRPatient@showResource');
 *
 * Route::group( ['prefix' => 'fhir' ], function () {
 *
 * Route::get('Patient/{id}', 'Fhir\Modules\FHIRPatient@getResource');
 * Route::post('Patient', 'Fhir\Modules\FHIRPatient@createResource');
 * Route::put('Patient/{id}', 'Fhir\Modules\FHIRPatient@update');
 * Route::delete('Patient/{id}', 'Fhir\Modules\FHIRPatient@destroy');
 *
 * Route::get('Practitioner/{id?}','Fhir\Modules\FHIRPractitioner@mogetResource');
 *
 * Route::get('Appointments', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@showGroup');
 * // Appointment?patient=1&date=lt2016-09-30&dat=gt2016-08-30 Gets all appointments for September 2016 where patient ID == 1
 * // - if no patient is specified, we return the appointments of the current logged-in user
 * Route::get('Appointment', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@index');
 * // Create an Appointment by posting an Appointment Resource
 * Route::post('Appointment', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@post');
 * // Update an Appointment by PUTing an Appointment Resource
 * Route::put('Appointment{id?}', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@put');
 * // DELETE and appointment
 * Route::delete('Appointment/{id}', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@destroy');
 * // Get Slots for a provider Slot?provider=1&date=lt2020-09-30&date=gt2014-08-30
 * Route::get('Slot/{slotDate?}', '\LibreEHR\FHIR\Http\Controllers\SlotController@index');
 * // Post a Blundle of Resources to the base to create a bunch of resources
 * Route::post('/', '\LibreEHR\FHIR\Http\Controllers\BundleController@store');
 * // Get a ValueSet resource
 * Route::get('ValueSet/{id}', '\LibreEHR\FHIR\Http\Controllers\ValuesetController@show');
 *
 * });/*
 *
 *
 * Route
 *
 * /**
 * Route per l'inserimeno di una nuova visita da parte del paziente
 */
Route::post ( '/visite/addVisita', 'VisiteController@addVisita' );

/**
 * Route per l'eliminazione di una diagnosi da parte del paziente
 */
Route::get ( '/del/{getIdDiagnosi}/{idPaziente}', 'DiagnosiController@eliminaDiagnosi' );

Route::get ( '/getdiagnosi', 'DiagnosiController@getDiagnosi' );
/**
 * Route per l'inserimeno di una nuova diagnosi da parte del paziente
 */
Route::get ( '/addDiagn/{stato}/{cpp}/{idPaz}/{patol}', 'DiagnosiController@aggiungiDiagnosi' );
// Route::post ( '/addDiagn/{stato}/{cpp}/{idPaz}/{patol}', 'DiagnosiController@aggiungiDiagnosi' );
/**
 * Route per la modifica di una diagnosi da parte del paziente
 */
Route::get ( '/modDiagn/{idDiagnosi}/{stato}/{cpp}', 'DiagnosiController@modificaDiagnosi' );

/**
 * Route per l'invio di una mail ad un centro indagini da parte del paziente
 */
Route::get ( '/mail/{cpp}/{paz}/{ogg}/{testo}', 'MailController@mail' );

/**
 * Route per l'eliminazione di una indagine da parte del paziente
 */
Route::get ( '/delInd/{getIdIndagine}/{idUtente}', 'IndaginiController@eliminaIndagine' );

/**
 * Route per l'inserimeno di una nuova indagine richiesta da parte del paziente
 */
Route::get ( '/addIndRichiesta/{tipo}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{tipoDiagnosi}', 'IndaginiController@addIndagineRichiesta' );

/**
 * Route per l'inserimeno di una nuova indagine programmata da parte del paziente
 */
Route::get ( '/addIndProgrammata/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}', 'IndaginiController@addIndagineProgrammata' );

/**
 * Route per l'inserimeno di una nuova indagine completata da parte del paziente
 */
Route::get ( '/addIndCompletata/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}/{referto}/{allegato}/{referto_stato}', 'IndaginiController@addIndagineCompletata' );

/**
 * Route per la modifica di una indagine richiesta da parte del paziente
 */
Route::get ( '/ModIndRichiesta/{id}/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}', 'IndaginiController@ModIndagineRichiesta' );

/**
 * Route per la modifica di una indagine programmata da parte del paziente
 */
Route::get ( '/ModIndProgrammata/{id}/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}', 'IndaginiController@ModIndagineProgrammata' );

/**
 * Route per la modifica di una indagine programmata da parte del paziente
 */
Route::get ( '/ModIndCompletata/{id}/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}/{referto}/{allegato}', 'IndaginiController@ModIndagineCompletata' );


    Route::get('/fhirPractictioner', 'ResourceFHIRController@indexPractictioner');


    /*   Route::get('Patient/{id}', 'Fhir\Modules\FHIRPatient@showResource');

    Route::group( ['prefix' => 'fhir' ], function () {

    Route::get('Patient/{id}', 'Fhir\Modules\FHIRPatient@getResource');
    Route::post('Patient', 'Fhir\Modules\FHIRPatient@createResource');
    Route::put('Patient/{id}', 'Fhir\Modules\FHIRPatient@update');
    Route::delete('Patient/{id}', 'Fhir\Modules\FHIRPatient@destroy');

    Route::get('Practitioner/{id?}','Fhir\Modules\FHIRPractitioner@getResource');

    Route::get('Appointments', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@showGroup');
    // Appointment?patient=1&date=lt2016-09-30&dat=gt2016-08-30 Gets all appointments for September 2016 where patient ID == 1
    // - if no patient is specified, we return the appointments of the current logged-in user
    Route::get('Appointment', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@index');
    // Create an Appointment by posting an Appointment Resource
    Route::post('Appointment', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@post');
    // Update an Appointment by PUTing an Appointment Resource
    Route::put('Appointment{id?}', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@put');
    // DELETE and appointment
    Route::delete('Appointment/{id}', '\LibreEHR\FHIR\Http\Controllers\AppointmentController@destroy');
    // Get Slots for a provider Slot?provider=1&date=lt2020-09-30&date=gt2014-08-30
    Route::get('Slot/{slotDate?}', '\LibreEHR\FHIR\Http\Controllers\SlotController@index');
    // Post a Blundle of Resources to the base to create a bunch of resources
    Route::post('/', '\LibreEHR\FHIR\Http\Controllers\BundleController@store');
    // Get a ValueSet resource
    Route::get('ValueSet/{id}', '\LibreEHR\FHIR\Http\Controllers\ValuesetController@show');

    });/*

/* routes duplicate
         * //    /**
    //    * Route per l'inserimeno di una nuova visita da parte del paziente
    //    */
    //    Route::post('/visite/addVisita', 'VisiteController@addVisita');
    //
    //    /**
    //     * Route per l'eliminazione di una diagnosi da parte del paziente
    //     */
    //    Route::get('/del/{getIdDiagnosi}/{idPaziente}','DiagnosiController@eliminaDiagnosi');
    //
    //    /**
    //     * Route per l'inserimeno di una nuova diagnosi da parte del paziente
    //     */
    //    Route::get('/addDiagn/{stato}/{cpp}/{idPaz}/{patol}','DiagnosiController@aggiungiDiagnosi');
    //
    //    /**
    //     * Route per la modifica di una diagnosi da parte del paziente
    //     */
    //    Route::get('/modDiagn/{idDiagnosi}/{stato}/{cpp}','DiagnosiController@modificaDiagnosi');
    //
    //    /**
    //     * Route per l'invio di una mail ad un centro indagini da parte del paziente
    //     */
    //    Route::get('/mail/{cpp}/{paz}/{ogg}/{testo}', 'MailController@mail');
    //
    //    /**
    //     * Route per l'eliminazione di una indagine da parte del paziente
    //     */
    //    Route::get('/delInd/{getIdIndagine}/{idUtente}','IndaginiController@eliminaIndagine');
    //
    //    /**
    //     * Route per l'inserimeno di una nuova indagine richiesta da parte del paziente
    //     */
    //    Route::get('/addIndRichiesta/{tipo}/[tipoDiagnosi]/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}','IndaginiController@addIndagineRichiesta');
    //
    //    /**
    //     * Route per l'inserimeno di una nuova indagine programmata da parte del paziente
    //     */
    //    Route::get('/addIndProgrammata/{tipo}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}', 'IndaginiController@addIndagineProgrammata');
    //
    //    /**
    //     * Route per l'inserimeno di una nuova indagine completata da parte del paziente
    //     */
    //    Route::get('/addIndCompletata/{tipo}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}/{referto}/{allegato}', 'IndaginiController@addIndagineCompletata');
    //
    //    /**
    //     * Route per la modifica di una indagine richiesta da parte del paziente
    //     */
    //    Route::get('/ModIndRichiesta/{id}/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}','IndaginiController@ModIndagineRichiesta');
    //
    //    /**
    //     * Route per la modifica di una indagine programmata da parte del paziente
    //     */
    //    Route::get('/ModIndProgrammata/{id}/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}', 'IndaginiController@ModIndagineProgrammata');
    //
    //    /**
    //     * Route per la modifica di una indagine programmata da parte del paziente
    //     */
    //    Route::get('/ModIndCompletata/{id}/{tipo}/{tipoDiagnosi}/{motivo}/{Cpp}/{idCpp}/{idPaz}/{stato}/{idCentr}/{dataVis}/{referto}/{allegato}', 'IndaginiController@ModIndagineCompletata');

//*/


    Route::post('/fhirPatient/uploadPatient', 'FHIRPatientController@store' );



    Route::get('/fhirPatientIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@Index');
    Route::get('/fhirExportResources/Patient/{id}/{list}', 'Fhir\Modules\FHIRPatientIndex@exportResources');
    Route::get('/fhirPractitionerIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexPractitioner');
    Route::get('/fhirRelatedPersonIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexRelatedPerson');
    Route::get('/fhirObservationIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexObservation');
    Route::get('/fhirImmunizationIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexImmunization');
    Route::get('/fhirEncounterIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexEncounter');
    Route::get('/fhirConditionIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexCondition');
    Route::get('/fhirFamilyMemberHistoryIndex/{id}', 'Fhir\Modules\FHIRPatientIndex@indexFamilyMemberHistory');


    Route::get('/prova/{id}', 'Fhir\Modules\FHIRFamilyMemberHistory@getResource');
    //Route::get('/fhirPatientExport/{id}', 'Fhir\Modules\FHIRPatient@getResource');

	Route::any('/search',function(){
        $q = Input::get ( 'q' );
        $user = CareProvider::where('cpp_nome','LIKE','%'.$q.'%')->orWhere('cpp_cognome','LIKE','%'.$q.'%')->orWhere('id_cpp','LIKE','%'.$q.'%')->get();

        $practitioner = $user;
        $patient = Pazienti::where('id_paziente', 2)->first();
        $data['practitioner'] = $practitioner;
        $data['patient'] = $patient;

        if(count($user) > 0)
            return view("pages.fhir.Practitioner.searchPractitioner", [
                "data_output" => $data
            ])->withDetails($user)->withQuery ( $q );
            else{
                echo '<script type="text/javascript">
            alert(" Practitioner not found ")
            window.location.href = "fhirPractitionerIndex/2"
            </script>';
            }
    });
	
    /**
     * RESTful for Patient
     */
   Route::resource('fhir/Patient','Fhir\Modules\FHIRPatient');

    /**
    //     * Route per visualizzare la modal con i blocchi icd9
    //     */
   Route::post('/icdBlocDiag','AnamnesiController@icd9Bloc')->name('icd9Bloc');

   /**
    //     * Route per visualizzare la modal con le categorie icd9
    //     */
   Route::post('/icdBlocCat','AnamnesiController@icd9Cat')->name('icd9Cat');

   /**
    //     * Route per visualizzare la modal con i codici icd9
    //     */
   Route::post('/icdCod','AnamnesiController@icd9Cod')->name('icd9Cod');

   /**
    //     * Route per inserire patologie remote in tbl_anamnesi_pt_codificate
    //     */
   Route::post('/addPtRm','AnamnesiController@addPtRemota')->name('addPtRemota');

   /**
    //     * Route per inserire patologie remote in tbl_anamnesi_pt_codificate
    //     */
   Route::post('/addPtRec','AnamnesiController@addPtProssima')->name('addPtProssima');

   /**
    //     * Route per inserire patologie in tbl_anamnesi_fm_codificate
    //     */
   Route::post('/addPtFm','AnamnesiController@addPtParente')->name('addPtParente');

   /**
    //     * Route per visualizzare le patologie di un parente
    //     */
   Route::post('/showPtParente','AnamnesiController@showPtParente')->name('showPtParente');

   /**
    //     * Route per spostare patologie da anamnesi prossima a remota
    //     */
   Route::post('/spostaPtProssima','AnamnesiController@spostaPtProssima')->name('spostaPtProssima');

   /**
    //     * Route per spostare patologie da anamnesi prossima a remota
    //     */
   Route::post('/algoritmoDiagnostico','AlgoritmoDiagnosticoController@avviaAlgoritmoDiagnostico')->name('algoritmoDiagnostico');
   


   
