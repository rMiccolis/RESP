<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    private $successStatus = 200;
    private $key = '49dce6c6197feafced04651627626901';

    public function login(){
        if(Auth::attempt(['utente_nome' => $this->decrypt(request('utente_nome'), $this->key), 'password' => $this->decrypt(request('password'), $this->key)])){
            $user=Auth::user();
            $success['token'] = $user->createToken('RESP')->accessToken;
            return response()->json(['error' => false, 'token'=>$success, 'message' => 'Login Successful', 'user' => array('id_utente' =>$user->id_utente)], $this->successStatus);
        }else{
            return response()->json(['error' => true, 'token'=> null, 'message' => 'Wrong credential', 'user' => null],401);
        }
    }

    public function getDetails(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function decrypt($enc_data, $key){

        $key16 = substr($key, 0, 16);
        $key16Hex = unpack('H*', $key16);

        return openssl_decrypt($enc_data, "AES-128-CBC", $key16, 0, hex2bin($key16Hex[1]));
    }
}
