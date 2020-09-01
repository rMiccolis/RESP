<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class File
 * 
 * @property int $id_file
 * @property int $id_paziente
 * @property int $id_audit_log
 * @property int $id_file_confidenzialita
 * @property string $file_nome
 * @property string $file_commento
 * 
 * @property \App\Models\TblAuditlogLog $tbl_auditlog_log
 * @property \App\Models\LivelliConfidenzialita $tbl_livelli_confidenzialitum
 * @property \App\Models\Pazienti $tbl_pazienti
 *
 * @package App\Models
 */
class File extends Eloquent
{
	protected $primaryKey = 'id_file'; 
	protected $table = 'tbl_files';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'id_file' => 'int',
		'id_paziente' => 'int',
		'id_audit_log' => 'int',
	];

	protected $fillable = [
		'id_paziente',
		'id_audit_log',
		'file_nome',
        'hash',
		'file_commento'
	];

	public function auditlog_log()
	{
		return $this->belongsTo(\App\Models\Log\AuditlogLog::class, 'id_audit_log');
	}

	public function tbl_pazienti()
	{
		return $this->belongsTo(\App\Models\Pazienti::class, 'id_paziente');
	}

	public function men()
	{
		return $this->belongsToMany(\App\Models\Model3dMan::class,'file_model3d', 'id_file', 'id_3d' )->withPivot(['id_visita', 'id_taccuino'])->withTimeStamps();
	}
}
