<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model as Eloquent;

use App\Models\CurrentUser\User;
use App\Models\Diagnosis\Diagnosi;
use App\Models\Drugs\Farmaci;

use Encryptable;

class Terapie extends Eloquent
{

  protected $table = 'tbl_terapie';
  protected $primaryKey = 'id_terapie';
  public $timestamps = false;


  protected $casts = [
    'id_terapie' => 'int',
    'id_paziente' => 'int'
  ];
  protected $dates = [
    'dataAggiornamento',
    'data_evento',
    'data_inizio',
    'data_fine'
  ];


  protected $fillable = [
    'id_paziente',
    'dataAggiornamento',
    'tipo_terapia',
    'id_farmaco_codifa',
    'data_evento',
    'id_prescrittore',
    'data_inizio',
    'data_fine',
    'id_diagnosi',
    'id_livello_confidenzialita',
    'note'
];
  protected $encryptable = [
    'note'
];

  public function tbl_pazienti() {
    return $this->belongsTo('\App\Models\Patient\Pazienti', 'id_paziente' );
  }

  public function tbl_farmaci() {
    return $this->belongsTo ('\App\Models\Drugs\Farmaci', 'id_farmaco_codifa' );
  }

  public function tbl_utenti() {
    return $this->belongsTo('\App\Models\CurrentUser\User', 'id_utente', 'id_prescrittore');
  }

  public function tbl_diagnosi() {
    return $this->belongsToMany ('App\Models\Diagnosis\Diagnosi', 'diagnosi_terapie', 'id_diagnosi', 'id_diagnosi' );
  }

  public function tbl_livelli_confidenzialita() {
    return $this->belongsTo ('App\Models\CareProviders\LivelliConfidenzialita', 'id_livello_confidenzialita');
  }

  public function getPrescrittore(){
      $user = User::where('id_utente', $this->id_prescrittore)->first();
      return $user->utente_nome;
  }

  public function getDiagnosi(){
      $diagnosi = Diagnosi::where('id_diagnosi', $this->id_diagnosi)->first();
      return $diagnosi->diagnosi_patologia;
  }

  public function getFarmaco(){
      $farmaco = Farmaci::where('id_farmaco_codifa', $this->id_farmaco_codifa)->first();
      return $farmaco;
  }



}