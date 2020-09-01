<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model as Eloquent;

use App\Models\Drugs\CodiceATC;
use App\Models\Drugs\FormaFarmaceutica;
use App\Models\Drugs\FarmaciTipologieSomm;
use App\Models\Drugs\PrincipiAttivi;


class Farmaci extends Eloquent
{
	protected $table = 'tbl_farmaci';
    protected $primaryKey = 'id_farmaco_codifa';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
        'data_registrazione',
        'data_codifica_EMEA',
        'data_commercializzazione',
        'data_reg_PMC',
        'data_reg_dietetici'
      ];

      protected $fillable = [
    		'id_farmaco_codifa',
    		'cod_minsan',
        'cod_EMEA',
        'cod_articolo',
        'descrizione_breve',
        'descrizione_estesa',
        'tipo',
        'data_registrazione',
        'data_codifica_EMEA',
        'data_commercializzazione',
        'id_forma_farmaceutica',
        'id_via_somministrazione',
        'q_ta_confezione',
        'id_unita_misura_q_ta',
        'num_unita_posologiche_rif',
        'val_rif_unita_posologiche',
        'destinazione_duso',
        'id_codiceATC',
        'id_sostanza',
        'scadenza',
        'id_unita_misura_scadenza',
        'id_prodotti_identici',
        'id_codifa_nuovo_prodotto',
        'id_codifa_vecchio_prodotto',
        'numero_reg_PMC',
        'data_reg_PMC',
        'numero_reg_dietetici',
        'data_reg_dietetici',
        'cod_new_minsan_10',
        'cod_old_minsan_10',
        'id_titolare_AIC',
        'id_concessionario',
        'id_gruppo_terrapeutico',
        'id_ATC_complementare_somm',
        'capacita_unita_posologica',
        'id_unita_misura_capacita_UP',
        'monitoraggio_intensivo',
        'quote_spettanza'
    	];

	public function tbl_terapie() {
        return $this->hasMany ('\App\Models\Drugs\Terapie', 'farmaci_terapie', 'id_farmaco_codifa', 'id_farmaco_codifa' );
      }

      public function tbl_forme_farmaceutiche() {
        return $this->belongsTo('\App\Models\Drugs\FormaFarmaceutica', 'id_forma_farmaceutica');
      }

      public function tbl_farmaci_tipologie_somm() {
        return $this->belongsTo('\App\Models\Drugs\FarmaciTipologieSomm', 'id_via_somministrazione');
      }

      public function tbl_codiciATC() {
        return $this->belongsTo('\App\Models\Drugs\CodiceATC', 'id_codiceATC');
      }

      public function tbl_principi_attivi() {
        return $this->belongsToMany('\App\Models\Drugs\PrincipiAttivi', 'farmaci_principi_attivi', 'id_principio_attivo', 'id_sostanza');
      }

      public function getPrincipioAttivo(){
          $principioA = PrincipiAttivi::where('id_principio_attivo', $this->id_sostanza)->first();
          return $principioA->descrizione;
        }

      public function getFormaFarmaceutica(){
          $forma_farmaceutica = FormaFarmaceutica::where('id_forma_farmaceutica', $this->id_forma_farmaceutica)->first();
          return $forma_farmaceutica->descrizione;
      }

      public function getTipologiaSomministrazione(){
          $tipologia_somministrazione = FarmaciTipologieSomm::where('id_via_somministrazione', $this->id_via_somministrazione)->first();
          return $tipologia_somministrazione->descrizione;
      }

	  public function getATC(){
          $atc = CodiceATC::where('id_codiceATC', $this->id_codiceATC)->first();
          return $atc->descrizione;
      }
}
