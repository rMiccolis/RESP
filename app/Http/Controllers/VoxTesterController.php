<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoxTesterCollection;
use App\Http\Resources\VoxTesterResource;
use App\Models\VoxTester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VoxTesterController extends Controller
{

    private $key = '49dce6c6197feafced04651627626901';

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VoxTesterCollection::collection(VoxTester::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $audios = $request->audio;
        $filenames = $request->filename;
        $response = "";

        for ($i=0; $i<count($audios); $i++) {
            if (file_exists(public_path() . '/uploads/voxtester/' . $this->decrypt($filenames[$i], $this->key))) {

                $response = response([
                    'data' => "Registrazione " . $this->decrypt($filenames[$i], $this->key) . " già presente"
                ], Response::HTTP_CONFLICT);

            }
            $voxtester = new VoxTester;
            $voxtester->id_utente = Auth::user()->id_utente;
            $voxtester->date = $this->decrypt($request->date, $this->key);

            $fileaudio = $this->decrypt($audios[$i], $this->key);
            $fileaudio = str_replace('data:audio/wav;base64,','', $fileaudio);
            $fileaudio = str_replace(' ', '+', $fileaudio);
            $fileaudioName = $this->decrypt($filenames[$i], $this->key);
            Storage::put('/uploads/voxtester/' . $fileaudioName, base64_decode($fileaudio));
            $voxtester->audio = '/uploads/voxtester/' . $fileaudioName;


            $voxtester->save();
            $response = response([
                'data' => new VoxTesterResource($voxtester)
            ], Response::HTTP_CREATED);
        }

        return $response;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function show(VoxTester $voxTester)
    {
        return new VoxTesterResource($voxTester);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function edit(VoxTester $voxTester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoxTester $voxTester)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VoxTester  $voxTester
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoxTester $voxTester)
    {
        //
    }

    public function decrypt($enc_data, $key){

        $key16 = substr($key, 0, 16);
        $key16Hex = unpack('H*', $key16);

        return openssl_decrypt($enc_data, "AES-128-CBC", $key16, 0, hex2bin($key16Hex[1]));
    }
}
