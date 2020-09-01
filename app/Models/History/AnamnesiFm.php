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
class AnamnesiFm extends Eloquent {
	protected $table = 'tbl_anamnesi_fm';
	protected $primaryKey = 'id';

	use Encryptable;
	public $timestamps = false;
	protected $casts = [
			'id' => 'int',
			'id_paziente' => 'int',
			'id_anamnesi_log' => 'int',
			'anamnesi_familiare_contenuto' => 'string'
	];
	protected $encryptable = [
			'anamnesi_familiare_contenuto'
	];

	protected $dates = [
    'dataAggiornamento'
  ];

	protected $fillable = [
			'id',
			'id_paziente',
			'id_anamnesi_log',
			'dataAggiornamento',
			'anamnesi_familiare_contenuto'
	];
}
