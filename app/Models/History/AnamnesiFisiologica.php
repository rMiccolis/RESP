<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\History;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AnamnesiFisiologica
 *
 * @property int $id_anamnesi_fisiologica
 * @property int $id_paziente
 * @property int $id_anamnesi_log
 *
 * @package App\Models
 */
class AnamnesiFisiologica extends Eloquent
{
    protected $table = 'tbl_anamnesi_fisiologica';
    protected $primaryKey = 'id_paziente';
    public $timestamps = false;

    protected $dates = [
        'dataAggiornamento',
        'dataInizioFumo',
        'dataFineFumo',
        'dataInizioAlcool',
        'dataFineAlcool',
        'dataInizioDroghe',
        'dataFineDroghe'
    ];

    protected $casts = [
        'id_paziente' => 'int',
        'id_anamnesi_log' => 'int',
        'dosiFumo' => 'int',
        'dosiAlcool' => 'int',
        'dosiDroghe' => 'int',
        'dosiCaffeina' => 'int'
    ];

    protected $fillable = [
        'id_paziente',
        'id_anamnesi_log',
        'dataAggiornamento',
        'tempoParto',
        'tipoParto',
        'allattamento',
        'sviluppoVegRel',
        'noteInfanzia',
        'livelloScol',
        'etaMenarca',
        'ciclo',
        'etaMenopausa',
        'menopausa',
        'noteCicloMes',
        'attivitaFisica',
        'abitudAlim',
        'ritmoSV',
        'stress',
        'fumo',
        'dosiFumo',
        'dataInizioFumo',
        'dataFineFumo',
        'alcool',
        'dosiAlcool',
        'tipoAlcool',
        'dataInizioAlcool',
        'dataFineAlcool',
        'droghe',
        'dosiDroghe',
        'tipoDroghe',
        'dataInizioDroghe',
        'dataFineDroghe',
        'caffeina',
        'dosiCaffeina',
        'noteStileVita',
        'alvo',
        'minzione',
        'noteAlvoMinz',
        'professione',
        'noteAttLav'
    ];


}


