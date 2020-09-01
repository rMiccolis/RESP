@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Terapie')
@section('content')
<!--PAGE CONTENT -->
<style media="screen">
body.modal-open {
  margin-right: 0px;
}

.pointer {
  cursor: pointer;
}

button{
    margin-top:5px;
}
</style>
<div id="content">
    <div class="inner" style="min-height:1200px;">
        <div class="row">
            <div class="col-lg-12">
                <h2>Terapie Farmacologiche</h2>
                <hr>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-group">
                            <button class="btn btn-primary" id="nuovaT"><i class="icon-medkit"></i> Nuova
                                Terapia
                            </button>
                            <button class="btn btn-danger" id="annullaT"><i class="icon-trash"></i> Annulla
                                Terapia
                            </button>
                        </div>
                        <button class="btn btn-primary pull-right" id="search_terapia" data-toggle="modal" data-target="#searchModal" ><i class="icon-search"></i> Cerca Terapia
                        </button>
                    </div>
                </div>
                <br>
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error}}</li>
                        @endforeach
                    </div>
                    @endif
                <!-- SCRIPT PER AGGIUNGERER UNA DIAGNOSI NON ANCORA ESISTENTE-->
                <script>
                //permette di visaulizzare l'input text 'nuovo careprovider' nel form della nuova indagine
                $('#concludiD').prop('disabled', true);
                $('#annullaT').prop('disabled', true);

                $("#annullaT").click(function () {
                    $("#formT").hide(200);
                    $('#annullaT').prop('disabled', true);
                });
                $("#nuovaT").click(function() {
                    $("#formT").show(200);
                    $('#annullaT').prop('disabled', false);
                });


                $(document).ready(function(){
                    $('#tipo_terapia').change(function(){
                    if ($(this).val() == '0') {
                        document.getElementById('dataInizioCampo').style.display = "none";
                        document.getElementById('dataFineCampo').style.display = "none";
                        document.getElementById('verificatosiCampo').style.display = "block";
                        document.getElementById('diagnosiCampo').style.display = "none";
                        document.getElementById('confidenzialitaCampo').style.display = "none";
                    } else {
                        document.getElementById('dataInizioCampo').style.display = "block";
                        document.getElementById('dataFineCampo').style.display = "block";
                        document.getElementById('verificatosiCampo').style.display = "none";
                        document.getElementById('diagnosiCampo').style.display = "block";
                        document.getElementById('confidenzialitaCampo').style.display = "block";
                    }
                    if ($(this).val() == '1') {
                        document.getElementById('motivo_note_campo').textContent = "Note *";
                    } else {
                        document.getElementById('motivo_note_campo').textContent = "Motivo *";
                    }
                });
            });
            </script>
            <!--END SCRIPT-->

                {{--Form inserimento nuova terapia--}}
                <form id="formT" action="{{action('TerapieController@aggiungiTerapia')}}" metod="POST" style="display:none" class="form-horizontal" onSubmit>
                {{ csrf_field() }}
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Farmaco *</label>
                                    <div class="col-lg-4">
                                      <select id="id_farmaco_codifa" name="id_farmaco_codifa" class="idFarmaco form-control">
                                      <option selected hidden style='display: none'>Selezionare un Farmaco</option>
                                        <optgroup>
                                          @foreach($farmaci as $ind)
                                          <option value="{{$ind->id_farmaco_codifa}}">{{$ind->descrizione_breve}}</option>
                                          @endforeach
                                        </optgroup>
                                      </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Tipo *</label>
                                    <div class="col-lg-4">
                                        <select id="tipo_terapia" name="tipo_terapia" class="form-control">
                                            <option value="0">Farmaco Vietato</option>
                                            <option selected value="1">Terapia in Corso</option>
                                            <option value="2">Terapia Conclusa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Somministrazione *</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="id_farmaco_somministrazione" id="id_farmaco_somministrazione"  disabled/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Forma Farmaceutica *</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="id_forma_farmaceutica" id="id_forma_farmaceutica"  disabled/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12" id="dataInizioCampo">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data inizio *</label>
                                    <div class="col-lg-4">
                                        <input id="dataInizio" name="dataInizio" type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12" id="dataFineCampo">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Data fine *</label>
                                    <div class="col-lg-4">
                                        <input id="dataFine" name="dataFine" type="date" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="diagnosiCampo">
                                <div class="form-group">
                                    <label id="dia_ver" class="control-label col-lg-4">Diagnosi *</label>
                                    <div class="col-lg-4">
                                        <select id="diagnosi" name="diagnosi" class="form-control">
                                            <option selected hidden style='display: none' value="notSelected">
                                                Selezionare una Diagnosi
                                            </option>
                                            <optgroup>
                                                @foreach($current_user->diagnosi() as $ind)
                                                @if($ind->diagnosi_stato == 0 || $ind->diagnosi_stato == 1)
                                                <option value="{{$ind->id_diagnosi}}">{{$ind->diagnosi_patologia}}</option>
                                                @endif
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <button type="button" class="btn btn-primary nuovaDiagnosi" id="nuovaDiagnosi" data-toggle="modal" data-target="#nuovaDiagnosiModal"><i class="icon-file-text-alt"></i> Nuova
                                            Diagnosi
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="confidenzialitaCampo">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Confidenzialità *</label>
                                    <div class="col-lg-4">
                                        <select id="livello_confidenzialita" name="livello_confidenzialita" class="form-control">
                                            <optgroup>
                                            @foreach($confidenzialita as $ind)
                                            @if($ind->id_livello_confidenzialita <= $confidenzialita_auth || $confidenzialita_auth == 0)
                                            <option value="{{$ind->id_livello_confidenzialita}}">{{$ind->confidenzialita_descrizione}}</option>
                                            @endif
                                            @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style='display: none' id="verificatosiCampo">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Verificatosi *</label>
                                    <div class="col-lg-4">
                                        <input id="verificatosi" name="verificatosi" type="date" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label id="motivo_note_campo" class="control-label col-lg-4">Note *</label>
                                    <div class="col-lg-4">
                                        <input id="motivo_note" name="motivo_note" type="text" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" style="margin-top:5px;" type="submit">Conferma Terapia</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>

                {{-- Tabella Farmaci Vietati --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">Farmaci VIETATI<i class="icon-eye-close pointer" style="margin-left:10px; font-size: 15px;"  onclick="hideShow('myTable0')" ></i></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <form action="{{action('TerapieController@eliminaTerapia')}}" method="POST" >
							                      {{ csrf_field() }}
                                    <table class="table" id="myTable0">

                                        <thead>
                                            <tr>
                                                <th onclick="sortTable('0',0)" class="pointer">Farmaco <i id="iconSortAlph0" class="icon-sort-by-alphabet"></i></th>
                                                <th>Principio Attivo</th>
                                                <th>ATC</th>
                                                <th onclick="sortTable('0',1)" class="pointer">Data Evento <i id="iconSortNum0" class="icon-sort-by-order"></i></th>
                                                <th>Motivo</th>
                                                <th>Medico</th>
                                                <th>Opzioni</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach($terapie as $ind)
                                            @if($ind->tipo_terapia == 0)
                                            <tr>
                                                <td>
                                                    {{$ind->getFarmaco()->descrizione_breve}}
                                                </td>
                                                <td>
                                                    {{$ind->getFarmaco()->getPrincipioAttivo()}}
                                                </td>
                                                <td>
                                                    {{$ind->getFarmaco()->getATC()}}
                                                </td>
                                                <td>
                                                    {{$ind->data_evento->format('d/m/Y')}}
                                                </td>
                                                <td>
                                                    {{$ind->note}}
                                                </td>
                                                <td>
                                                    {{$ind->getPrescrittore()}}
                                                </td>
                                                <td >
                                                  <button type="button" class="btn btn-success open-modal" value="{{$ind->id_terapie}}" data-tip_ter="{{$ind->tipo_terapia}}"><i class="icon-pencil icon-white"></i></button>
                                                  <button class="btn btn-primary open-info"  data-toggle="modal" value="{{$ind->id_farmaco_codifa}}"><i class="icon-info-sign icon-white"></i></button>
                                                  <button type="button" class="elimina btn btn-danger" value="{{($ind->id_terapie)}}" ><i class="icon-remove icon-white"></i></button>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        </table>
                                    <!-- </form> -->
                                </div>
                                <!--table responsive-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--row-->

                {{--Tabella Terapie in Corso --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">Terapie in Corso<i class="icon-eye-close pointer" style="margin-left:10px; font-size: 15px;"  onclick="hideShow('myTable1')" ></i></div>
                                <div class="panel-body">
                                  <div class="table-responsive">
                                    <form action="{{action('TerapieController@eliminaTerapia')}}" method="POST" >
							                          {{ csrf_field() }}
                                        <table class="table myTable1" id="myTable1">
                                            <thead>
                                                <tr>
                                                    <th onclick="sortTable('1',0)" class="pointer">Farmaco <i id="iconSortAlph1" class="icon-sort-by-alphabet"></i></th>
                                                    <th onclick="sortTable('1',1)" class="pointer">dal <i id="iconSortNum1" class="icon-sort-by-order"></i></th>
                                                    <th>al</th>
                                                    <th>Prescrittore</th>
                                                    <th>Diagnosi</th>
                                                    <th>P</th>
                                                    <th>Note</th>
                                                    <th >Opzioni</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($terapie as $ind)
                                                @if($ind->tipo_terapia == 1 && (($confidenzialita_auth != 0 && $confidenzialita_auth >= $ind->id_livello_confidenzialita) || ($confidenzialita_auth == 0)))
                                                <tr>
                                                    <td>
                                                        {{$ind->getFarmaco()->descrizione_breve}}
                                                    </td>
                                                    <td>
                                                        {{$ind->data_inizio->format('d/m/Y')}}
                                                    </td>
                                                    <td>
                                                        {{$ind->data_fine->format('d/m/Y')}}
                                                    </td>
                                                    <td>
                                                        {{$ind->getPrescrittore()}}
                                                    </td>
                                                    <td>
                                                        {{$ind->getDiagnosi()}}
                                                    </td>
                                                    <td>
                                                        {{$ind->id_livello_confidenzialita}}
                                                    </td>
                                                    <td>
                                                        {{$ind->note}}
                                                    </td>
                                                    <td >
                                                    <button type="button" class="btn btn-success open-modal" value="{{$ind->id_terapie}}" data-tip_ter="{{$ind->tipo_terapia}}"><i class="icon-pencil icon-white"></i></button>
                                                    <button class="btn btn-primary open-info"  data-toggle="modal" value="{{$ind->id_farmaco_codifa}}"><i class="icon-info-sign icon-white"></i></button>
                                                    <button type="button" class="elimina btn btn-danger" value="{{($ind->id_terapie)}}" ><i class="icon-remove icon-white"></i></button>
                                                    <button type="button" class="btn btn-info btn-sm pull-down sposta" value="{{$ind->id_terapie}}" data-toggle="tooltip" data-placement="right" title="Sposta in Terapa Conclusa"><i class="icon-hand-down"></i> Sposta </button>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                  </div>
                                </div>
                            </div>
                        <!--panelwarning-->
                    </div>
                </div>
                    <!--col lg12-->
                <!--row -->

                {{-- Tabella Terapie Concluse --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">Terapie Concluse<i class="icon-eye-close pointer" style="margin-left:10px; font-size: 15px;"  onclick="hideShow('myTable2')" ></i></div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <form action="{{action('TerapieController@eliminaTerapia')}}" method="POST" >
							                         {{ csrf_field() }}
                                        <table class="table" id="myTable2">
                                            <thead>
                                                <tr>
                                                    <th onclick="sortTable('2',0)" class="pointer">Farmaco <i id="iconSortAlph2" class="icon-sort-by-alphabet"></i></th>
                                                    <th onclick="sortTable('2',1)" class="pointer">dal <i id="iconSortNum2" class="icon-sort-by-order"></i></th>
                                                    <th>al</th>
                                                    <th>Prescrittore</th>
                                                    <th>Diagnosi</th>
                                                    <th>P</th>
                                                    <th>Motivo</th>
                                                    <th>Opzioni</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($terapie as $ind)
                                              @if($ind->tipo_terapia == 2 && (($confidenzialita_auth != 0 && $confidenzialita_auth >= $ind->id_livello_confidenzialita) || ($confidenzialita_auth == 0)))
                                                <tr>
                                                    <td>
                                                        {{$ind->getFarmaco()->descrizione_breve}}
                                                    </td>
                                                    <td>
                                                        {{$ind->data_inizio->format('d/m/Y')}}
                                                    </td>
                                                    <td>
                                                        {{$ind->data_fine->format('d/m/Y')}}
                                                    </td>
                                                    <td>
                                                        {{$ind->getPrescrittore()}}
                                                    </td>
                                                    <td>
                                                        {{$ind->getDiagnosi()}}
                                                    </td>
                                                    <td>
                                                        {{$ind->id_livello_confidenzialita}}
                                                    </td>
                                                    <td>
                                                        {{$ind->note}}
                                                    </td>
                                                    <td>
                                                      <button type="button" class="btn btn-success open-modal" value="{{$ind->id_terapie}}" data-tip_ter="{{$ind->tipo_terapia}}"><i class="icon-pencil icon-white"></i></button>
                                                      <button class="btn btn-primary open-info"  data-toggle="modal" value="{{$ind->id_farmaco_codifa}}"><i class="icon-info-sign icon-white"></i></button>
                                                      <button type="button" class="elimina btn btn-danger" value="{{($ind->id_terapie)}}" ><i class="icon-remove icon-white"></i></button>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <!--panelbody-->
                        </div>
                    </div>
                    <!--col lg12-->
                </div>
                <!--row-->
            </div>
        </div>
        <hr />
    </div>

</div>

<!-- MODAL MODIFICA TERAPIA -->

<div class="modal fade" id="EditorModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="linkEditorModalLabel"><strong>Modifica Terapia</strong></h4>
      </div>
      <div class="modal-body">
        <form action="{{action('TerapieController@modificaTerapia')}}" method="POST" id="modalFormData" name="modalFormData" class="form-horizontal" novalidate="">
          {{ csrf_field() }}
          <div class="tab-content">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="control-label col-lg-4">Farmaco *</label>
                  <div class="col-lg-8">
                    <select id="id_farmaco_codifa_mod" name ="id_farmaco_codifa_mod" class="form-control">
                    @foreach($farmaci as $ind)
                    <option value="{{$ind->id_farmaco_codifa}}">{{$ind->descrizione_breve}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
              </div>

                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Tipo *</label>
                      <div class="col-lg-8">
                        <select id="tipo_terapia_mod" name="tipo_terapia_mod" class="form-control">
                          <option value="0">Farmaco Vietato</option>
                          <option value="1">Terapia in Corso</option>
                          <option value="2">Terapia Conclusa</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Somministrazione *</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="somministrazione"  value="" disabled/>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Forma Farmaceutica *</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control" id="forma_farmaceutica"  value="" disabled/>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12" id="data_Inizio_campo">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Data inizio *</label>
                      <div class="col-lg-8">
                          <input id="data_Inizio" name="data_Inizio" type="date" value="" class="form-control" />
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12" id="data_Fine_campo">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Data fine *</label>
                      <div class="col-lg-8">
                          <input id="data_Fine" name="data_Fine" type="date" value="" class="form-control" />
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group" id="diagnosi_campo">
                      <label id="dia_ver" class="control-label col-lg-4">Diagnosi *</label>
                      <div class="col-lg-8">
                        <select id="diagnosi_mod" name="diagnosi_mod" class="form-control">
                            @foreach($current_user->diagnosi() as $ind)
                            @if($ind->diagnosi_stato == 0 || $ind->diagnosi_stato == 1)
                            <option value="{{$ind->id_diagnosi}}">{{$ind->diagnosi_patologia}}</option>
                            @endif
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12" id="confidenzialitaCampo_mod">
                      <div class="form-group">
                          <label id="dia_ver" class="control-label col-lg-4">Confidenzialità *</label>
                          <div class="col-lg-4">
                              <select id="livello_confidenzialita_mod" name="livello_confidenzialita_mod" class="form-control">
                                  <optgroup>
                                  @foreach($confidenzialita as $ind)
                                  @if($ind->id_livello_confidenzialita <= $confidenzialita_auth || $confidenzialita_auth == 0)
                                  <option value="{{$ind->id_livello_confidenzialita}}">{{$ind->confidenzialita_descrizione}}</option>
                                  @endif
                                  @endforeach
                                  </optgroup>
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12" id="verif_mod_campo">
                    <div class="form-group">
                      <label class="control-label col-lg-4">Verificatosi *</label>
                      <div class="col-lg-8">
                          <input id="verif_mod" name="verif_mod" type="date" value="" class="form-control" />
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="control-label col-lg-4" id="note_mod">Note</label>
                      <div class="col-lg-8">
                          <input type="text" class="form-control"  name="note_diagnosi" id="note_diagnosi"  value="" />
                      </div>
                    </div>
                  </div>
              </div>
          </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="id_terapia_mod" name="id_terapia_mod" value="">
                <button type="submit" class="btn btn-primary" id="btn-save" value="add">Salva </button>
                <button type="button" id="btn-close" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
      </form>
        </div>
    </div>
</div>

<!-- MODAL INFO FARMACO -->

<div class="modal fade" id="infoFarmacoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><strong>Informazioni Farmaco</strong></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <h5><strong>Nome Farmaco</strong></h5>
            <p id="nomeFarmacoTxt"></p>
            <hr>
            <h5><strong>ATC</strong></h5>
            <p id="atcTxt"></p>
            <hr>
            <h5><strong>Forma Farmaceutica</strong></h5>
            <p id="formaFarmaceuticaTxt"></p>
            <hr>
            <h5><strong>Tipologia Somministrazione</strong></h5>
            <p id="tipologiaSomministrazioneTxt"></p>
            <hr>
            <h5><strong>Principio Attivo</strong></h5>
            <p id="principioAttvoTxt"></p>
            <hr>

        </div>
      <div class="modal-footer">
        <button type="button" id="btn-close" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL MSG TERAPIE -->

<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{action('TerapieController@spostaTerapia')}}" method="POST" id="msgModalFormData" name="msgModalFormData" class="form-horizontal" novalidate="" style="margin-bottom: 0px;">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="msgLabel"><strong>Sposta Terapia</strong></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">

                <p id="msgTxt"></p>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="id_terapia_msg" name="id_terapia_msg" value="">
          <button type="submit" class="btn btn-primary">Conferma</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- MODAL NUOVA DIAGNOSI -->
<div class="modal fade" id="nuovaDiagnosiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="formD"  class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuova Diagnosi</h4>
        </div>
        <div class="modal-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label col-lg-4">Diagnosi *</label>
                            <div class="col-lg-8">
                                <input id="nomeD" type="text" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label col-lg-4">Care provider *</label>
                            <div class="col-lg-8">
                                @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                    <input id="nomeCpD"
                                           value="{{$current_user->getName()}} {{$current_user->getSurname()}}"
                                           readonly class="form-control"/>
                                @else
                                    <select id="CppIdD" name="CppIdD" class="form-control">
                                        <option selected hidden style='display: none' value="notSelected">
                                            Selezionare un Care Providers..
                                        </option>
                                        <optgroup label="Care Providers">
                                            @foreach($current_user->cppAssociati() as $cp)
                                                <option><?php echo $cp->cpp_nome . " " . $cp->cpp_cognome ?></option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-lg-4">cpId:</label>
                            <div class="col-lg-4">
                                @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                    <input id="cpId" readonly value="$current_user->id_utente"
                                           class="form-control"/>
                                @else
                                    <input id="cpId" readonly value="-1" class="form-control"/>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-lg-4">pzId:</label>
                            <div class="col-lg-4">

                                <input id="pzId" readonly value="{{$current_user->idPazienteUser()}}"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="control-label col-lg-4">Stato *</label>
                            <div class="col-lg-8">
                                <select id="statoD" class="form-control">
                                    <option selected value="1">Sospetta</option>
                                    <option value="0">Confermata</option>
                                    <option value="2">Esclusa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
        <div class="modal-footer">
          <button type="button" id="concludiD" onclick="nuovaDiagnosi()" class="btn btn-primary" data-dismiss="modal">Conferma</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL SEARCH DIAGNOSI -->
<div class="modal fade" id="searchModal" tabindex="10" role="dialog" aria-labelledby="myModalLabel" style="z-index: 1039;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id="formSearch"  class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Cerca Terapia</h4>
        </div>
        <div class="modal-body">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="control-label col-lg-2">Cerca *</label>
                    <div class="col-lg-8">
                        <input id="txtCerca" type="text" class="form-control"/>
                    </div>
                    <div class="col-lg-8 pull-right">
                        <label class="radio-inline">
                          <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Motivo/Note
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Prescrittore
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3"> Farmaco
                        </label>
                    </div>
                </div>
                <p id="msg_search" class="alert alert-danger" style="display: none"> </p>
            </div>
            {{-- Tabella risultati Farmaci Vietati --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">Farmaci VIETATI</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th>Farmaco</th>
                                            <th>Principio Attivo</th>
                                            <th>ATC</th>
                                            <th >Data Evento</th>
                                            <th>Motivo</th>
                                            <th>Medico</th>
                                            <th>Opzioni</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_search0">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    </table>
                            </div>
                            <!--table responsive-->
                        </div>
                    </div>
                </div>
            </div>
            <!--row-->
            {{-- Tabella risultati Terapie in corso --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">Terapie in Corso</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th>Farmaco</th>
                                            <th>dal</th>
                                            <th>al</th>
                                            <th >Prescrittore</th>
                                            <th>Diagnosi</th>
                                            <th>Note</th>
                                            <th>Opzioni</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_search1">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    </table>
                            </div>
                            <!--table responsive-->
                        </div>
                    </div>
                </div>
            </div>
            <!--row-->
            {{-- Tabella risultati Terapie Concluse --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">Terapie Concluse</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th>Farmaco</th>
                                            <th>dal</th>
                                            <th>al</th>
                                            <th >Prescrittore</th>
                                            <th>Diagnosi</th>
                                            <th>Note</th>
                                            <th>Opzioni</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_search2">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    </table>
                            </div>
                            <!--table responsive-->
                        </div>
                    </div>
                </div>
            </div>
            <!--row-->
      </div>
        <div class="modal-footer">
          <button type="button" id="cerca" onclick="cercaTerapia()" class="btn btn-primary">Cerca</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>

jQuery('body').on('click', '.sposta', function () {
  var idTerapia = $(this).val();
    jQuery('#msgModalFormData').attr('action', "{{action('TerapieController@spostaTerapia')}}");
    jQuery('#id_terapia_msg').val(idTerapia);
    jQuery('#msgLabel').text("Sposta Terapia");
    jQuery('#msgTxt').text("Sicuro di voler spostare la terapia in terapie concluse?");
    jQuery('#msgModal').modal('show');

});

jQuery('body').on('click', '.elimina', function () {
  var idTerapia = $(this).val();
    jQuery('#msgModalFormData').attr('action', "{{action('TerapieController@eliminaTerapia')}}");
    jQuery('#id_terapia_msg').val(idTerapia);
    jQuery('#msgLabel').text("Elimina Terapia");
    jQuery('#msgTxt').text("Sicuro di voler eliminare la terapia?");
    jQuery('#msgModal').modal('show');

});


</script>

<script src="{{ asset('js/formscripts/terapie.js') }}"></script>

<!--END PAGE CONTENT -->

@endsection