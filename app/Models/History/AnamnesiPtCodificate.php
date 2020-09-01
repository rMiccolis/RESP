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
class AnamnesiPtCodificate extends Eloquent {
	protected $table = 'tbl_anamnesi_pt_codificate';
	protected $primaryKey = 'id';
	
	use Encryptable;
	public $timestamps = false;
	protected $casts = [ 
			'id' => 'int',
			'id_anamnesi_pt' => 'int',
			'codice_diag' => 'string',
			'stato' => 'string'
	];
	protected $fillable = [ 
			'id',
			'id_anamnesi_pt',
			'codice_diag',
			'stato' 
	];

}
