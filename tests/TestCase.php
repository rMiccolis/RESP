<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Http\Controllers\Auth\LoginController;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
<<<<<<< HEAD
     * Login as Care Provider
     */
    protected function loginCareProvider()
    {
        $loginC = new LoginController();
        $usernameDbFieldName = $loginC->username();
        $passwordDbFieldName = $loginC->password();

        $response = $this->call('POST', '/login', [
            $usernameDbFieldName => 'Bob Kelso',
            $passwordDbFieldName => 'test1234'
        ]);

        return $response;
    }

    /**
     * Login as Patient
     */
    protected function loginPatient()
    {
        $loginC = new LoginController();
        $usernameDbFieldName = $loginC->username();
        $passwordDbFieldName = $loginC->password();

        $response = $this->call('POST', '/login', [
            $usernameDbFieldName => 'Janitor Jan',
            $passwordDbFieldName => 'test1234'

    //  * Logs the user in the system, for tests that require users to be logged-in
    //  * @param $username
    //  * @param $password
    //  * @return \Illuminate\Foundation\Testing\TestResponse
    //  */
    // protected function login($username, $password)
    // {
    //
    //     $loginC = new LoginController();
    //     $usernameDbFieldName = $loginC->username(); //'utente_nome'
    //     $passwordDbFieldName = $loginC->password(); //'utente_password'
    //
    //     $response = $this->call('POST', '/login', [
    //         $usernameDbFieldName => $username,
    //         $passwordDbFieldName => $password
        ]);

        return $response;
    }

    /**
     * Starting the Impersonation process
     *
     * @param loginAsPatient optional, default is false, if setted true will login as Patient user
     */
    protected function accessPatientProfile($loginAsPatient = false) {

        if(!$loginAsPatient)
            $this->loginCareProvider();
        else
            $this->loginPatient();

        //Access the Patient Profile
        $response = $this->call('GET','/patient-visit/2');

        return $response;
    }
}
