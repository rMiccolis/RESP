<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */
namespace App\Models\History;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class AnamnesiPtCodificateextends
 *
 *
 * @package App\Models
 */
class AnamnesiPt extends Eloquent {
	protected $table = 'tbl_anamnesi_pt';
	protected $primaryKey = 'id';

	use Encryptable;
	public $timestamps = false;
	protected $casts = [
			'id' => 'int',
			'id_paziente' => 'int',
			'id_anamnesi_remota_log' => 'int',
			'id_anamnesi_prossima_log' => 'int',
			'anamnesi_remota_contenuto' => 'string',
			'anamnesi_prossima_contenuto' => 'string'
	];

	protected $dates = [
    'dataAggiornamento_anamnesi_prossima',
    'dataAggiornamento_anamnesi_remota'
  ];

	protected $encryptable = [
			'anamnesi_remota_contenuto',
			'anamnesi_prossima_contenuto'
	];
	protected $fillable = [
			'id',
			'id_paziente',
			'id_anamnesi_remota_log',
			'id_anamnesi_prossima_log',
			'dataAggiornamento_anamnesi_prossima',
	    'dataAggiornamento_anamnesi_remota',
			'anamnesi_remota_contenuto',
			'anamnesi_prossima_contenuto'
	];
}
