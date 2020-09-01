<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class HbMeter extends Model
{
    use Encryptable;

    public $timestamps = false;
    protected $encryptable = [
        'analisi_giorno',
        'analisi_valore',
        'analisi_laboratorio',
        'img_palpebra'
    ];

    protected $fillable = [
        'analisi_giorno',
        'analisi_valore',
        'analisi_laboratorio',
        'img_palpebra'
    ];
}
