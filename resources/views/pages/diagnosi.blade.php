@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Diagnosi')
@section('content')
    <!--PAGE CONTENT -->

    <div id="content">
        <div class="inner" style="min-height:1200px;">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Elenco diagnosi</h2>
                    <hr>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
                    <script src="formscripts/jquery.js"></script>
                    <script src="formscripts/jquery-ui.js"></script>
                    <script src="formscripts/diagnosi.js"></script>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="btn-group">
                                <button class="btn btn-primary" id="nuovaD"><i class="icon-stethoscope"></i> Nuova
                                    diagnosi
                                </button>
                                <button class="btn btn-primary" id="concludiD" onclick="nuovaDiagnosi()"><i
                                            class="icon-ok-sign"></i> Concludi diagnosi
                                </button>
                                <button class="btn btn-primary" id="annullaD"><i class="icon-trash"></i> Annulla
                                    diagnosi
                                </button>

                            </div>
                        </div>
                    </div>
                    <br>

                    <script>

                        $('#concludiD').prop('disabled', true);
                        $('#annullaD').prop('disabled', true);


                        $("#nuovaD").click(function () {

                            $("#formD").show(200);
                            $('#nuovaD').prop('disabled', true);
                            $('#concludiD').prop('disabled', false);
                            $('#annullaD').prop('disabled', false);
                        });

                        $("#annullaD").click(function () {
                            $("#formD").hide(200);
                            $('#nuovaD').prop('disabled', false);
                            $('#concludiD').prop('disabled', true);
                            $('#annullaD').prop('disabled', true);
                        });

                        //permette di visaulizzare l'input text 'nuovo careprovider' nel form della nuova indagine
                        function altroCpp(selectName, inputName) {
                            var cpp = document.getElementById(selectName).value;
                            if (cpp == -1) {
                                document.getElementById(inputName).type = "text";
                            } else {
                                document.getElementById(inputName).type = "hidden";
                            }
                        }

                        //permette di salvare una nuova diagnosi
                        function nuovaDiagnosi() {

                            var stato = document.getElementById("statoD").value;
                            var Cpp = document.getElementById("CppIdD").value;
                            var idPaz = document.getElementById("pzId").value;
                            var patol = document.getElementById("nomeD").value;

                            /*var CppSelect = document.getElementById("CppIdD");
                            var idCpp = CppSelect.options[CppSelect.selectedIndex].id;*/

                            if (Cpp == -1) {
                                Cpp = document.getElementById("cppAltro_new").value;
                                idCpp = 0;
                            }

                            if (patol == '' || Cpp == 'notSelected' || stato == '') {
                                alert("Compilare tutti i campi");

                            } else {
                                window.location.href = "/addDiagn/" + stato + "/" + Cpp + "/" + idPaz + "/" + patol;
                                $('#formD')[0].reset();

                            }

                        }

                        //permette di aprire il form per la modifica di una diagnosi
                        $(document).on('click', "button.modifica", function () {
                            $(this).prop('disabled', true);
                            $('#' + $(this).attr('id') + '.elimina').prop('disabled', true);
                            var idForm = '#form' + $(this).attr('id');

                            $(idForm).show(200);
                        });

                        //gestisce l'eliminazione di una diagnosi
                        $(document).on('click', "button.elimina", function () {

                            var idDia = $(this).attr('id');

                            var idUt = {{($current_user->data_patient()->first()->id_utente)}};

                            var href = "/del/" + idDia + "/" + idUt;

                            if (confirm("Confermi di voler eliminare la diagnosi selezionata? (Le indagini ad essa associate saranno mantenute)")) {
                                window.location.href = href;
                            } else {
                                windows.location.reload();
                            }
                        });

                    </script>

					{{--Form inserimento nuova diagnosi--}}
                    <form id="formD" style="display:none" class="form-horizontal">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Diagnosi *</label>
                                        <div class="col-lg-4">
                                            <input id="nomeD" type="text" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Care provider *</label>
                                        <div class="col-lg-4">
                                            @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                <input id="nomeCpD"
                                                       value="{{$current_user->getName()}} {{$current_user->getSurname()}}"
                                                       readonly class="form-control"/>
                                            @else
                                                <select id="CppIdD" name="CppIdD" class="form-control"
                                                        onchange="altroCpp('CppIdD', 'cppAltro_new')">
                                                    <option selected hidden style='display: none' value="notSelected">
                                                        Selezionare un Care Providers..
                                                    </option>
                                                    <optgroup label="Care Providers">
                                                        @foreach($current_user->cppAssociati() as $cp)
                                                            <option><?php echo $cp->cpp_nome . " " . $cp->cpp_cognome ?></option>
                                                        @endforeach
                                                    </optgroup>
                                                    <option value="-1">Nuovo Care Providers..</option>
                                                </select>
                                                <input id="cppAltro_new" name="cppAltro_new" type="hidden"
                                                       placeholder="Inserire CareProvider" class="form-control"/>
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
                                        <div class="col-lg-4">
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
                    </form>
                    <br>

					{{--Form Diagnosi Confermate--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-danger">
                                <div class="panel-heading">Confermate</div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" id="tableConfermate">
                                            <thead>
                                            <tr>
                                                <th>Diagnosi</th>
                                                <th>Ultimo aggiornamento</th>
                                                <th>Care provider</th>
                                                <th style="text-align:center; min-width: 80px;">Opzioni</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($current_user->diagnosi() as $ind)
                                                @if($ind->diagnosi_stato == 0)
                                                    <tr>
                                                        <td>{{$ind->diagnosi_patologia}}</td>
                                                        <td><?php echo date('d/m/y', strtotime($ind->diagnosi_aggiornamento_data)); ?></td>
                                                        <?php $cpp = $current_user->getCppDiagnosi($ind->id_diagnosi)->careprovider?>
                                                        <?php $cpp = explode("-", $cpp)?>
                                                        <?php $cpp = str_replace('/', '', $cpp)?>
                                                        <td>
                                                            @foreach($cpp as $c)
                                                                {{$c}}<br>
                                                            @endforeach
                                                        </td>
                                                        <td style="text-align:center">
                                                            <button id="{{($ind->id_diagnosi)}}"
                                                                    class="modifica btn btn-success "><i
                                                                        class="icon-pencil icon-white"></i>
                                                            </button>
                                                            <button id="{{($ind->id_diagnosi)}}"
                                                                    class="elimina btn btn-danger"><i
                                                                        class="icon-remove icon-white"></i>
                                                            </button>
                                                        </td>

                                                    <tr id="rigaModC">
                                                        <td colspan="7">
                                                            <form id="form{{($ind->id_diagnosi)}}" style="display:none"
                                                                  class="form-horizontal">
                                                                <div class="tab-content">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">Care
                                                                                    provider:</label>
                                                                                <div class="col-lg-4">
                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                        <input id="nomeCpC"
                                                                                               value="{{$current_user->getName()}} {{$current_user->getSurname()}}"
                                                                                               readonly
                                                                                               class="form-control"/>
                                                                                    @else
                                                                                        <select id="cpp{{($ind->id_diagnosi)}}"
                                                                                                name="cpp{{($ind->id_diagnosi)}}"
                                                                                                class="form-control"
                                                                                                onchange="altroCpp('cpp{{($ind->id_diagnosi)}}', 'cppAltro_new{{($ind->id_diagnosi)}}')">
                                                                                            <option selected hidden
                                                                                                    style='display: none'
                                                                                                    value="notSelected">
                                                                                                Selezionare un Care
                                                                                                Providers..
                                                                                            </option>
                                                                                            <optgroup
                                                                                                    label="Care Providers">
                                                                                                @foreach($current_user->cppAssociati() as $cp)
                                                                                                    <option><?php echo $cp->cpp_nome . " " . $cp->cpp_cognome ?></option>
                                                                                                @endforeach
                                                                                            </optgroup>
                                                                                            <option value="-1">Nuovo
                                                                                                Care Providers..
                                                                                            </option>
                                                                                        </select>
                                                                                        <input id="cppAltro_new{{($ind->id_diagnosi)}}"
                                                                                               name="cppAltro_new{{($ind->id_diagnosi)}}"
                                                                                               type="hidden"
                                                                                               placeholder="Inserire CareProvider"
                                                                                               class="form-control"/>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12" style="display:none;">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">cpId:</label>
                                                                                <div class="col-lg-4">
                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                        <input id="cpIdC" readonly
                                                                                               value="$current_user->id_utente"
                                                                                               class="form-control"/>
                                                                                    @else
                                                                                        <input id="cpIdC" readonly
                                                                                               value="-1"
                                                                                               class="form-control"/>
                                                                                    @endif

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12" style="display:none;">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">pzId:</label>
                                                                                <div class="col-lg-4">

                                                                                    <input id="pzIdC" readonly
                                                                                           value="{{$current_user->idPazienteUser()}}"
                                                                                           class="form-control"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">Stato:</label>
                                                                                <div class="col-lg-4">
                                                                                    <select id="stato{{($ind->id_diagnosi)}}"
                                                                                            class="form-control">
                                                                                        <option value="1">Sospetta
                                                                                        </option>
                                                                                        <option selected value="0">
                                                                                            Confermata
                                                                                        </option>
                                                                                        <option value="2">Esclusa
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div style="text-align:center;">
                                                                            <button class="btn btn-danger"
                                                                                    onclick="annullaC()"><i
                                                                                        class="icon icon-undo"></i>
                                                                                Annulla modifiche
                                                                            </button>
                                                                            <a href="" onclick="return false;"
                                                                               class=conferma
                                                                               data-id="{{($ind->id_diagnosi)}}">
                                                                                <button class="btn btn-success"><i
                                                                                            class="icon icon-check"></i>
                                                                                    Conferma modifiche
                                                                                </button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <script>

                                            //gestisce la conferma dei dati per la modifica di una diagnosi
                                            $(document).on('click', "a.conferma", function () {
                                                var id = $(this).attr('data-id');
                                                var stato = $('#stato' + id).val();
                                                var cpp = $('#cpp' + id).val();
                                                window.location.href = "/modDiagn/" + id + "/" + stato + "/" + cpp;
                                                $('#formD')[0].reset();
                                            });


                                        </script>
                                    </div><!--table responsive-->
                                </div>
                            </div>
                        </div>
                    </div><!--row-->

					{{--Form Diagnosi Sospette--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-warning">
                                <div class="panel-heading">Sospette</div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" id="tableSospette">
                                            <thead>
                                            <tr>
                                                <th>Diagnosi</th>
                                                <th>Ultimo aggiornamento</th>
                                                <th>Care provider</th>
                                                <th style="text-align:center; min-width: 80px;">Opzioni</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($current_user->diagnosi() as $ind)
                                                @if($ind->diagnosi_stato == 1)
                                                    <tr>
                                                        <td>{{$ind->diagnosi_patologia}}</td>
                                                        <td><?php echo date('d/m/y', strtotime($ind->diagnosi_aggiornamento_data)); ?></td>
                                                        <?php $cpp = $current_user->getCppDiagnosi($ind->id_diagnosi)->careprovider?>
                                                        <?php $cpp = explode("-", $cpp)?>
                                                        <?php $cpp = str_replace('/', '', $cpp)?>
                                                        <td>
                                                            @foreach($cpp as $c)
                                                                {{$c}}<br>
                                                            @endforeach
                                                        </td>
                                                        <td style="text-align:center">
                                                            <button id="{{($ind->id_diagnosi)}}"
                                                                    class="modifica btn btn-success "><i
                                                                        class="icon-pencil icon-white"></i>
                                                            </button>
                                                            <button id="{{($ind->id_diagnosi)}}"
                                                                    class="elimina btn btn-danger"><i
                                                                        class="icon-remove icon-white"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr id="rigaModS">
                                                        <td colspan="7">
                                                            <form id="form{{($ind->id_diagnosi)}}" style="display:none"
                                                                  class="form-horizontal">
                                                                <div class="tab-content">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">Care
                                                                                    provider:</label>
                                                                                <div class="col-lg-4">
                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                        <input id="nomeCpS"
                                                                                               value="{{$current_user->getName()}} {{$current_user->getSurname()}}"
                                                                                               readonly
                                                                                               class="form-control"/>
                                                                                    @else
                                                                                        <select id="cpp{{($ind->id_diagnosi)}}"
                                                                                                name="cpp{{($ind->id_diagnosi)}}"
                                                                                                class="form-control"
                                                                                                onchange="altroCpp('cpp{{($ind->id_diagnosi)}}', 'cppAltro_new{{($ind->id_diagnosi)}}')">
                                                                                            <option selected hidden
                                                                                                    style='display: none'
                                                                                                    value="notSelected">
                                                                                                Selezionare un Care
                                                                                                Providers..
                                                                                            </option>
                                                                                            <optgroup
                                                                                                    label="Care Providers">
                                                                                                @foreach($current_user->cppAssociati() as $cp)
                                                                                                    <option><?php echo $cp->cpp_nome . " " . $cp->cpp_cognome ?></option>
                                                                                                @endforeach
                                                                                            </optgroup>
                                                                                            <option value="-1">Nuovo
                                                                                                Care Providers..
                                                                                            </option>
                                                                                        </select>
                                                                                        <input id="cppAltro_new{{($ind->id_diagnosi)}}"
                                                                                               name="cppAltro_new{{($ind->id_diagnosi)}}"
                                                                                               type="hidden"
                                                                                               placeholder="Inserire CareProvider"
                                                                                               class="form-control"/>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12" style="display:none;">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">cpId:</label>
                                                                                <div class="col-lg-4">
                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                        <input id="cpIdS" readonly
                                                                                               value="$current_user->id_utente"
                                                                                               class="form-control"/>
                                                                                    @else
                                                                                        <input id="cpIdS" readonly
                                                                                               value="-1"
                                                                                               class="form-control"/>
                                                                                    @endif

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12" style="display:none;">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">pzId:</label>
                                                                                <div class="col-lg-4">

                                                                                    <input id="pzIdS" readonly
                                                                                           value="{{$current_user->idPazienteUser()}}"
                                                                                           class="form-control"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">Stato:</label>
                                                                                <div class="col-lg-4">
                                                                                    <select id="stato{{($ind->id_diagnosi)}}"
                                                                                            class="form-control">
                                                                                        <option selected value="1">
                                                                                            Sospetta
                                                                                        </option>
                                                                                        <option value="0">Confermata
                                                                                        </option>
                                                                                        <option value="2">Esclusa
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div style="text-align:center;">
                                                                            <button class="btn btn-danger" onclick=""><i
                                                                                        class="icon icon-undo"></i>
                                                                                Annulla modifiche
                                                                            </button>
                                                                            <a href="" onclick="return false;"
                                                                               class=conferma
                                                                               data-id="{{($ind->id_diagnosi)}}">
                                                                                <button id="confMod"
                                                                                        class="btn btn-success"><i
                                                                                            class="icon icon-check"></i>
                                                                                    Conferma modifiche
                                                                                </button>
                                                                            </a></div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>

                                                @endif
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    <!--panelwarning-->
                        </div>    <!--col lg12-->
                    </div>

					{{--Form Diagnosi Escluse--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">Escluse</div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" id="tableEscluse">
                                            <thead>
                                            <tr>
                                                <th>Diagnosi</th>
                                                <th>Ultimo aggiornamento<br/></th>
                                                <th>Care provider</th>
                                                <th style="text-align:center; min-width: 80px;">Opzioni</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($current_user->diagnosi() as $ind)
                                                @if($ind->diagnosi_stato == 2)
                                                    <tr>
                                                        <td>{{$ind->diagnosi_patologia}}</td>
                                                        <td><?php echo date('d/m/y', strtotime($ind->diagnosi_aggiornamento_data)); ?></td>
                                                        <?php $cpp = $current_user->getCppDiagnosi($ind->id_diagnosi)->careprovider?>
                                                        <?php $cpp = explode("-", $cpp)?>
                                                        <?php $cpp = str_replace('/', '', $cpp)?>
                                                        <td>
                                                            @foreach($cpp as $c)
                                                                {{$c}}<br>
                                                            @endforeach
                                                        </td>
                                                        <td style="text-align:center">
                                                            <button id="{{($ind->id_diagnosi)}}"
                                                                    class="modifica btn btn-success "><i
                                                                        class="icon-pencil icon-white"></i>
                                                            </button>
                                                            <button id="{{($ind->id_diagnosi)}}"
                                                                    class="elimina btn btn-danger"><i
                                                                        class="icon-remove icon-white"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr id="rigaModE">
                                                        <td colspan="7">
                                                            <form id="form{{($ind->id_diagnosi)}}" style="display:none"
                                                                  class="form-horizontal">
                                                                <div class="tab-content">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">Care
                                                                                    provider:</label>
                                                                                <div class="col-lg-4">
                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                        <input id="nomeCpE"
                                                                                               value="{{$current_user->getName()}} {{$current_user->getSurname()}}"
                                                                                               readonly
                                                                                               class="form-control"/>
                                                                                    @else
                                                                                        <select id="cpp{{($ind->id_diagnosi)}}"
                                                                                                name="cpp{{($ind->id_diagnosi)}}"
                                                                                                class="form-control"
                                                                                                onchange="altroCpp('cpp{{($ind->id_diagnosi)}}', 'cppAltro_new{{($ind->id_diagnosi)}}')">
                                                                                            <option selected hidden
                                                                                                    style='display: none'
                                                                                                    value="notSelected">
                                                                                                Selezionare un Care
                                                                                                Providers..
                                                                                            </option>
                                                                                            <optgroup
                                                                                                    label="Care Providers">
                                                                                                @foreach($current_user->cppAssociati() as $cp)
                                                                                                    <option><?php echo $cp->cpp_nome . " " . $cp->cpp_cognome ?></option>
                                                                                                @endforeach
                                                                                            </optgroup>
                                                                                            <option value="-1">Nuovo
                                                                                                Care Providers..
                                                                                            </option>
                                                                                        </select>
                                                                                        <input id="cppAltro_new{{($ind->id_diagnosi)}}"
                                                                                               name="cppAltro_new{{($ind->id_diagnosi)}}"
                                                                                               type="hidden"
                                                                                               placeholder="Inserire CareProvider"
                                                                                               class="form-control"/>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12" style="display:none;">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">cpId:</label>
                                                                                <div class="col-lg-4">
                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                        <input id="cpIdE" readonly
                                                                                               value="$current_user->id_utente"
                                                                                               class="form-control"/>
                                                                                    @else
                                                                                        <input id="cpIdE" readonly
                                                                                               value="-1"
                                                                                               class="form-control"/>
                                                                                    @endif

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12" style="display:none;">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">pzId:</label>
                                                                                <div class="col-lg-4">

                                                                                    <input id="pzIdE" readonly
                                                                                           value="{{$current_user->idPazienteUser()}}"
                                                                                           class="form-control"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-lg-4">Stato:</label>
                                                                                <div class="col-lg-4">
                                                                                    <select id="stato{{($ind->id_diagnosi)}}"
                                                                                            class="form-control">
                                                                                        <option value="1">Sospetta
                                                                                        </option>
                                                                                        <option value="0">Confermata
                                                                                        </option>
                                                                                        <option selected value="2">
                                                                                            Esclusa
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div style="text-align:center;">
                                                                            <button class="btn btn-danger" onclick=""><i
                                                                                        class="icon icon-undo"></i>
                                                                                Annulla modifiche
                                                                            </button>
                                                                            <a href="" onclick="return false;"
                                                                               class=conferma
                                                                               data-id="{{($ind->id_diagnosi)}}">
                                                                                <button id="confMod"
                                                                                        class="btn btn-success"><i
                                                                                            class="icon icon-check"></i>
                                                                                    Conferma modifiche
                                                                                </button>
                                                                            </a></div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>

                                                @endif
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>    <!--panelbody-->
                            </div>
                        </div>    <!--col lg12-->
                    </div><!--row-->
                </div>
            </div>
            <hr/>
        </div>


    </div>


    <!--END PAGE CONTENT -->

@endsection
