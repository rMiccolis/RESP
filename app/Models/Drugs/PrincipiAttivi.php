<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 25 Dec 2017 12:47:05 +0000.
 */

namespace App\Models\Drugs;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PrincipiAttivi
 *
 * @property string $id_principio_attivo
 * @property string $descrizione
 * @property string $id_cas
 * @property string $id_einecs
 * @property string $peso_molecolare
 *
 * @property \App\Models\Drugs\Terapie $tbl_terapie
 *
 * @package App\Models\Drugs
 */
class PrincipiAttivi extends Eloquent
{
	protected $table = 'tbl_principi_attivi';
	protected $primaryKey = 'id_principio_attivo';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'id_principio_attivo',
		'descrizione',
		'id_cas',
		'id_einecs',
		'peso_molecolare'
	];

	public function tbl_farmaci() {
    		return $this->belongsToMany('\App\Models\Drugs\Farmaci', 'farmaci_principi_attivi', 'id_sostanza', 'id_principio_attivo');
    }
}
