<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\CareProviders;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Traits\Encryptable;

/**
 * Class CppDiagnosi
 * 
 * @property int $id_diagnosi
 * @property string $diagnosi_stato
 * @property int $id_cpp
 * @property string $careprovider
 * 
 * @property \App\Models\TblCareProvider $tbl_care_provider
 * @property \App\Models\Diagnosi $tbl_diagnosi
 *
 * @package App\Models
 */
class CppDiagnosi extends Eloquent
{
	protected $table = 'tbl_cpp_diagnosi';
	protected $primaryKey = 'id_diagnosi';
	public $incrementing = false;
	public $timestamps = false;
	use Encryptable;
	
	protected $casts = [
		'id_diagnosi' => 'int',
		'id_cpp' => 'int'
	];
	
	protected $encryptable = [
			'diagnosi_stato',
	];

	protected $fillable = [
		'diagnosi_stato',
		'id_cpp',
		'careprovider'
	];

	public function tbl_care_provider()
	{
		return $this->belongsTo(\App\Models\CareProviders\CareProvider::class, 'id_cpp');
	}

	public function tbl_diagnosi()
	{
		return $this->belongsTo(\App\Models\Diagnosis\Diagnosi::class, 'id_diagnosi');
	}
}
