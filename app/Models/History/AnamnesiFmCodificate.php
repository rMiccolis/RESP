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
class AnamnesiFmCodificate extends Eloquent {
	protected $table = 'tbl_anamnesi_fm_codificate';
	protected $primaryKey = 'id';
	
	use Encryptable;
	public $timestamps = false;
	protected $casts = [ 
			'id' => 'int',
			'id_anamnesi_fm' => 'int',
			'id_parente' => 'int',
			'codice_diag' => 'string'
	];
	protected $fillable = [ 
			'id',
			'id_anamnesi_fm',
			'id_parente',
			'codice_diag' 
	];

}
