<?php

namespace App\Http\Controllers;

use App\Models\eKuore;
use App\Models\HbMeter;
use App\Models\Kardia;
use App\Models\VoxTester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Sabberworm\CSS\Value\URL;

class IoMTController extends Controller
{
    public function index(){

        $ekuores = eKuore::where('id_utente', Auth::id())->orderBy('date', 'desc')->get();
        $hbmeters = HbMeter::where('id_utente', Auth::id())->orderBy('analisi_giorno', 'desc')->get();
        $kardias = Kardia::where('id_utente', Auth::id())->orderBy('date', 'desc')->get();
        $voxtesters = VoxTester::where('id_utente', Auth::id())->orderBy('audio', 'desc')->get();
        $uniquevoxtesters = $voxtesters->unique('audio');

        return view("pages.iomt", compact('ekuores','hbmeters', 'kardias', 'uniquevoxtesters'));
    }

    public function store(Request $request)
    {
        $input = request()->input_name;

        switch ($input){
            case "Kardia":
                $this->storeKardia($request);
                break;
            case "eKuore":
                $this->storeeKuore($request);
                break;
        }

        return redirect('/IoMT');
    }

    public function storeKardia($request)
    {

            $path = '/uploads/kardia/' . $request->file('upload_pdf')->getClientOriginalName();
            Storage::put($path, $request->file('upload_pdf')->getClientOriginalName());
            $kardia = new Kardia;
            $kardia->id_utente = Auth::user()->id_utente;
            $kardia->date = date('d-m-Y');
            $kardia->filepdf = $path;

            $kardia->save();


        return redirect('/IoMT');
    }

    public function storeeKuore($request)
    {

        $path = '/uploads/ekuore/' . $request->file('upload_audio')->getClientOriginalName();
        Storage::put($path, $request->file('upload_audio')->getClientOriginalName());
        $ekuore = new eKuore;
        $ekuore->id_utente = Auth::user()->id_utente;
        $ekuore->date = date('d-m-Y');
        $ekuore->fileaudio = $path;

        $ekuore->save();

        return redirect('/IoMT');
    }
}
