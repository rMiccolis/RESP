<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class Model3dMan extends Eloquent
{
    protected $table = 'model3d_men';
	protected $primaryKey = 'id_3d';
	public $incrementing = true;
	public $timestamps = true;

	protected $casts = [
		'id_3d' => 'int',
		'selected_places' => 'string',
		'id_paziente' => 'int',
		'id_taccuino' => 'int',
		'id_visita' => 'int',
	];

	protected $fillable = [
		'selected_places',
		'id_paziente',
		'id_visita',
		'id_taccuino',
    ];
    
    public function files() {
        return $this->belongsToMany(\App\Models\File::class, 'file_model3d', 'id_3d', 'id_file')->withPivot(['id_visita', 'id_taccuino'])->withTimeStamps();
	}

	public function taccuino(){
		return $this->belongsTo(\App\Models\Patient\Taccuino::class, 'id_taccuino');
	}
	
	public function visita(){
		return $this->belongsTo(\App\Models\Patient\PazientiVisite::class, 'id_visita');
    }
}