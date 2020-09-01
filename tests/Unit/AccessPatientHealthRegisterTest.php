<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImpersonateTest extends TestCase
{    
    /**
     * Checks if CareProvider can access the Patient Profile
     */
    public function testAccessPatientProfile() {

        $response = $this->accessPatientProfile();

        //Checks if the impersonation has been started correctly
        $response->assertSessionHas('impersonate');

        //Checks if will be redirected to Patient Summary page
        $response->assertRedirect('/patient-summary');
    }
    
    /**
     * Checks if CareProvider can stop the impersonation of patient
     */
    public function testClosePatientProfile() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/home');

        //Checks if the impersonation has been stopped correctly
        $response->assertSessionMissing('impersonate');

        //Checks if will be redirected to Patients List page
        $response->assertRedirect('/patients-list');
    }

    /**
     * Checks if a non authenticated user can start impersonation
     */
    public function testStartImpersonateNotAuth() {

        $response = $this->call('GET','/patient-visit/2');

        //Checks if the impersonation has not been started
        $response->assertSessionMissing('impersonate');

        //Checks if will be redirected to Homepage
        $response->assertRedirect('/');
    }

    /**
     * Checks if an authenticated user that isn't Care Provider 
     * can start impersonation
     */
    public function testStartImpersonateFromPatient() {

        $response = $this->accessPatientProfile(true);

        //Checks if the impersonation has not been started
        $response->assertSessionMissing('impersonate');

        //Checks if will be redirected to Homepage
        $response->assertRedirect('/home');
    }

    /**
     * Checks if Care Provider, when access the Patient Register, 
     * can go back to Patient homepage 
     */
    public function testRedirectToPatientHome() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/patient-home');

        //Checks if will be redirected to Patient Summary 
        $response->assertRedirect('/patient-summary');
    }

    ////////////////////////////////////////////////////

    //  START of menu tests in the left sidebar

    ////////////////////////////////////////////////////
    
    /**
     * Checks if CareProvider can access the Patient Summary page
     */
    public function testAccessPatientProfileSummary() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/patient-summary');
        $response->assertViewIs('pages.patient-summary');
    }
    
    /**
     * Checks if CareProvider can access the Patient Visits page
     */
    public function testAccessVisits() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/visits');
        $response->assertViewIs('pages.visite');
    }
    
    /**
     * Checks if CareProvider can access the Patient Anamnesi page
     */
    public function testAccessAnamnesi() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/anamnesi');
        $response->assertViewIs('pages.anamnesi');
    }
    
    /**
     * Checks if CareProvider can access the Patient Indagini page
     */
    public function testAccessIndagini() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/indagini');
        $response->assertViewIs('pages.indagini');
    }
    
    /**
     * Checks if CareProvider can access the Patient Diagnosi page
     */
    public function testAccessDiagnosi() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/diagnosi');
        $response->assertViewIs('pages.diagnosi');
    }
    
    /**
     * Checks if CareProvider can access the Patient Files page
     */
    public function testAccessFiles() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/files');
        $response->assertViewIs('pages.files');
    }
    
    /**
     * Checks if CareProvider can access the Patient Taccuino page
     */
    public function testAccessTaccuino() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/taccuino');
        $response->assertViewIs('pages.taccuino');
    }
    
    /**
     * Checks if CareProvider can access the Patient Calcolatrice page
     */
    public function testAccessCalcolatriceMedica() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/calcolatrice-medica');
        $response->assertViewIs('pages.calcolatrice-medica');
    }
    
    /**
     * Checks if CareProvider can access the Patient Utility page
     */
    public function testAccessUtility() {

        $response = $this->accessPatientProfile();

        $response = $this->call('GET','/utility');
        $response->assertViewIs('pages.utility');
    }

    ////////////////////////////////////////////////////

    //  END of menu tests in the left sidebar

    ////////////////////////////////////////////////////
}
