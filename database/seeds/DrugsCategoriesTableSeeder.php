<?php

use Illuminate\Database\Seeder;

class DrugsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('tbl_farmaci_categorie')->insert([
      ['categoria_descrizione' => 'ACE inibitori, associazioni','id_categoria' => 'cf001'],
      ['categoria_descrizione' => 'ACE inibitori, semplici','id_categoria' => 'cf002'],
      ['categoria_descrizione' => 'Adrenergici per uso sistemico','id_categoria' => 'cf003'],
      ['categoria_descrizione' => 'Adrenergici, da inalare','id_categoria' => 'cf004'],
      ['categoria_descrizione' => 'Agenti antiadrenergici ad azione centrale','id_categoria' => 'cf005'],
      ['categoria_descrizione' => 'Agenti antiadrenergici ad azione periferica','id_categoria' => 'cf006'],
      ['categoria_descrizione' => 'Agenti anti-infiammatori','id_categoria' => 'cf007'],
      ['categoria_descrizione' => 'Agenti anti-paratiroidei','id_categoria' => 'cf008'],
      ['categoria_descrizione' => 'Agenti dopaminergici','id_categoria' => 'cf009'],
      ['categoria_descrizione' => 'Agenti modificanti i lipidi, associazioni','id_categoria' => 'cf010'],
      ['categoria_descrizione' => 'Agenti modificanti i lipidi, semplici','id_categoria' => 'cf011'],
      ['categoria_descrizione' => 'Agenti per disturbi vascolari oculari','id_categoria' => 'cf012'],
      ['categoria_descrizione' => 'Agenti protettivi contro le radiazioni ultraviolette','id_categoria' => 'cf013'],
      ['categoria_descrizione' => 'Alcaloidi derivati dalle piante e altri prodotti naturali','id_categoria' => 'cf014'],
      ['categoria_descrizione' => 'Altre droghe per il sistema nervoso','id_categoria' => 'cf015'],
      ['categoria_descrizione' => 'Altre preparazioni antianemiche','id_categoria' => 'cf016'],
      ['categoria_descrizione' => 'Altre sostanze che agiscono sul sistema renina-angiotensina','id_categoria' => 'cf017'],
      ['categoria_descrizione' => 'Altri agenti antineoplastici','id_categoria' => 'cf018'],
      ['categoria_descrizione' => 'Altri agenti diagnostici','id_categoria' => 'cf019'],
      ['categoria_descrizione' => 'Altri analgesici e antipiretici','id_categoria' => 'cf020'],
      ['categoria_descrizione' => 'Altri antibiotici','id_categoria' => 'cf021'],
      ['categoria_descrizione' => 'Altri antibiotici beta-lattamici','id_categoria' => 'cf022'],
      ['categoria_descrizione' => 'Altri antipertensivi','id_categoria' => 'cf023'],
      ['categoria_descrizione' => 'Altri diuretici','id_categoria' => 'cf024'],
      ['categoria_descrizione' => 'Altri farmaci ematologici','id_categoria' => 'cf025'],
      ['categoria_descrizione' => 'Altri farmaci ginecologici','id_categoria' => 'cf026'],
      ['categoria_descrizione' => 'Altri farmaci per i disturbi del sistema muscolo scheletrico','id_categoria' => 'cf027'],
      ['categoria_descrizione' => 'Altri farmaci per le malattie respiratorie ostruttive, da inalare','id_categoria' => 'cf028'],
      ['categoria_descrizione' => 'Altri farmaci sistemici per le malattie respiratorie ostruttive','id_categoria' => 'cf029'],
      ['categoria_descrizione' => 'Altri oftamologici','id_categoria' => 'cf030'],
      ['categoria_descrizione' => 'Altri ormoni sessuoli e modulatori del sistema genitale','id_categoria' => 'cf031'],
      ['categoria_descrizione' => 'Altri preparati cardiaci','id_categoria' => 'cf032'],
      ['categoria_descrizione' => 'Altri preparati con vitamine semplici','id_categoria' => 'cf033'],
      ['categoria_descrizione' => 'Altri preparati dermatologici','id_categoria' => 'cf034'],
      ['categoria_descrizione' => 'Altri prodotti per il sistema respiratorio','id_categoria' => 'cf035'],
      ['categoria_descrizione' => 'Altri prodotti per il tratto alimentare e il metabolismo','id_categoria' => 'cf036'],
      ['categoria_descrizione' => 'Altri radiofarmaci terapeutici','id_categoria' => 'cf037'],
      ['categoria_descrizione' => 'Androgeni','id_categoria' => 'cf038'],
      ['categoria_descrizione' => 'Anestetici, generici','id_categoria' => 'cf039'],
      ['categoria_descrizione' => 'Anestetici, locali','id_categoria' => 'cf040'],
      ['categoria_descrizione' => 'Ansiolitici','id_categoria' => 'cf041'],
      ['categoria_descrizione' => 'Antagonisti del recettore per l\'angiotensina II, semplici','id_categoria' => 'cf042'],
      ['categoria_descrizione' => 'Antagonisti ormonali e sostanze correlate','id_categoria' => 'cf043'],
      ['categoria_descrizione' => 'Antiacidi','id_categoria' => 'cf044'],
      ['categoria_descrizione' => 'Antiandrogeni','id_categoria' => 'cf045'],
      ['categoria_descrizione' => 'Antiaritmici, classe I e III','id_categoria' => 'cf046'],
      ['categoria_descrizione' => 'Antibiotici amminoglucosidi','id_categoria' => 'cf047'],
      ['categoria_descrizione' => 'Antibiotici beta-lattamici, penicillina','id_categoria' => 'cf048'],
      ['categoria_descrizione' => 'Antibiotici citotossici e sostanze correlate','id_categoria' => 'cf049'],
      ['categoria_descrizione' => 'Antibiotici per uso topico','id_categoria' => 'cf050'],
      ['categoria_descrizione' => 'Antidepressivi','id_categoria' => 'cf051'],
      ['categoria_descrizione' => 'Antiemetici e antinausea','id_categoria' => 'cf052'],
      ['categoria_descrizione' => 'Antiepilettici','id_categoria' => 'cf053'],
      ['categoria_descrizione' => 'Antifibrinolitici','id_categoria' => 'cf054'],
      ['categoria_descrizione' => 'Antifungini per uso topico','id_categoria' => 'cf055'],
      ['categoria_descrizione' => 'Antiglaucoma preparazioni e miotici','id_categoria' => 'cf056'],
      ['categoria_descrizione' => 'Anti-infettivi','id_categoria' => 'cf057'],
      ['categoria_descrizione' => 'Anti-infettivi intestinali','id_categoria' => 'cf058'],
      ['categoria_descrizione' => 'Antimalarici','id_categoria' => 'cf059'],
      ['categoria_descrizione' => 'Antimetaboliti','id_categoria' => 'cf060'],
      ['categoria_descrizione' => 'Antimicotici per uso sistemico','id_categoria' => 'cf061'],
      ['categoria_descrizione' => 'Antipropulsivi','id_categoria' => 'cf062'],
      ['categoria_descrizione' => 'Antipsicotici','id_categoria' => 'cf063'],
      ['categoria_descrizione' => 'Antipsoriasi per uso topico','id_categoria' => 'cf064'],
      ['categoria_descrizione' => 'Antistaminici per uso sistemico','id_categoria' => 'cf065'],
      ['categoria_descrizione' => 'Belladonna e derivati','id_categoria' => 'cf066'],
      ['categoria_descrizione' => 'Calcioantagonisti selettivi con prevalente effetto vascolare','id_categoria' => 'cf067'],
      ['categoria_descrizione' => 'Chemioterapici per uso topico','id_categoria' => 'cf068'],
      ['categoria_descrizione' => 'Cicatrizzanti','id_categoria' => 'cf069'],
      ['categoria_descrizione' => 'Contraccettivi ormonali a uso sistemico','id_categoria' => 'cf070'],
      ['categoria_descrizione' => 'Corticosteroidi per uso sistemico, semplici','id_categoria' => 'cf071'],
      ['categoria_descrizione' => 'Corticosteroidi, semplici','id_categoria' => 'cf072'],
      ['categoria_descrizione' => 'Decongestionanti e antiallergici','id_categoria' => 'cf073'],
      ['categoria_descrizione' => 'Decongestionanti nasali e altre preparazioni nasali per uso topico','id_categoria' => 'cf074'],
      ['categoria_descrizione' => 'Digestivi, inclusi gli enzimi','id_categoria' => 'cf075'],
      ['categoria_descrizione' => 'Diuretici ad azione diuretica ampia','id_categoria' => 'cf076'],
      ['categoria_descrizione' => 'Diuretici risparmiatori di potassio','id_categoria' => 'cf077'],
      ['categoria_descrizione' => 'Enzimi','id_categoria' => 'cf078'],
      ['categoria_descrizione' => 'Espettoranti, escluse le associazioni con antitussivi','id_categoria' => 'cf079'],
      ['categoria_descrizione' => 'Estrogeni','id_categoria' => 'cf080'],
      ['categoria_descrizione' => 'Farmaci alchilanti','id_categoria' => 'cf081'],
      ['categoria_descrizione' => 'Farmaci anti demenza','id_categoria' => 'cf082'],
      ['categoria_descrizione' => 'Farmaci antitrombotici','id_categoria' => 'cf083'],
      ['categoria_descrizione' => 'Farmaci antivirali ad azione diretta','id_categoria' => 'cf084'],
      ['categoria_descrizione' => 'Farmaci beta bloccanti','id_categoria' => 'cf085'],
      ['categoria_descrizione' => 'Farmaci che agiscono sulla struttura e mineralizzazione delle ossa','id_categoria' => 'cf086'],
      ['categoria_descrizione' => 'Farmaci che riducono la glicemia, escluse le insuline','id_categoria' => 'cf087'],
      ['categoria_descrizione' => 'Farmaci intestinali anti-infiammatori','id_categoria' => 'cf088'],
      ['categoria_descrizione' => 'Farmaci malattie gastrointestinali funzionali','id_categoria' => 'cf089'],
      ['categoria_descrizione' => 'Farmaci per il trattamento della tubercolosi','id_categoria' => 'cf090'],
      ['categoria_descrizione' => 'Farmaci per l\'ulcera peptica e la malattia da reflusso gastroesofageo (GERD)','id_categoria' => 'cf091'],
      ['categoria_descrizione' => 'Farmaci usati nei disturbi da dipendenza','id_categoria' => 'cf092'],
      ['categoria_descrizione' => 'Farmaci usati nell\'ipertrofia prostatica benigna','id_categoria' => 'cf093'],
      ['categoria_descrizione' => 'Glicosidi cardiaci','id_categoria' => 'cf094'],
      ['categoria_descrizione' => 'Gonadotropine e altri simulatori dell\'ovulazione','id_categoria' => 'cf095'],
      ['categoria_descrizione' => 'Immunoglobuline','id_categoria' => 'cf096'],
      ['categoria_descrizione' => 'Immunosoppressori','id_categoria' => 'cf097'],
      ['categoria_descrizione' => 'Immunostimolanti','id_categoria' => 'cf098'],
      ['categoria_descrizione' => 'Insuline e analoghi','id_categoria' => 'cf099'],
      ['categoria_descrizione' => 'Ipnotici e sedativi','id_categoria' => 'cf100'],
      ['categoria_descrizione' => 'J01M Chinoloni antibiotici','id_categoria' => 'cf101'],
      ['categoria_descrizione' => 'Lassativi','id_categoria' => 'cf102'],
      ['categoria_descrizione' => 'Macrolidi, lincosamidi e streptogrammine','id_categoria' => 'cf103'],
      ['categoria_descrizione' => 'Mezzi di contrasto per la risonanza magnetica','id_categoria' => 'cf104'],
      ['categoria_descrizione' => 'Mezzi di contrasto per ultrasuoni','id_categoria' => 'cf105'],
      ['categoria_descrizione' => 'Oppioidi','id_categoria' => 'cf106'],
      ['categoria_descrizione' => 'Ormoni del lobo pituitario anteriore e analoghi','id_categoria' => 'cf107'],
      ['categoria_descrizione' => 'Ormoni e sostanze correlate','id_categoria' => 'cf108'],
      ['categoria_descrizione' => 'Ormoni ipotalamici','id_categoria' => 'cf109'],
      ['categoria_descrizione' => 'Ormoni paratidei ed analoghi','id_categoria' => 'cf110'],
      ['categoria_descrizione' => 'Preparati a base di Ferro','id_categoria' => 'cf111'],
      ['categoria_descrizione' => 'Preparati Antiobesità, esclusi i prodotti per la dieta','id_categoria' => 'cf112'],
      ['categoria_descrizione' => 'Preparazioni antiacne per uso topico','id_categoria' => 'cf113'],
      ['categoria_descrizione' => 'Preparazioni antiemicrania','id_categoria' => 'cf114'],
      ['categoria_descrizione' => 'Preparazioni antigotta','id_categoria' => 'cf115'],
      ['categoria_descrizione' => 'Preparazioni antivertigini','id_categoria' => 'cf116'],
      ['categoria_descrizione' => 'Preparazioni stomatologiche','id_categoria' => 'cf117'],
      ['categoria_descrizione' => 'Procinetici','id_categoria' => 'cf118'],
      ['categoria_descrizione' => 'Prodotti anti infiammatori e antireumatici, non steroidei','id_categoria' => 'cf119'],
      ['categoria_descrizione' => 'Progestina','id_categoria' => 'cf120'],
      ['categoria_descrizione' => 'Progestina ed estrogeni in combinazione','id_categoria' => 'cf121'],
      ['categoria_descrizione' => 'Psicostimolanti, agenti usati per l\'ADHD e nootropici','id_categoria' => 'cf122'],
      ['categoria_descrizione' => 'Rilassanti muscolari, agenti ad azione centrale','id_categoria' => 'cf123'],
      ['categoria_descrizione' => 'Rilassanti muscolari, agenti ad azione periferica','id_categoria' => 'cf124'],
      ['categoria_descrizione' => 'Rilevamento dei tumori','id_categoria' => 'cf125'],
      ['categoria_descrizione' => 'Rilevamento di infiammazioni e infezioni','id_categoria' => 'cf126'],
      ['categoria_descrizione' => 'Sedativi della tosse, escluse le combinazioni con espettoranti','id_categoria' => 'cf127'],
      ['categoria_descrizione' => 'Sistema nervoso centrale','id_categoria' => 'cf128'],
      ['categoria_descrizione' => 'Sostanze agenti sulla muscolatura liscia arteriolare','id_categoria' => 'cf129'],
      ['categoria_descrizione' => 'Stimolanti cardiaci esclusi i glicosidi','id_categoria' => 'cf130'],
      ['categoria_descrizione' => 'Terapia per la Bile','id_categoria' => 'cf131'],
      ['categoria_descrizione' => 'Tetracicline','id_categoria' => 'cf132'],
      ['categoria_descrizione' => 'Trattamento palliativo del dolore (sostanze a localizzazione ossea)','id_categoria' => 'cf133'],
      ['categoria_descrizione' => 'Tutti gli altri prodotti terapeutici','id_categoria' => 'cf134'],
      ['categoria_descrizione' => 'Urologici','id_categoria' => 'cf135'],
      ['categoria_descrizione' => 'Vaccini batterici','id_categoria' => 'cf136'],
      ['categoria_descrizione' => 'Vaccini virali','id_categoria' => 'cf137'],
      ['categoria_descrizione' => 'Vaccini virali e batterici','id_categoria' => 'cf138'],
      ['categoria_descrizione' => 'Vasodilatori periferici','id_categoria' => 'cf139'],
      ['categoria_descrizione' => 'Vitamina A e D, includendo associazioni dei due','id_categoria' => 'cf140'],
      ['categoria_descrizione' => 'Vitamina K e altri emostatici','id_categoria' => 'cf141'],
	]);
	}
}