<?php

namespace App\Models\CareProviders;

use Illuminate\Database\Eloquent\Model;

class LivelliConfidenzialita extends Model
{
  protected $table = 'tbl_livelli_confidenzialita';
  protected $primaryKey = 'id_livello_confidenzialita';
  public $incrementing = false;
  public $timestamps = false;


  protected $fillable = [

    'id_livello_confidenzialita',
    'confidenzialita_descrizione'

  ];

  public function tbl_livelli_confidenzialita() {
    return $this->hasMany ('App\Models\CareProviders\LivelliConfidenzialita', 'id_livello_confidenzialita');
  }
}
