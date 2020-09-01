@extends( 'layouts.app' )
@extends( 'includes.template_head' )
@section( 'pageTitle', 'Anamnesi' )
@section( 'content' )

    <div id="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-8">
                    <h2> Anamnesi </h2>
                </div>
                <div class="col-lg-2" style="text-align:right">
                    <a class="quick-btn" data-toggle="modal" data-target="#Print"><i class="icon-print icon-2x"></i><span>Stampa</span></a>
                </div>
            </div><!--row-->
            <hr/>

            <div class="modal fade" tabindex="-1" role="dialog" id="Print">
                <div class="modal-dialog" role="document" style="width:90%;">
                    <div class="modal-content">

                        @include('pages.anamnesi_print')
                    </div>
                </div>

            </div>


            <!-- script per la manipolazione delle anamnesi familiari-->
            <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js')}}"></script>
            <script src="{{asset('js/formscripts/jquery.js')}}"></script>
            <script src="{{asset('js/formscripts/jquery-ui.js')}}"></script>
            <script type="text/javascript" src="{{ url('/js/formscripts/anamnesi.js') }}"></script>
            <script type="text/javascript" src="{{ url('js/formscripts/modanamfam.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/formscripts/modanamnesifis.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/formscripts/modanamnesipat.js') }}"></script>

            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI FAMILIARE-->
                <div class="col-6">
                    <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                        <input name="input_name" value="Familiare" hidden />
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <div class="panel panel-success">

                                <div class="panel-heading">
                                    <center><h4>Familiare </h4></center>
                                    <!--bottoni per la gestione delle modifiche-->

                                    <div class="btn-group" style="text-align: left;">
                                        <a id="buttonUpdateFam" class="btn btn-success btn-sm btn-line" data-toggle="modal"
                                                data-target="#table_update_anamnesifam"><i class="icon-pencil icon-white"></i>Aggiorna</a>

                                        <button type="submit" class="btn btn-warning btn-sm" id="btn_salvafam"
                                                style="display: none;"><i
                                                    class="icon-save"></i>Salva</button>
                                        <a class="btn btn-danger btn-sm" id="buttonAnnullaFam" style="display: none;"><i
                                                    class="icon-trash"></i> Annulla</a>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>

                                    <textarea class="col-md-12" id="testofam" name="testofam" cols="44" rows="10"
                                              readonly="true"
                                              style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;"
                                              placeholder="qui puoi inserire il tuo testo...">{{ $anamnesiFam->anamnesi_familiare_contenuto }}</textarea>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="col-md-12 smaller" style="color:grey">Ultima modifica effettuata da: {{$user_modifiedAnamfam}} il {{$anamnesiFam->dataAggiornamento ? $anamnesiFam->dataAggiornamento->format('d/m/Y') : ''}}
                                        </div>
                                    </div>
                                </div>

                                <!--bottone che permette le modifiche ANAMNESI FAMILIARE-->
                                <div class="panel-footer" style="text-align:right;">
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!--CHIUSURA ANAMNESI FAMILIARE-->

                <!-- TABELLA RELATIVA ALL'ANAMNESI FISIOLOGICA -->
                <div class="col-6">
                    <form action="#" class="form-horizontal">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <center><h4>Fisiologica</h4></center>
                                    <div class="btn-group" style="text-align: right;">
                                        <button id="btnfisio" class="btn btn-primary btn-sm btn-line" data-toggle="modal"
                                                data-target="#modanamnesifis"><i class="icon-pencil icon-white"></i> Aggiorna
                                        </button>
                                        <button class="btn btn-success btn-sm" style="visibility: hidden;"></i>Salva</button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr></tr>
                                            </thead>


                                            <tbody>
                                            <tr>
                                           <textarea class="col-md-12" id="testofis" name="testofis" cols="44" rows="10"
                                                     readonly="true"
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;">@if($anamnesiFisiologica->tempoParto != null)- Nato da parto: {{$anamnesiFisiologica->tempoParto}},@endif @if($anamnesiFisiologica->tipoParto != null){{$anamnesiFisiologica->tipoParto}}.@endif @if($anamnesiFisiologica->allattamento != null)&#13;- Allattamento: {{$anamnesiFisiologica->allattamento}}@endif @if($anamnesiFisiologica->sviluppoVegRel != null)&#13;- Sviluppo vegetativo e relazionale: {{$anamnesiFisiologica->sviluppoVegRel}}.@endif @if($anamnesiFisiologica->noteInfanzia != null)&#13;- Note infanzia: {{$anamnesiFisiologica->noteInfanzia}}.@endif @if($anamnesiFisiologica->livelloScol != null)&#13;- Livello scolastico: {{$anamnesiFisiologica->livelloScol}}.@endif @if($anamnesiFisiologica->attivitaFisica != null)&#13;- Attività fisica: {{$anamnesiFisiologica->attivitaFisica}}.@endif @if($anamnesiFisiologica->abitudAlim != null)&#13;- Abitudini alimentari: {{$anamnesiFisiologica->abitudAlim}}.@endif @if($anamnesiFisiologica->ritmoSV != null)&#13;- Ritmo sonno veglia: {{$anamnesiFisiologica->ritmoSV}}.@endif @if($anamnesiFisiologica->fumo != null)&#13;- Fumo: {{$anamnesiFisiologica->fumo}}.@endif @if($anamnesiFisiologica->freqFumo != null)&#13;- Frequenza fumo: {{$anamnesiFisiologica->freqFumo}}.@endif @if($anamnesiFisiologica->alcool != null)&#13;- Alcool: {{$anamnesiFisiologica->alcool}}.@endif @if($anamnesiFisiologica->freqAlcool != null)&#13;- Frequenza alcool: {{$anamnesiFisiologica->freqAlcool}}.@endif @if($anamnesiFisiologica->droghe != null)&#13;- Droghe: {{$anamnesiFisiologica->droghe}}.@endif @if($anamnesiFisiologica->freqDroghe != null)&#13;- Frequenza droghe: {{$anamnesiFisiologica->freqDroghe}}.@endif @if($anamnesiFisiologica->noteStileVita != null)&#13;- Note stile di vita: {{$anamnesiFisiologica->noteStileVita}}.@endif @if($anamnesiFisiologica->etaMenarca != null)&#13;- Età menarca: {{$anamnesiFisiologica->etaMenarca}}.@endif @if($anamnesiFisiologica->ciclo != null)&#13;- Ciclo: {{$anamnesiFisiologica->ciclo}}.@endif @if($anamnesiFisiologica->etaMenopausa != null)&#13;- Età menopausa: {{$anamnesiFisiologica->etaMenopausa}}.@endif @if($anamnesiFisiologica->menopausa != null)&#13;- Menopausa: {{$anamnesiFisiologica->menopausa}}.@endif @if($anamnesiFisiologica->noteCicloMes != null)&#13;- Note ciclo mestruale: {{$anamnesiFisiologica->noteCicloMes}}.@endif @if($anamnesiFisiologica->professione != null)&#13;- Professione: {{$anamnesiFisiologica->professione}}.@endif @if($anamnesiFisiologica->noteAttLav != null)&#13;- Note attività lavorative: {{$anamnesiFisiologica->noteAttLav}}.@endif @if($anamnesiFisiologica->alvo != null)&#13;- Alvo: {{$anamnesiFisiologica->alvo}}.@endif @if($anamnesiFisiologica->minzione != null)&#13;- Minzione: {{$anamnesiFisiologica->minzione}}.@endif @if($anamnesiFisiologica->noteAlvoMinz != null)&#13;- Note alvo, minzione: {{$anamnesiFisiologica->noteAlvoMinz}}.@endif</textarea>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="col-md-12 smaller" style="color:grey">Ultima modifica effettuata da: {{$user_modifiedAnamfis}} il {{$anamnesiFisiologica->dataAggiornamento ? $anamnesiFisiologica->dataAggiornamento->format('d/m/Y') : ''}}
                                        </div>
                                    </div>
                                </div>
                                <!--bottone che fa comparire un menu con tutte le voci della FISIOLOGICA-->

                                <div class="panel-footer" style="text-align:right">
                                </div>
                            </div><!--row familiare e fisiologica-->

                        </div>
                    </form>
                </div><!--CHIUSURA ANAMNESI FISIOLOGICA-->
                <!--inner-->

            </div><!--content-->

            <div class="row">

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA REMOTA-->
                <div class="col-6">
                    <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">

                        <input name="input_name" value="PatologicaRemota" hidden />
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <center><h4>Patologica remota</h4></center>
                                    <div class="btn-group" style="text-align: left;">
                                        <!--bottoni per la gestione delle modifiche-->
                                        <button type="submit" class="btn btn-success btn-sm" id="btn_salvapatrem"
                                                style="display: none;"><i
                                                    class="icon-save"></i>Salva</button>
                                        <a class="btn btn-danger btn-sm" id="btn_annullapatrem" style="display: none;"><i
                                                    class="icon-trash"></i> Annulla</a>
                                        <a id="buttonHiddenPatRem" class="btn btn-warning btn-sm btn-line"><i
                                                    class="icon-pencil icon-white"></i>Aggiorna</a>
                                    </div>

                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                    <textarea class="col-md-12" id="testopat" name="testopat" cols="44" rows="10"
                                              readonly="true"
                                              style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;" placeholder="qui puoi inserire il tuo testo...">{{ $anamnesiPatologicaCompleta->anamnesi_remota_contenuto }}</textarea>
                                            </tr>
                                            <!--	<br />-->
                                            <hr/>
                                            <tr>
                                                <strong>Patologie remote raggruppate per Categorie Diagnostiche (MDC):</strong>
                                            </tr>
                                            <hr/>
                                            <tr>
                                                <a id="btnmodrem" class="text-left;" style="cursor: pointer; display: none;"
                                                   data-toggle="modal" data-target="#modanamnesipat">Modifica patologie
                                                    pregresse</a>
                                            </tr>
                                            <tr>
												<div style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;">@foreach($anamnesiPatologicaRemota as $apr) - {!!$apr->codice_descrizione!!} <br/> @endforeach</div>
                                            </tr>
                                            <div class="panel-body;" style="text-align:left">

                                            </div>


                                            </tbody>
                                        </table>
                                        <div class="col-md-12 smaller" style="color:grey">Ultima modifica effettuata da: {{$user_modifiedAnamPatRem}} il {{$anamnesiPatologicaCompleta->dataAggiornamento_anamnesi_remota ? $anamnesiPatologicaCompleta->dataAggiornamento_anamnesi_remota->format('d/m/Y') : ''}}
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-footer" style="text-align:right">
                                </div>
                            </div><!--panel warning-->
                        </div><!--col-md-6-->
                    </form>
                </div><!--CHIUSURA ANAMNESI PATOLOGICA REMOTA-->

                <!-- TABELLA RELATIVA ALL'ANAMNESI PATOLOGICA PROSSIMA-->
                <div class="col-6">
                    <form action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                        <input name="input_name" value="PatologicaProssima" hidden />
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <!--	<div class="panel panel-primary">-->
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <center><h4>Patologica prossima</h4></center>

                                    <!--bottoni per la gestione delle modifiche-->
                                    <div class="btn-group" style="text-align: left;">
                                        <a id="buttonHiddenpp" class="btn btn-danger btn-sm btn-line pull-right"><i
                                                    class="icon-pencil icon-white"></i>Aggiorna</a>
                                        <button class="btn btn-info btn-sm pull-left" id="btnsposta" data-toggle="modal"
                                                data-target="#modansposta"><i
                                                    class="icon-hand-left"></i>
                                            Sposta
                                        </button>

                                        <button type="submit" class="btn btn-success btn-sm" id="btn_salvapp" style="display: none;"><i
                                                    class="icon-save"></i>Salva</button>
                                        <a class="btn btn-warning btn-sm" id="btn_annullapp" style="display: none;"><i
                                                    class="icon-trash"></i> Annulla</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr></tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                           <textarea class="col-md-12" id="testopatpp" name="testopatpp" cols="44"
                                                     rows="10" readonly="true"
                                                     style="resize:none; border: transparent; overflow-y: scroll; max-height: 200px;" placeholder="qui puoi inserire il tuo testo...">{{ $anamnesiPatologicaCompleta->anamnesi_prossima_contenuto }}</textarea>
                                            </tr>
                                            <!-- <br />-->
                                            <hr/>


                                            <tr>
                                                <strong>Patologie prossime raggruppate per Categorie Diagnostiche
                                                    (MDC):</strong>
                                            </tr>
                                            <hr/>
                                            <tr>
                                                <a id="modbtnpp" class="text-left;" style="cursor: pointer; display: none;"
                                                   data-toggle="modal" data-target="#modanamnesipatrec">Modifica patologie
                                                    recenti</a>
                                            </tr>

                                            <tr>

                                               <div style="resize:none; border: transparent; overflow-y: scroll; font-size: small; height: 20%;">
                                                @foreach($anamnesiPatologicaProssima as $app) - {!!$app->codice_descrizione!!} <br/> @endforeach
                                                </div>

                                            </tr>
                                            <!--<hr />-->
                                            <div class="panel-body;" style="text-align:left">

                                            </div>


                                            </tbody>
                                        </table>
                                        <div class="col-md-12 smaller" style="color:grey">Ultima modifica effettuata da: {{$user_modifiedAnamPatPros}} il {{$anamnesiPatologicaCompleta->dataAggiornamento_anamnesi_prossima ? $anamnesiPatologicaCompleta->dataAggiornamento_anamnesi_prossima->format('d/m/Y') : ''}}
                                        </div>
                                    </div>
                                </div> <!--panel-body-->
                                <!--bottone che apre il pannello per le modifiche informazioni ANAMNESI PATOLOGICA REMOTA-->


                                <div class="panel-footer clearfix">


                                </div>
                            </div> <!--panel danger-->
                        </div>
                    </form><!--col-md-6 patologica prossima-->
                </div><!--CHIUSURA ANAMNESI PATOLOGICA PROSSIMA-->
            </div> <!--row-prossima e remota--->




            <!-- MODAL PER LE ANAMNESI-->

            <!-- MODAL per l'inserimento di una anamnesi familiare -->
            <div class="modal fade" id="table_add_anamnesifam" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    id="chiudianamnesifam">&times;
                            </button>
                            <h4 class="modal-title" id="H2">Aggiungi anamnesi familiare FHIR</h4>
                        </div>

                        <br>

                        <form id="formA" action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                            <input name="input_name" value="Parente" hidden />
                            {{csrf_field()}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Nome componente:</label>
                                    <div class="col-lg-6">
                                        <input id="nome_componenteA" name="nome_componente" type="text" class="form-control" required="true"/>
                                    </div>
                                </div>
                            </div>

                            <input name="input_surname" value="cognomeParente" hidden />
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Cognome componente:</label>
                                    <div class="col-lg-6">
                                        <input id="cognome_componenteA" name="cognome_componente" type="text" class="form-control" required="true"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Grado parentela:</label>
                                    <div class="col-lg-6">
                                        <select id="gradoParentela" name="grado_parentela" class="form-control" required="true">
                                            <option value="fratello">Fratello</option>
                                            <option value="sorella">Sorella</option>
                                            <option value="genitore">Genitore</option>
                                            <option value="nonno">Nonno/a</option>
                                            <option value="zio">Zio/a</option>
                                            <option value="nipote">Nipote</option>
                                            <option value="cugino">Cugino/a</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Sesso:</label>
                                    <div class="col-lg-6">
                                        <select id="sessoA" name="sesso" class="form-control" required="true">
                                            <option selected value="M">Uomo</option>
                                            <option value="F">Donna</option>
                                            <option value="O">Altro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Anni:</label>
                                    <div class="col-lg-6">
                                        <input id="anni_componenteA" type="text" name="età" class="form-control" required="true"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data decesso:</label>
                                    <div class="col-lg-6">
                                        <input type="date" name="data_decesso" id="data_morteA"
                                               class="form-control col-lg-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Annotazioni:</label>
                                    <div class="col-lg-6">
                                        <textarea id="annotazioni" name="annotazioni" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="btn" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-primary" id="concludiA">Aggiungi</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div><!-- chiusura modal per l'aggiunta della nuova anamnesi -->



            <!-- modal per l'aggiornamento delle anamnesi familiari -->
            <div class="modal fade" id="table_update_anamnesifam" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    id="chiudianamnesifam">&times;
                            </button>
                            <h4 class="modal-title" id="H2">Aggiorna anamnesi familiare FHIR</h4>
                        </div>
                        <br>


                        <!-- tabella per la visualizzazione delle anamnesi familiari -->


                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" id="tableAnamnesiFam">
                                    <thead>
                                    <tr>
                                        <th>
                                            Componente
                                            <button id="buttonAdd" class="btn btn-default btn-success"
                                                    data-toggle="modal"
                                                    data-target="#table_add_anamnesifam" data-dismiss="modal"><i
                                                        class="icon-plus"></i></button>
                                        </th>
                                        <th>Sesso</th>
                                        <th>Anni</th>
                                        <th>Annotazioni</th>
                                        <th>Opzioni</th>
                                        <th>Patologie</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($parente as $p)
                                        <tr>
                                            <td>{{$p->nome}} {{$p->cognome}}</td>
                                            <td>{{$p->sesso}}</td>
                                            <td>{{$p->eta}}</td>
                                            <td>{{$p->annotazioni}}</td>
                                            @if($p->id_paziente == $userid)
                                                <td>
                                                    <div id="row">
                                                        <div id="col-lg-12">
                                                            <div id="btn-group">
                                                                <form action="{{ route('Delete', ['id' => $p->id_parente]) }}" method="post"
                                                                      class="form-horizontal">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('DELETE') }}
                                                                    <input name="input_name" value="DeleteParente" hidden />
                                                                    <input class="form-control hidden" type="text" name="ids[]" value="{{ $p->id_parente }}" disabled>
                                                                    <button class="btn btn-primary" data-toggle="modal" id="{{$p->id_parente}}"
                                                                            data-target="#edit-{{ $p->id_parente }}" data-dismiss="modal"><i class="icon-pencil icon-white"></i></button>
                                                                    <button type="submit" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div id="row">
                                                        <div id="col-lg-12">
                                                            <div id="btn-group">

                                                                    {{csrf_field()}}
                                                                    <input name="input_name" value="showPtParente" hidden />
                                                                    <input class="form-control hidden" type="text" name="ids[]" value="{{ $p->id_parente }}" disabled>
                                                                    <button class="btn btn-warning" id="{{$p->nome}} {{$p->cognome}}" value="{{$p->id_parente}}"
                                                                            onclick="showPtParente(this)"><i class="icon-book icon-white"></i></button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div><!--table responsive-->


                        </div><!--PANEL BODY -->
                    </div>
                </div>
            </div>

            <!-- modal per la visualizzazione delle patologie di un parente -->

            <div class="col-md-4">
                <div class="modal fade" id="showPtParente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" id="modShowPtParente">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>

                            </div>

                                <div class="modal-body" id="showPtParenteDiv">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button id="addPtParenteButton" class="btn btn-primary" onclick="addPtParente(this)">Aggiungi</button>
                                </div>


                        </div>
                    </div>
                </div>
            </div>

            <!--MODAL AGGIUNGI PATOLOGIE PARENTE-->
            <div class="col-md-4">
                <div class="modal fade" id="addPtParente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie parente</h4>
                            </div>

                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie - 1/4</label>
                                    @foreach($icd9groupcode as $g)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="icd9groupcodePtParente" value="{{$g->codice}}"> {{$g->gruppo_descrizione}}</label>

                                        </div>
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button id="addPtParenteButton2" onclick="addPtParente2(this)" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

            <div class="modal fade" id="addPtParente2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie parente</h4>
                            </div>

                                <div class="modal-body" id="modPar2">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button id="addPtParenteButton3" onclick="addPtParente3(this)" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addPtParente3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie parente</h4>
                            </div>

                                <div class="modal-body" id="modPar3">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button id="addPtParenteButton4" onclick="addPtParente4(this)" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addPtParente4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie parente</h4>
                            </div>

                                <div class="modal-body" id="modPar4">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button id="addPtParenteButton5" onclick="addPtParenteDB(this)" class="btn btn-primary">Salva
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>
            </div> <!--CHIUSURA MODAL AGGIUNGI PATOLOGIE PARENTE-->

            @foreach($parente as $p)
                <form action="{{ route('Update', ['id' => $p->id_parente]) }}" method="post"
                      class="form-horizontal">
                    {{csrf_field()}}
                    {{ method_field('PATCH') }}
                    <input name="input_name" value="UpdateParente" hidden />
                    <input class="form-control hidden" type="text" name="ids[]" value="{{ $p->id_parente }}" disabled>
                    <div class="modal fade" id="edit-{{ $p->id_parente }}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                            id="chiudianamnesifam">&times;
                                    </button>
                                    <h4 class="modal-title" id="H2">Modifica anamnesi familiare FHIR</h4>
                                </div>

                                <br>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Nome componente:</label>
                                        <div class="col-lg-6">
                                            <input id="nome_componenteA" name="nome_componente" type="text"
                                                   class="form-control" value="{{$p->nome}}" required="true"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Cognome componente:</label>
                                        <div class="col-lg-6">
                                            <input id="cognome_componenteA" name="cognome_componente" type="text"
                                                   class="form-control" value="{{$p->cognome}}" required="true"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Grado :</label>
                                        <div class="col-lg-6">
                                            <select id="gradoParentela" name="grado_parentela" class="form-control" required="true">
                                                <option @if( $p->grado_parentela == "fratello") value="{{$p->grado_parentela}}" selected="selected" @else value="fratello" @endif>Fratello</option>
                                                <option @if( $p->grado_parentela == "sorella") value="{{$p->grado_parentela}}" selected="selected" @else value="sorella" @endif>Sorella</option>
                                                <option @if( $p->grado_parentela == "genitore") value="{{$p->grado_parentela}}" selected="selected" @else value="genitore" @endif>Genitore</option>
                                                <option @if( $p->grado_parentela == "nonno") value="{{$p->grado_parentela}}" selected="selected" @else value="nonno" @endif>Nonno/a</option>
                                                <option @if( $p->grado_parentela == "zio") value="{{$p->grado_parentela}}" selected="selected" @else value="zio" @endif>Zio/a</option>
                                                <option @if( $p->grado_parentela == "nipote") value="{{$p->grado_parentela}}" selected="selected" @else value="nipote" @endif>Nipote</option>
                                                <option @if( $p->grado_parentela == "cugino") value="{{$p->grado_parentela}}" selected="selected" @else value="cugino" @endif>Cugino/a</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Sesso:</label>
                                        <div class="col-lg-6">
                                            <select id="sessoA" name="sesso" class="form-control" required="true">
                                                <option @if( $p->sesso == "M") value="{{$p->sesso}}" selected="selected" @else value="M" @endif>Uomo</option>
                                                <option @if( $p->sesso == "F") value="{{$p->sesso}}" selected="selected" @else value="F" @endif>Donna</option>
                                                <option @if( $p->sesso == "O") value="{{$p->sesso}}" selected="selected" @else value="O" @endif>Altro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Anni:</label>
                                        <div class="col-lg-6">
                                            <input  value="{{$p->eta}}"  id="anni_componenteA" type="text" name="età" class="form-control" required="true"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Data decesso:</label>
                                        <div class="col-lg-6">
                                            <input type="date" name="data_decesso" value="{{$p->data_decesso}}" id="data_morteA"
                                                   class="form-control col-lg-6"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4"> Annotazioni:</label>
                                        <div class="col-lg-6">
                                            <textarea id="annotazioni" name="annotazioni"
                                                      class="form-control">{{$p->annotazioni}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="btn" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" class="btn btn-primary" id="concludiA">Modifica</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        @endforeach <!-- chiusura modal per l'aggiornamento delle anamnesi familiari -->




            <!-- MODAL MODIFICA ANAMNESI FISIOLOGICA -->
            <div class="col-lg-12">



                <div class="modal fade" id="modanamnesifis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" style="width: 60%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica informazioni</h4>
                            </div>

                            <form id="modpatinfo" action="{{ action('AnamnesiController@store') }}" method="post" class="form-horizontal">
                                {{csrf_field()}}
                                <input name="input_name" value="Fisiologica" hidden />
                                <div class="modal-body">
                                    <div class="table-responsive">

                                        <div class="table-bordered">


                                            <div class="accordion ac" id="accordionUtility">
                                                <div class="accordion-group">
                                                    <div class="accordion-heading centered">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-3">

                                                                    <a id="inf" class="accordion-toggle"
                                                                       data-toggle="collapse" href="#infanzia">
                                                                        <h5><i class="icon-pencil icon-white"></i>Infanzia
                                                                        </h5>
                                                                    </a>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <a id="inf2" class="accordion-toggle"
                                                                       data-toggle="collapse" data-parent="#accordion"
                                                                       href="#scolaro">
                                                                        <h5><i class="icon-pencil icon-white"></i>Scolarit&#224;
                                                                        </h5>
                                                                    </a>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <a id="inf3" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#stilevita">
                                                                        <h5><i class="icon-pencil icon-white"></i>Stile
                                                                            di
                                                                            vita</h5>
                                                                    </a>
                                                                </div>
                                                                @if($user->paziente_sesso == "female" or $user->paziente_sesso == "F")
                                                                    <div class="col-lg-3">
                                                                        <a id="inf4" class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#accordionUtility"
                                                                           href="#gravidanze">
                                                                            <h5><i class="icon-pencil icon-white"></i>Gravidanze
                                                                            </h5>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- INFANZIA ---------------------->
                                                            <div id="infanzia" class="accordion-body collapse">

                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header>
                                                                                    <h5>Infanzia</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="submit"
                                                                                                       value="Salva"
                                                                                                       id="prova"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullainfanzia"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-3"
                                                                                               for="parto">Nato da
                                                                                            parto:</label>
                                                                                        <div class="col-lg-4">
                                                                                            <select class="form-control"
                                                                                                    name="parto"
                                                                                                    id="parto" >
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif></option>
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "pretermine") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif id="pretermine">
                                                                                                    pretermine
                                                                                                </option>
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "termine") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif id="termine">
                                                                                                    termine
                                                                                                </option>
                                                                                                <option  @if( $anamnesiFisiologica->tempoParto == "post-termine") value="{{$anamnesiFisiologica->tempoParto}}" selected="selected" @endif id="post-termine">
                                                                                                    post-termine
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-5">
                                                                                            <select class="form-control"
                                                                                                    name="tipoparto"
                                                                                                    id="tipoparto">
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "naturale eutocico") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif id="eutocico">
                                                                                                    naturale
                                                                                                    eutocico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "naturale distocito") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif id="distocico">
                                                                                                    naturale
                                                                                                    distocito
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoParto == "operatorio cesareo") value="{{$anamnesiFisiologica->tipoParto}}" selected="selected" @endif id="cesareo">
                                                                                                    operatorio
                                                                                                    cesareo
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-4"
                                                                                               for="allattamento">Allattamento:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <select class="form-control"
                                                                                                    name="allattamento"
                                                                                                    id="allattamento">
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "materno") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif id="materno">
                                                                                                    materno
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "artificiale") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif id="artificiale">
                                                                                                    artificiale
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->allattamento == "mercenario") value="{{$anamnesiFisiologica->allattamento}}" selected="selected" @endif id="mercenario">
                                                                                                    mercenario
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-4"
                                                                                               for="sviluppoVegRel">Sviluppo
                                                                                            vegetativo e
                                                                                            relazionale:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <select class="form-control"
                                                                                                    name="sviluppoVegRel"
                                                                                                    id="sviluppoVegRel">
                                                                                                <option @if( $anamnesiFisiologica->sviluppoVegRel == "") value="{{$anamnesiFisiologica->sviluppoVegRel}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->sviluppoVegRel == "normale") value="{{$anamnesiFisiologica->sviluppoVegRel}}" selected="selected" @endif id="normale">
                                                                                                    normale
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->sviluppoVegRel == "patologico") value="{{$anamnesiFisiologica->sviluppoVegRel}}" selected="selected" @endif id="patologico">
                                                                                                    patologico
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="noteinfanzia"
                                                                                               class="control-label col-lg-4">Note
                                                                                            infanzia:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="noteinfanzia"
                                                                                                      name="noteinfanzia"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteInfanzia}}</textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- CHIUSURA INFANZIA ---------------------->


                                                            <!-- SCOLARITA' ---------------------->
                                                            <div id="scolaro" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Scolarit&#224;</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="submit"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvascolarita"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullascolarita"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-4"
                                                                                               for="livelloScol">Livello
                                                                                            scolastico:</label>
                                                                                        <div class="col-lg-8">

                                                                                            <select class="form-control"
                                                                                                    name="livelloScol"
                                                                                                    id="livelloScol">
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "analfabeta") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="analfabeta">
                                                                                                    analfabeta
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "elementare") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="elementare">
                                                                                                    elementare
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "medie-inferiori") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="medie-inferiori">
                                                                                                    medie-inferiori
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "diploma") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="diploma">
                                                                                                    diploma
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->livelloScol == "laurea") value="{{$anamnesiFisiologica->livelloScol}}" selected="selected" @endif id="laurea">
                                                                                                    laurea
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--CHIUSURA SCOLARITA'-->

                                                            <!-- STILE DI VITA ---------------------->
                                                            <div id="stilevita" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Stile di vita</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="submit"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvavita"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullavita"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>

                                                                                    <div class="form-group">
                                                                                        <label for="attivitaFisica"
                                                                                               class="control-label col-lg-3">Attivit&#224;
                                                                                            fisica:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <select class="form-control"
                                                                                                    name="attivitaFisica"
                                                                                                    id="attivitaFisica">
                                                                                                <option @if( $anamnesiFisiologica->attivitaFisica == "") value="{{$anamnesiFisiologica->attivitaFisica}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->attivitaFisica == "sedentario (distanza percorsa giornalmente a piedi inferiore a un km)") value="{{$anamnesiFisiologica->attivitaFisica}}" selected="selected" @endif id="af1">
                                                                                                    sedentario (distanza percorsa giornalmente a piedi inferiore a un km)
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->attivitaFisica == "moderata (attivita' giornaliera superiore a un km, ma inferiore a mezzora di camminata veloce)") value="{{$anamnesiFisiologica->attivitaFisica}}" selected="selected" @endif id="af2">
                                                                                                    moderata (attivita' giornaliera superiore a un km, ma inferiore a mezzora di camminata veloce)
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->attivitaFisica == "adeguata (equivalente o superiore a mezzora di camminata veloce)") value="{{$anamnesiFisiologica->attivitaFisica}}" selected="selected" @endif id="af3">
                                                                                                    adeguata (equivalente o superiore a mezzora di camminata veloce)
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->attivitaFisica == "sportiva (tre-sei ore di allenamento settimanali)") value="{{$anamnesiFisiologica->attivitaFisica}}" selected="selected" @endif id="af4">
                                                                                                    sportiva (tre-sei ore di allenamento settimanali)
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->attivitaFisica == "intensa (oltre sei ore di allenamento settimanali)") value="{{$anamnesiFisiologica->attivitaFisica}}" selected="selected" @endif id="af5">
                                                                                                    intensa (oltre sei ore di allenamento settimanali)
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="abitudAlim"
                                                                                               class="control-label col-lg-3">Abitudini
                                                                                            alimentari:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea style= "height: 35px" id="abitudAlim"
                                                                                                      name="abitudAlim"
                                                                                                      class="form-control">{{$anamnesiFisiologica->abitudAlim}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="ritmoSV"
                                                                                               class="control-label col-lg-3">Ritmo
                                                                                            sonno veglia:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <textarea style= "height: 35px" id="ritmoSV"
                                                                                                      name="ritmoSV"
                                                                                                      class="form-control">{{$anamnesiFisiologica->ritmoSV}}</textarea>
                                                                                        </div>
                                                                                        <label for="stress"
                                                                                               class="control-label col-lg-3">Stress fisico e psicologico:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <select class="form-control"
                                                                                                    name="stress"
                                                                                                    id="stress">
                                                                                                <option @if( $anamnesiFisiologica->stress == "") value="{{$anamnesiFisiologica->stress}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->stress == "no") value="{{$anamnesiFisiologica->stress}}" selected="selected" @endif id="nostress">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->stress == "si") value="{{$anamnesiFisiologica->stress}}" selected="selected" @endif id="sistress">
                                                                                                    si
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="form-group">
                                                                                        <label for="fumo"
                                                                                               class="control-label col-lg-3">Fumo:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="fumo"
                                                                                                    id="fumo">
                                                                                                <option @if( $anamnesiFisiologica->fumo == "") value="{{$anamnesiFisiologica->fumo}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "no") value="{{$anamnesiFisiologica->fumo}}" selected="selected" @endif id="nofumo">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "si") value="{{$anamnesiFisiologica->fumo}}" selected="selected" @endif id="sifumo">
                                                                                                    si
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <label for="dosiFumo"
                                                                                               class="control-label col-lg-3">Sigarette al gg:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <input type="text"
                                                                                                   name="dosiFumo"
                                                                                                   id="dosiFumo"
                                                                                                   class="form-control col-lg-6"
                                                                                                   value="{{$anamnesiFisiologica->dosiFumo}}"
                                                                                                   type="number" min="0" step="1"/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="inizioFumo"
                                                                                               class="control-label col-lg-3">Inizio:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <input type="date"
                                                                                                   name="inizioFumo"
                                                                                                   id="inizioFumo"
                                                                                                   class="form-control col-lg-6"
                                                                                                   @if( isset($anamnesiFisiologica->dataInizioFumo)) value="{{$anamnesiFisiologica->dataInizioFumo->format('Y-m-d')}}" @endif/>
                                                                                        </div>
                                                                                        <label for="fineFumo"
                                                                                               class="control-label col-lg-2">Fine:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <input type="date"
                                                                                                   name="fineFumo"
                                                                                                   id="fineFumo"
                                                                                                   class="form-control col-lg-6"
                                                                                                   @if( isset($anamnesiFisiologica->dataFineFumo))
                                                                                                   value="{{$anamnesiFisiologica->dataFineFumo->format('Y-m-d')}}" @endif/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="form-group">
                                                                                        <label for="alcool"
                                                                                               class="control-label col-lg-2">Alcool:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <select class="form-control"
                                                                                                    name="alcool"
                                                                                                    id="alcool">
                                                                                                <option @if( $anamnesiFisiologica->alcool == "") value="{{$anamnesiFisiologica->alcool}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->alcool == "no") value="{{$anamnesiFisiologica->alcool}}" selected="selected" @endif id="noalcool">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->fumo == "si") value="{{$anamnesiFisiologica->alcool}}" selected="selected" @endif id="sialcool">
                                                                                                    si
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <label for="dosiAlcool"
                                                                                               class="control-label col-lg-2">Bicchieri al gg:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <input type="text"
                                                                                                   name="dosiAlcool"
                                                                                                   id="dosiAlcool"
                                                                                                   class="form-control col-lg-6"
                                                                                                   value="{{$anamnesiFisiologica->dosiAlcool}}"
                                                                                                   type="number" min="0" step="1"/>
                                                                                        </div>
                                                                                        <label for="tipoAlcool"
                                                                                               class="control-label col-lg-1">Tipo:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="tipoAlcool"
                                                                                                    id="tipoAlcool">
                                                                                                <option @if( $anamnesiFisiologica->tipoAlcool == "") value="{{$anamnesiFisiologica->tipoAlcool}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->tipoAlcool == "Vino") value="{{$anamnesiFisiologica->tipoAlcool}}" selected="selected" @endif id="vino">
                                                                                                    Vino
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoAlcool == "Birra") value="{{$anamnesiFisiologica->tipoAlcool}}" selected="selected" @endif id="birra">
                                                                                                    Birra
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoAlcool == "Superalcolico") value="{{$anamnesiFisiologica->tipoAlcool}}" selected="selected" @endif id="superalcolico">
                                                                                                    Superalcolico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoAlcool == "Altro") value="{{$anamnesiFisiologica->tipoAlcool}}" selected="selected" @endif id="altroAlcool">
                                                                                                    Altro
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                        <div class="form-group">
                                                                                        <label for="inizioAlcool"
                                                                                               class="control-label col-lg-3">Inizio:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <input type="date"
                                                                                                   name="inizioAlcool"
                                                                                                   id="inizioAlcool"
                                                                                                   class="form-control col-lg-6"
                                                                                                   @if( isset($anamnesiFisiologica->dataInizioAlcool))
                                                                                                   value="{{$anamnesiFisiologica->dataInizioAlcool->format('Y-m-d')}}" @endif/>
                                                                                        </div>
                                                                                        <label for="fineAlcool"
                                                                                               class="control-label col-lg-2">Fine:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <input type="date"
                                                                                                   name="fineAlcool"
                                                                                                   id="fineAlcool"
                                                                                                   class="form-control col-lg-6"
                                                                                                   @if( isset($anamnesiFisiologica->dataFineAlcool))
                                                                                                   value="{{$anamnesiFisiologica->dataFineAlcool->format('Y-m-d')}}" @endif/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="form-group">
                                                                                        <label for="droghe"
                                                                                               class="control-label col-lg-2">Droghe:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <select class="form-control"
                                                                                                    name="droghe"
                                                                                                    id="droghe">
                                                                                                <option @if( $anamnesiFisiologica->droghe == "") value="{{$anamnesiFisiologica->droghe}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->droghe == "no") value="{{$anamnesiFisiologica->droghe}}" selected="selected" @endif id="nodroghe">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->droghe == "si") value="{{$anamnesiFisiologica->droghe}}" selected="selected" @endif id="sidroghe">
                                                                                                    si
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <label for="dosiDroghe"
                                                                                               class="control-label col-lg-2">Milligrammi al gg:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <input type="text"
                                                                                                   name="dosiDroghe"
                                                                                                   id="dosiDroghe"
                                                                                                   class="form-control col-lg-6"
                                                                                                   value="{{$anamnesiFisiologica->dosiDroghe}}"
                                                                                                   type="number" min="0" step="1"/>
                                                                                        </div>
                                                                                        <label for="tipoDroghe"
                                                                                               class="control-label col-lg-1">Tipo:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="tipoDroghe"
                                                                                                    id="tipoDroghe">
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "Cocaina") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="cocainaDroghe">
                                                                                                    Cocaina
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "Anfetamina") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="anfetaminaDroghe">
                                                                                                    Anfetamina
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "LSD") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="lsdDroghe">
                                                                                                    LSD
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "Cannabinoidi") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="cannabinoidiDroghe">
                                                                                                    Cannabinoidi
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "Metadone") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="metadoneDroghe">
                                                                                                    Metadone
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "MDMA") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="mdmaDroghe">
                                                                                                    MDMA
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->tipoDroghe == "Altro") value="{{$anamnesiFisiologica->tipoDroghe}}" selected="selected" @endif id="altroDroghe">
                                                                                                    Altro
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="inizioDroghe"
                                                                                               class="control-label col-lg-3">Inizio:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <input type="date"
                                                                                                   name="inizioDroghe"
                                                                                                   id="inizioDroghe"
                                                                                                   class="form-control col-lg-6"
                                                                                                   @if( isset($anamnesiFisiologica->dataInizioDroghe))
                                                                                                   value="{{$anamnesiFisiologica->dataInizioDroghe->format('Y-m-d')}}" @endif/>
                                                                                        </div>
                                                                                        <label for="fineDroghe"
                                                                                               class="control-label col-lg-2">Fine:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <input type="date"
                                                                                                   name="fineDroghe"
                                                                                                   id="fineDroghe"
                                                                                                   class="form-control col-lg-6"
                                                                                                   @if( isset($anamnesiFisiologica->dataFineDroghe))
                                                                                                   value="{{$anamnesiFisiologica->dataFineDroghe->format('Y-m-d')}}" @endif/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>

                                                                                    <div class="form-group">
                                                                                        <label for="caffeina"
                                                                                               class="control-label col-lg-3">Caffeina:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="caffeina"
                                                                                                    id="caffeina">
                                                                                                <option @if( $anamnesiFisiologica->caffeina == "") value="{{$anamnesiFisiologica->caffeina}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->caffeina == "no") value="{{$anamnesiFisiologica->caffeina}}" selected="selected" @endif id="nocaffeina">
                                                                                                    no
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->caffeina == "si") value="{{$anamnesiFisiologica->caffeina}}" selected="selected" @endif id="sicaffeina">
                                                                                                    si
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <label for="dosiCaffeina"
                                                                                               class="control-label col-lg-3">Tazzine al gg:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <input type="text"
                                                                                                   name="dosiCaffeina"
                                                                                                   id="dosiCaffeina"
                                                                                                   class="form-control col-lg-6"
                                                                                                   value="{{$anamnesiFisiologica->dosiCaffeina}}"
                                                                                                   type="number" min="0" step="1"/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="form-group">
                                                                                        <label for="noteStileVita"
                                                                                               class="control-label col-lg-3">Note:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="noteStileVita"
                                                                                                      name="noteStileVita"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteStileVita}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--STILE DI VITA------------>



                                                            <!-- GRAVIDANZE ---------------------->
                                                            <div id="gravidanze" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Gravidanze</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><a id="btnsalva"><i
                                                                                                            class="icon-save"
                                                                                                            style="visibility: hidden;"></i></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>

                                                                                    <div class="table-responsive">
                                                                                        <table id="tbl"
                                                                                               class="table table-striped table-bordered table-hover">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th>Et&#224;</th>
                                                                                                <th>Inizio</th>
                                                                                                <th>Fine</th>
                                                                                                <th>Esito</th>
                                                                                                <th>Sesso</th>
                                                                                                <th>Note</th>
                                                                                                <th>Opzioni</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @foreach($gravidanza as $key => $g)

                                                                                                <tr>
                                                                                                    <td>{{$key+1}}</td>
                                                                                                    <td>{{$g->eta}}</td>
                                                                                                    <td>@if($g->inizio_gravidanza == null) @else{{date('d/m/Y', strtotime($g->inizio_gravidanza))}}@endif</td>
                                                                                                    <td>@if($g->fine_gravidanza == null) @else{{date('d/m/Y', strtotime($g->fine_gravidanza))}}@endif</td>
                                                                                                    <td>{{$g->esito}}</td>
                                                                                                    <td>{{$g->sesso_bambino}}</td>
                                                                                                    <td>{{$g->note_gravidanza}}</td>
                                                                                                    <td><a class="btn btn-primary" data-toggle="modal" data-target="#Updategravidanze-{{$g->id_gravidanza}}" data-dismiss="modal"><i class="icon-pencil icon-white"></i></a>
                                                                                                        <a class="elimina btn btn-danger" data-toggle="modal" data-target="#Deletegravidanze-{{$g->id_gravidanza}}" data-dismiss="modal"><i class="icon-remove icon-white"></i></a></td>
                                                                                                </tr>
                                                                                            @endforeach

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                    <!--inserisci gravidanza modal-->
                                                                                    <div class="col-lg-5">


                                                                                        <a id="insgrav"
                                                                                           class="accordion-toggle"
                                                                                           data-toggle="collapse"
                                                                                           data-parent="#accordion"
                                                                                           href="#nuovegrav">
                                                                                            <h5>
                                                                                                <i class="icon-plus"></i>Inserisci
                                                                                                nuova gravidanza</h5>
                                                                                        </a>
                                                                                    </div><!--fine inserisci modal-->

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--GRAVIDANZE-------------->


                                                            <!-- GRAVIDANZE NUOVE---------------------->
                                                            <div id="nuovegrav" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="accordion-body">
                                                                                <br/>

                                                                                <div class="form-group">
                                                                                    <label class="control-label col-lg-2"
                                                                                           for="esito">Esito:</label>
                                                                                    <div class="col-lg-4">

                                                                                        <select class="form-control"
                                                                                                name="esito"
                                                                                                id="esito">
                                                                                            <option></option>
                                                                                            <option id="Positivo">
                                                                                                Positivo
                                                                                            </option>
                                                                                            <option id="Negativo">
                                                                                                Negativo
                                                                                            </option>

                                                                                        </select>
                                                                                    </div>
                                                                                    <label for="etaGravidanza"
                                                                                           class="control-label col-lg-4">Et&#224;
                                                                                        gravidanza:</label>
                                                                                    <div class="col-lg-2">
                                                                                        <textarea id="etaGravidanza"
                                                                                                  name="etaGravidanza"
                                                                                                  class="form-control"
                                                                                                  onblur="isnum(this)"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="dataInizioGrav"
                                                                                           class="control-label col-lg-5">Data
                                                                                        inizio gravidanza:</label>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="date"
                                                                                               name="dataInizioGrav"
                                                                                               id="datepicker"
                                                                                               class="form-control col-lg-6"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="dataFineGrav"
                                                                                           class="control-label col-lg-5">Data
                                                                                        fine gravidanza:</label>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="date"
                                                                                               name="dataFineGrav"
                                                                                               id="datepicker"
                                                                                               class="form-control col-lg-6"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    <label class="control-label col-lg-5"
                                                                                           for="sessoBambino">Sesso
                                                                                        bambino:</label>
                                                                                    <div class="col-lg-6">

                                                                                        <select class="form-control"
                                                                                                name="sessoBambino"
                                                                                                id="sessoBambino">
                                                                                            <option></option>
                                                                                            <option id="Maschile">
                                                                                                Maschio
                                                                                            </option>
                                                                                            <option id="Femminile">
                                                                                                Femmina
                                                                                            </option>

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-lg-1">
                                                                                        <textarea id="hiddenid"
                                                                                                  name="hiddenid"
                                                                                                  class="form-control"
                                                                                                  style="visibility: hidden;"></textarea>
                                                                                    </div>
                                                                                    <label for="noteGravidanza"
                                                                                           class="control-label col-lg-4">Note:</label>
                                                                                    <div class="col-lg-6">
                                                                                        <textarea id="noteGravidanza"
                                                                                                  name="noteGravidanza"
                                                                                                  class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group; col-lg-11"
                                                                                     style="text-align:right">
                                                                                    <!--bottoni per la gestione delle modifiche-->
                                                                                    <input type="submit"
                                                                                           value="Salva"
                                                                                           id="btnsalvagrav"
                                                                                           class="btn btn-success btn-sm"/>
                                                                                    <input type="button"
                                                                                           value="Annulla"
                                                                                           id="btnannullagrav"
                                                                                           class="btn btn-danger btn-sm"/>



                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- GRAVIDANZE NUOVE -------------->



                                                            <div class="row">

                                                                @if($user->paziente_sesso == "female" or $user->paziente_sesso == "F")
                                                                    <div class="col-lg-4">
                                                                        <a id="inf5" class="accordion-toggle"
                                                                           data-toggle="collapse"
                                                                           data-parent="#accordionUtility"
                                                                           href="#cicloMestruale">
                                                                            <h5><i class="icon-pencil icon-white"></i>Ciclo
                                                                                Mestruale</h5>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                                <div class="col-lg-4">
                                                                    <a id="inf6" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#attivitaLavorativa">
                                                                        <h5><i class="icon-pencil icon-white"></i>Attivit&#224;
                                                                            lavorativa</h5>
                                                                    </a>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <a id="inf7" class="accordion-toggle"
                                                                       data-toggle="collapse"
                                                                       data-parent="#accordionUtility"
                                                                       href="#alvominzione">
                                                                        <h5><i class="icon-pencil icon-white"></i>Alvo e
                                                                            minzione</h5>
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <!-- CICLO MESTRUALE ---------------------->

                                                            <div id="cicloMestruale" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Ciclo Mestruale</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="submit"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvaciclo"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullaciclo"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>

                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-lg-3"
                                                                                               for="etaMenarca">Et&#224;
                                                                                            menarca:</label>
                                                                                        <div class="col-lg-3">
                                                                                            <select class="form-control"
                                                                                                    name="etaMenarca"
                                                                                                    id="etaMenarca">
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "8") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="otto">
                                                                                                    8
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "9") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="nove">
                                                                                                    9
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "10") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="dieci">
                                                                                                    10
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "11") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="undici">
                                                                                                    11
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "12") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="dodici">
                                                                                                    12
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "13") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="tredici">
                                                                                                    13
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "14") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="quattordici">
                                                                                                    14
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "15") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="quindici">
                                                                                                    15
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "16") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="sedici">
                                                                                                    16
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "17") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="diciasette">
                                                                                                    17
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->etaMenarca == "18") value="{{$anamnesiFisiologica->etaMenarca}}" selected="selected" @endif id="diciotto">
                                                                                                    18
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <label class="control-label col-lg-2"
                                                                                               for="ciclo">Ciclo:</label>
                                                                                        <div class="col-lg-4">
                                                                                            <select class="form-control"
                                                                                                    name="ciclo"
                                                                                                    id="ciclo">
                                                                                                <option @if( $anamnesiFisiologica->ciclo == "") value="{{$anamnesiFisiologica->ciclo}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->ciclo == "regolare") value="{{$anamnesiFisiologica->ciclo}}" selected="selected" @endif value="regolare">
                                                                                                    regolare
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->ciclo == "irregolare") value="{{$anamnesiFisiologica->ciclo}}" selected="selected" @endif value="irregolare">
                                                                                                    irregolare
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="etaMenopausa"
                                                                                               class="control-label col-lg-3">Et&#224;
                                                                                            Menopausa:</label>
                                                                                        <div class="col-lg-2">
                                                                                            <textarea id="etaMenopausa"
                                                                                                      name="etaMenopausa"
                                                                                                      placeholder="Et&#224;"
                                                                                                      class="form-control"
                                                                                                      onblur="isnum(this)">{{$anamnesiFisiologica->etaMenopausa}}</textarea>
                                                                                        </div>
                                                                                        <label class="control-label col-lg-3"
                                                                                               for="menopausa">Menopausa:</label>
                                                                                        <div class="col-lg-4">
                                                                                            <select class="form-control"
                                                                                                    name="menopausa"
                                                                                                    id="menopausa">
                                                                                                <option @if( $anamnesiFisiologica->menopausa == "") value="{{$anamnesiFisiologica->menopausa}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->menopausa == "fisiologica") value="{{$anamnesiFisiologica->menopausa}}" selected="selected" @endif value="fisiologica">
                                                                                                    fisiologica
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->menopausa == "chirurgica") value="{{$anamnesiFisiologica->menopausa}}" selected="selected" @endif value="chirurgica">
                                                                                                    chirurgica
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="noteStileVita"
                                                                                               class="control-label col-lg-3">Note:</label>
                                                                                        <div class="col-lg-9">
                                                                                            <textarea id="noteCicloMes"
                                                                                                      name="noteCicloMes"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteCicloMes}}</textarea>
                                                                                        </div>
                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--CICLO MESTRUALE-------------->


                                                            <!-- ATTIVITA' LAVORATIVA ---------------------->
                                                            <div id="attivitaLavorativa"
                                                                 class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Attivit&#224;
                                                                                        lavorativa</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="submit"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvalavoro"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullalavoro"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>

                                                                                    <div class="form-group">
                                                                                        <label for="professione"
                                                                                               class="control-label col-lg-4">Professione:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="professione"
                                                                                                      name="professione"
                                                                                                      class="form-control">{{$anamnesiFisiologica->professione}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="noteAttLav"
                                                                                               class="control-label col-lg-4">Note:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="noteAttLav"
                                                                                                      name="noteAttLav"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteAttLav}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--ATTIVITA' LAVORATIVA------------>

                                                            <!-- ALVO E MINZIONE ---------------------->
                                                            <div id="alvominzione" class="accordion-body collapse">
                                                                <div class="accordion-inner">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="box dark">
                                                                                <header><h5>Alvo e minzione</h5>
                                                                                    <div class="toolbar">
                                                                                        <ul class="nav">
                                                                                            <li><input type="submit"
                                                                                                       value="Salva"
                                                                                                       id="btnsalvaminzione"
                                                                                                       class="btn btn-success btn-sm"/>
                                                                                            </li>
                                                                                            <li><input type="button"
                                                                                                       value="Annulla"
                                                                                                       id="btnannullaminzione"
                                                                                                       class="btn btn-danger btn-sm"/>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </header>
                                                                                <div class="accordion-body">
                                                                                    <br/>

                                                                                    <div class="form-group">

                                                                                        <label for="alvo"
                                                                                               class="control-label col-lg-4">Alvo:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <select class="form-control"
                                                                                                    name="alvo"
                                                                                                    id="alvo">
                                                                                                <option @if( $anamnesiFisiologica->alvo == "") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "regolare") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvoregolare">
                                                                                                    regolare
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "stitico") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvostitico">
                                                                                                    stitico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "diarroico") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvodiarroico">
                                                                                                    diarroico
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->alvo == "alterno") value="{{$anamnesiFisiologica->alvo}}" selected="selected" @endif id="alvoalterno">
                                                                                                    alterno
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="minzione"
                                                                                               class="control-label col-lg-4">Minzione:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <select class="form-control"
                                                                                                    name="minzione"
                                                                                                    id="minzione">
                                                                                                <option @if( $anamnesiFisiologica->minzione == "") value="{{$anamnesiFisiologica->minzione}}" selected="selected" @endif></option>
                                                                                                <option @if( $anamnesiFisiologica->minzione == "nella norma") value="{{$anamnesiFisiologica->minzione}}" selected="selected" @endif id="minzionenellanorma">
                                                                                                    nella norma
                                                                                                </option>
                                                                                                <option @if( $anamnesiFisiologica->minzione == "patologica") value="{{$anamnesiFisiologica->minzione}}" selected="selected" @endif id="minzionepatologica">
                                                                                                    patologica
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="noteAlvoMinz"
                                                                                               class="control-label col-lg-4">Note:</label>
                                                                                        <div class="col-lg-8">
                                                                                            <textarea id="noteAlvoMinz"
                                                                                                      name="noteAlvoMinz"
                                                                                                      class="form-control">{{$anamnesiFisiologica->noteAlvoMinz}}</textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--ALVO E MINZIONE------------>


                                                        </div><!--col-lg-12-->
                                                    </div><!--accordion- group heading centered-->


                                                </div><!--chiusura accordion-group-->
                                            </div><!--chiusura accordion ac-->
                                        </div><!--chiusura table-bordered-->
                                    </div><!--chiusura table-responsive-->
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!--MODAL EDIT GRAVIDANZE-->
            @foreach($gravidanza as $g)
            <form action="{{ route('Update', ['id' => $g->id_gravidanza]) }}" method="post"
                  class="form-horizontal">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <input name="input_name" value="UpdateGravidanze" hidden />
                <input class="form-control hidden" type="text" name="ids[]" value="{{ $g->id_gravidanza }}" disabled>
                <div class="modal fade" tabindex="-1" role="dialog" id="Updategravidanze-{{$g->id_gravidanza}}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Modifica gravidanze</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>



                            <div class="accordion-inner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="accordion-body">
                                            <br/>

                                            <div class="form-horizontal">
                                                <label class="control-label col-lg-2"
                                                       for="esito">Esito:</label>
                                                <div class="col-lg-4">

                                                    <select class="form-control"
                                                            name="esito"
                                                            id="esito">
                                                        <option @if( $g->esito == "") value="{{$g->esito}}" selected="selected" @else value="" @endif></option>
                                                        <option @if( $g->esito == "Positivo") value="{{$g->esito}}" selected="selected" @else value="Positivo" @endif id="Positivo">
                                                            Positivo
                                                        </option>
                                                        <option @if( $g->esito == "Negativo") value="{{$g->esito}}" selected="selected" @else value="Negativo" @endif id="Negativo">
                                                            Negativo
                                                        </option>

                                                    </select>
                                                </div>
                                                <label for="etaGravidanza"
                                                       class="control-label col-lg-4">Et&#224;
                                                    gravidanza:</label>
                                                <div class="col-lg-2">
                                                <textarea id="etaGravidanza"
                                                          name="etaGravidanza"
                                                          class="form-control"
                                                          onblur="isnum(this)">{{$g->eta}}</textarea>
                                                </div>
                                            </div><div class="form-group"></div>
                                            <div class="form-group">
                                                <label for="dataInizioGrav"
                                                       class="control-label col-lg-5">Data
                                                    inizio gravidanza:</label>
                                                <div class="col-lg-6">
                                                    <input type="date"
                                                           name="dataInizioGrav"
                                                           value="{{$g->inizio_gravidanza}}"
                                                           id="datepicker"
                                                           class="form-control col-lg-6"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="dataFineGrav"
                                                       class="control-label col-lg-5">Data
                                                    fine gravidanza:</label>
                                                <div class="col-lg-6">
                                                    <input type="date"
                                                           name="dataFineGrav"
                                                           value="{{$g->fine_gravidanza}}"
                                                           id="datepicker"
                                                           class="form-control col-lg-6"/>
                                                </div>
                                            </div>
                                            <div class="form-group">

                                                <label class="control-label col-lg-5"
                                                       for="sessoBambino">Sesso
                                                    bambino:</label>
                                                <div class="col-lg-6">

                                                    <select class="form-control"
                                                            name="sessoBambino"
                                                            id="sessoBambino">
                                                        <option @if( $g->sesso_bambino == "") value="{{$g->sesso_bambino}}" selected="selected" @else value="" @endif></option>
                                                        <option @if( $g->sesso_bambino == "Maschio") value="{{$g->sesso_bambino}}" selected="selected" @else value="Maschio" @endif id="Maschile">
                                                            Maschio
                                                        </option>
                                                        <option @if( $g->sesso_bambino == "Femmina") value="{{$g->sesso_bambino}}" selected="selected" @else value="Femmina" @endif id="Femminile">
                                                            Femmina
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-1">
                                                <textarea id="hiddenid"
                                                          name="hiddenid"
                                                          class="form-control"
                                                          style="visibility: hidden;"></textarea>
                                                </div>
                                                <label for="noteGravidanza"
                                                       class="control-label col-lg-4">Note:</label>
                                                <div class="col-lg-6">
                                                <textarea id="noteGravidanza"
                                                          name="noteGravidanza"
                                                          class="form-control">{{$g->note_gravidanza}}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            <button type="submit" class="btn btn-primary">Modifica</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            @endforeach <!--CHIUSURA MODAL EDIT GRAVIDANZE-->

            <!--MODAL DELETE GRAVIDANZE-->
            @foreach($gravidanza as $g)
            <form action="{{ route('Delete', ['id' => $g->id_gravidanza]) }}" method="post"
                  class="form-horizontal">
                {{csrf_field()}}
                {{ method_field('DELETE') }}
                <input name="input_name" value="DeleteGravidanze" hidden />
                <div id="Deletegravidanze-{{$g->id_gravidanza}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Eliminare gravidanza</h4>
                            </div>
                            <div class="modal-body">
                                <p>Eliminare gravidanza selezionata?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Elimina</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            @endforeach <!--CHIUSURA MODAL DELETE GRAVIDANZE-->

            <!--MODAL MODIFICA PATOLOGIE PREGRESSE-->
            <div class="col-md-4">
                <div class="modal fade" id="modanamnesipat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie pregresse</h4>
                            </div>

                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie - 1/4</label>
                                    @foreach($icd9groupcode as $g)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="icd9groupcode" value="{{$g->codice}}"> {{$g->gruppo_descrizione}}</label>

                                        </div>
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="modalPat()" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modanamnesipat2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie pregresse</h4>
                            </div>

                                <div class="modal-body" id="mod2">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="modalPat2()" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modanamnesipat3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie pregresse</h4>
                            </div>

                                <div class="modal-body" id="mod3">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="modalPat3()" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modanamnesipat4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie pregresse</h4>
                            </div>

                                <div class="modal-body" id="mod4">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="addPtRemota()" class="btn btn-primary">Salva
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>
            </div><!--fine del modal modifica patologie pregresse-->


            <!--MODAL MODIFICA PATOLOGIE RECENTI-->
            <div class="col-md-4">
                <div class="modal fade" id="modanamnesipatrec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie recenti</h4>
                            </div>

                                <div class="modal-body">
                                    <label style="font: bold;">Seleziona uno o pi&#249; gruppi di patologie - 1/4</label>
                                    @foreach($icd9groupcode as $g)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="icd9groupcoderec" value="{{$g->codice}}"> {{$g->gruppo_descrizione}}</label>

                                        </div>
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="modalPatRec()" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modanamnesipatrec2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie recenti</h4>
                            </div>

                                <div class="modal-body" id="modrec2">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="modalPatRec2()" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modanamnesipatrec3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie recenti</h4>
                            </div>

                                <div class="modal-body" id="modrec3">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="modalPatRec3()" class="btn btn-primary">Avanti
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modanamnesipatrec4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Modifica patologie recenti</h4>
                            </div>

                                <div class="modal-body" id="modrec4">


                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                    <button type="submit" onclick="addPtProssima()" class="btn btn-primary">Salva
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>
            </div> <!--CHIUSURA MODAL MODIFICA PATOLOGIE RECENTI-->

            <!--MODAL SPOSTA da prossima a remota-->
            <div class="col-md-4">
                <div class="modal fade" id="modansposta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        id="chiudimodpatinfo">&times;
                                </button>
                                <h4 class="modal-title" id="H2">Conferma spostamento ad Anamnesi patologica remota</h4>
                            </div>

                                <input name="input_name" value="SpostaPatologicaProssima" hidden />
                                {{csrf_field()}}
                                <div class="modal-body form-gr">
                                    <label style="font: bold;">Seleziona i gruppi di patologie recenti da spostare in
                                        patologie pregresse</label>
                                    <hr/>

                                    @foreach($anamnesiPatologicaProssima as $g)
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="icd9codePtProssima" value="{{$g->codice_diag}}"> {{$g->codice_descrizione}}</label>
                                        </div>
                                    @endforeach
                                </div> <!--modal-body--->
                                <div class="modal-footer">
                                    <button id="btnspostamodal" onclick="spostaPtProssima()"
                                            class="btn btn-primary" >Sposta
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                </div>

                        </div>
                    </div>
                </div>
            </div><!--CHIUSURA MODAL SPOSTA DA PROSSIMA A REMOTA-->


            <!-- &#224; -->
            <!------------------------- JAVASCRIPT UTILIZZATI ----------------------------------->

            <!-- VERIFICA CAMPO CON NUMERI -->

            <script language="Javascript">
                function isnum(obj) {
                    if (isNaN(obj.value) || parseInt(obj.value) < 10 || parseInt(obj.value) > 99) {
                        alert('Nel campo \u00E8 possibile immettere solo numeri a due cifre!');
                        obj.value = "";
                        obj.focus();
                    }
                }
            </script>
            <script language="Javascript">
                function isgrav(obj) {
                    if (isNaN(obj.value) || parseInt(obj.value) < 1 || parseInt(obj.value) > 99) {
                        alert('Nel campo \u00E8 possibile immettere solo numeri a due cifre!');
                        obj.value = "";
                        obj.focus();
                    }
                }
            </script>

            <!-- RIDIMENSIONA TEXTAREA IN BASE AL CONTENUTO AL CLICK -->
            <script>
                function textAreaAdjust(o) {
                    o.style.height = "1px";
                    o.style.height = (25 + o.scrollHeight) + "px";
                }
            </script>

            <!-- SPOSTA DA CHECKLIST A TEXTAREA -->

            <script type="text/javascript">
                function checkprova2() {
                    if (document.getElementById('testopatmodrec').value != null) {
                        document.getElementById('testopatmodrec').value = '';
                    }
                    var checkedValue = null;
                    var inputElements = document.getElementsByClassName('ck2');
                    for (var i = 0; inputElements[i]; ++i) {
                        if (inputElements[i].checked) {
                            checkedValue = inputElements[i].value;
                            document.getElementById('testopatmodrec').value += '-' + checkedValue;
                        }
                    }
                }</script>
            <!--DELETE GRAVIDANZE-->
            <script>
                function delGrav(valor) {
                    if (confirm('Eliminare la gravidanza selezionata?') == true) {

                        $.post("formscripts/testofis.php",
                            {

                                valor: valor,

                            },

                            function (status) {

                                alert("Status: " + "Eliminazione avvenuta correttamente");
                                window.location.reload();

                            });
                    }
                }
            </script>
            <!--PASSAGGIO DATI PER MODIFICA GRAVIDANZA-->
            <script>
                function passDati(i, idy) {
                    if (confirm('Modificare la gravidanza selezionata?') == true) {
                        $('#nuovegrav').collapse('show');
                        $('#btnsalvagrav').hide();
                        $('#btnannullagrav').hide();
                        $('#btnsalvagrav2').show();
                        $('#btnannullagrav2').show();
                        $('#insgrav').prop('class', "hidden");
                        $('#hiddenid').prop('value', idy);
                        $('#esito').prop('value', document.getElementById("tbl").rows[i].cells[4].innerHTML);
                        $('#etaGravidanza').prop('value', document.getElementById("tbl").rows[i].cells[1].innerHTML);
                        $('#sessoBambino').prop('value', document.getElementById("tbl").rows[i].cells[5].innerHTML);
                        $('#dataInizioGrav').prop('value', document.getElementById("tbl").rows[i].cells[2].innerHTML);
                        $('#dataFineGrav').prop('value', document.getElementById("tbl").rows[i].cells[3].innerHTML);
                        $('#noteGravidanza').prop('value', document.getElementById("tbl").rows[i].cells[6].innerHTML);


                    }

                }
            </script>

            <script type="text/javascript">
                    function modalPat() {
                        var inputElements = document.getElementsByName("icd9groupcode");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Bloc") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#modanamnesipat').modal('hide');
                                $("#modanamnesipat2").modal();


                                var div = document.getElementById('mod2');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona uno o più blocchi di patologie - 2/4";
                                document.getElementById('mod2').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('mod2').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].blocco_cod_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9bloccode';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_blocco;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function modalPat2() {
                        var inputElements = document.getElementsByName("icd9bloccode");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Cat") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#modanamnesipat2').modal('hide');
                                $("#modanamnesipat3").modal();

                                var div = document.getElementById('mod3');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona una o più categorie di patologie - 3/4";
                                document.getElementById('mod3').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('mod3').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].categoria_cod_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9catcode';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_categoria;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function modalPat3() {
                        var inputElements = document.getElementsByName("icd9catcode");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Cod") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#modanamnesipat3').modal('hide');
                                $("#modanamnesipat4").modal();

                                var div = document.getElementById('mod4');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona una o più patologie - 4/4";
                                document.getElementById('mod4').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('mod4').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].codice_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9code';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_diag;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function addPtRemota() {
                        var inputElements = document.getElementsByName("icd9code");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }


                        console.log(checked);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("addPtRemota") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                $('#modanamnesipat4').modal('hide');
                                location.reload();
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function modalPatRec() {
                        var inputElements = document.getElementsByName("icd9groupcoderec");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Bloc") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#modanamnesipatrec').modal('hide');
                                $("#modanamnesipatrec2").modal();


                                var div = document.getElementById('modrec2');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona uno o più blocchi di patologie - 2/4";
                                document.getElementById('modrec2').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('modrec2').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].blocco_cod_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9bloccoderec';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_blocco;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function modalPatRec2() {
                        var inputElements = document.getElementsByName("icd9bloccoderec");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Cat") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#modanamnesipatrec2').modal('hide');
                                $("#modanamnesipatrec3").modal();

                                var div = document.getElementById('modrec3');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona una o più categorie di patologie - 3/4";
                                document.getElementById('modrec3').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('modrec3').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].categoria_cod_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9catcoderec';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_categoria;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function modalPatRec3() {
                        var inputElements = document.getElementsByName("icd9catcoderec");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Cod") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#modanamnesipatrec3').modal('hide');
                                $("#modanamnesipatrec4").modal();

                                var div = document.getElementById('modrec4');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona una o più patologie - 4/4";
                                document.getElementById('modrec4').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('modrec4').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].codice_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9coderec';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_diag;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function addPtProssima() {
                        var inputElements = document.getElementsByName("icd9coderec");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }


                        console.log(checked);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("addPtProssima") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                $('#modanamnesipatrec4').modal('hide');
                                location.reload();
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function showPtParente(button) {
                        h4 = document.createElement("h4");
                        h4.textContent = "Anamnesi familiare " + button.id;
                        h4.className = "modal-title";
                        h4.id = "H2";
                        document.getElementById('modShowPtParente').appendChild(h4);
                        document.getElementById("addPtParenteButton").value = button.value;

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("showPtParente") }}',
                            data: {data:button.value},
                            success: function(response)
                            {
                                $('#table_update_anamnesifam').modal('hide');
                                $("#showPtParente").modal();

                                var div = document.getElementById('showPtParenteDiv');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Patologie rilevate";
                                document.getElementById('showPtParenteDiv').appendChild(lab);

                                var pat = JSON.parse(response);

                                console.log(pat);

                                for (i = 0; i < pat.length; i++) {

                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('showPtParenteDiv').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = "- " + pat[i].codice_descrizione;
                                    iDiv.appendChild(innerLabel);

                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                }</script>

                <script type="text/javascript">
                    function addPtParente(button) {
                        $('#showPtParente').modal('hide');
                        $("#addPtParente").modal();
                        document.getElementById("addPtParenteButton2").value = button.value;
                }</script>

                <script type="text/javascript">
                    function addPtParente2(button) {
                        var inputElements = document.getElementsByName("icd9groupcodePtParente");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }
                        console.log(checked);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Bloc") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#addPtParente').modal('hide');
                                $("#addPtParente2").modal();

                                document.getElementById("addPtParenteButton3").value = button.value;

                                var div = document.getElementById('modPar2');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona uno o più blocchi di patologie - 2/4";
                                document.getElementById('modPar2').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('modPar2').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].blocco_cod_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9bloccodePtParente';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_blocco;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                }</script>

                <script type="text/javascript">
                    function addPtParente3(button) {
                        var inputElements = document.getElementsByName("icd9bloccodePtParente");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Cat") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#addPtParente2').modal('hide');
                                $("#addPtParente3").modal();

                                document.getElementById("addPtParenteButton4").value = button.value;

                                var div = document.getElementById('modPar3');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona una o più categorie di patologie - 3/4";
                                document.getElementById('modPar3').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('modPar3').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].categoria_cod_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9catcodePtParente';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_categoria;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                }</script>

                <script type="text/javascript">
                    function addPtParente4(button) {
                        var inputElements = document.getElementsByName("icd9catcodePtParente");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("icd9Cod") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                console.log(response);
                                $('#addPtParente3').modal('hide');
                                $("#addPtParente4").modal();

                                document.getElementById("addPtParenteButton5").value = button.value;

                                var div = document.getElementById('modPar4');
                                while(div.firstChild) {
                                    div.removeChild(div.firstChild);
                                }

                                var lab = document.createElement('label');
                                lab.style.font = "bold";
                                lab.textContent = "Seleziona una o più di patologie - 4/4";
                                document.getElementById('modPar4').appendChild(lab);

                                for (var i = 0; i < response.length; i++)
                                {
                                    var iDiv = document.createElement('div');
                                    iDiv.className = 'checkbox';
                                    document.getElementById('modPar4').appendChild(iDiv);

                                    var innerLabel = document.createElement('label');
                                    innerLabel.textContent = response[i].codice_descrizione;
                                    iDiv.appendChild(innerLabel);

                                    var innerInput = document.createElement('input');
                                    innerInput.name = 'icd9codePtParente';
                                    innerInput.type = 'checkbox';
                                    innerInput.value = response[i].codice_diag;
                                    innerLabel.appendChild(innerInput);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                }</script>

                <script type="text/javascript">
                    function addPtParenteDB(button) {
                        var inputElements = document.getElementsByName("icd9codePtParente");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }


                        console.log(checked);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        x = button.value;

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("addPtParente") }}',
                            data: {data:checked,idParente:x},
                            success: function(response)
                            {
                                $('#addPtParente4').modal('hide');
                                location.reload();
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>

                <script type="text/javascript">
                    function spostaPtProssima() {
                        var inputElements = document.getElementsByName("icd9codePtProssima");
                        var checkedValue = null;
                        var checked = [];
                        for (var i = 0; i<inputElements.length; ++i) {
                            if (inputElements[i].checked) {
                                checkedValue = inputElements[i].value;
                                checked.push(checkedValue);
                            }
                        }

                        console.log(checked);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("spostaPtProssima") }}',
                            data: {data:checked},
                            success: function(response)
                            {
                                $('#modansposta').modal('hide');
                                location.reload();

                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

                }</script>



        </div>
    </div><!--content-->
    <!--END PAGE CONTENT -->

@endsection
