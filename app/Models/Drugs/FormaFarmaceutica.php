<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FormaFarmaceutica extends Eloquent
{
  protected $table = 'tbl_forme_farmaceutiche';
	protected $primaryKey = 'id_forma_farmaceutica';
	public $incrementing = false;
	public $timestamps = false;

  protected $fillable = [
		'id_forma_farmaceutica',
		'descrizione'
	];

  public function tbl_terapie() {
    return $this->hasMany('\App\Models\Drugs\Terapie', 'id_forma_farmaceutica');
  }
}
