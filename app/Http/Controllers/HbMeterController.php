<?php

namespace App\Http\Controllers;

use App\Http\Resources\HbMeterCollection;
use App\Http\Resources\HbMeterResource;
use App\Models\File;
use App\Models\HbMeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class HbMeterController extends Controller
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
        return HbMeterCollection::collection(HbMeter::all());
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
        $hbmeter = new HbMeter;
        $hbmeter->id_utente = Auth::user()->id_utente;
        $hbmeter->analisi_giorno = $this->decrypt($request->analisi_giorno, $this->key);
        $hbmeter->analisi_valore = $this->decrypt($request->analisi_valore, $this->key);
        $hbmeter->analisi_laboratorio = $this->decrypt($request->analisi_laboratorio, $this->key);

        $image = $this->decrypt($request->img_palpebra, $this->key);
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = date('Ymdhi') . '.jpeg';
        Storage::put('/uploads/hbmeter/' . $imageName, base64_decode($image));
        $hbmeter->img_palpebra = '/uploads/hbmeter/' . $imageName;

        $hbmeter->save();

        return response([
            'data' => new HbMeterResource($hbmeter)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function show(HbMeter $hbMeter)
    {
        return new HbMeterResource($hbMeter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function edit(HbMeter $hbMeter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HbMeter $hbMeter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HbMeter  $hbMeter
     * @return \Illuminate\Http\Response
     */
    public function destroy(HbMeter $hbMeter)
    {
        //
    }


    public function decrypt($enc_data, $key){

        $key16 = substr($key, 0, 16);
        $key16Hex = unpack('H*', $key16);

        return openssl_decrypt($enc_data, "AES-128-CBC", $key16, 0, hex2bin($key16Hex[1]));
    }
}
