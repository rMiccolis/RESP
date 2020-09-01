<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CodiceATC extends Eloquent
{
  protected $table = 'tbl_codiciATC';
	protected $primaryKey = 'id_codiceATC';
	public $incrementing = false;
	public $timestamps = false;

  protected $fillable = [
		'id_codiceATC',
		'descrizione',
		'destinazione_d_uso',
        'uso_terapeutico',
        'livello'
	];

  public function tbl_farmaci() {
  		return $this->hasMany('\App\Models\Drugs\Farmaci', 'id_codiceATC');
  	}

}
