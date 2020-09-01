@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Indagini')
@section('content')
    <!--PAGE CONTENT -->
    <!--nella pagina vengono riportate in sezioni diverse le indagini diagnostiche richieste nella pagina "indagini richieste",
    le indagini diagnostiche programmate , quelle effettuate, quelle refertate,queste devono essere evidenziabili
    se rilevanti per la storiaclinica -->


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="assets/js/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="formscripts/jquery-ui.js"></script>
    <script src="formscripts/indagini.js"></script>

    <div id="content">
        <div class="inner" style="min-height:1200px;">
            <div class="row">
                <div class="col-lg-12">

                    <hr>
                    <h2>Indagini diagnostiche</h2>
                    <hr/>

                    <!-- ACCORDION -->
                    <div class="panel-group ac" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading row">
                                <div class="col-lg-6">
                                    <h3><a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="icon-book"></i>
                                            Diario indagini diagnostiche</a></h3>
                                </div>
                                <div class="col-lg-6">
                                    <h3><a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-map-marker"></i>
                                            Centri indagini diagnostiche</a></h3>
                                </div>
                            </div>

                            <!-- COLLAPSE DIARIO INDAGINI DIAGNOSTICHE -->
                            <div id="collapse1" class="panel-collapse collapse in"><hr/>

                                <!-- FORM NUOVA INDAGINE -->
                                <div class="row">
                                    <div class="col-lg-12" >
                                        <div class="btn-group">
                                            <button class="btn btn-primary" id="nuovoFile"><i class="icon-file-text-alt"></i> Nuova indagine</button>
                                            <button class="btn btn-primary" id="concludi" onclick="nuovaIndagine()"><i class="icon-ok-sign"></i> Concludi indagine</button>
                                            <button class="btn btn-primary" id="annulla"><i class="icon-trash"></i> Annulla indagine</button>
                                        </div>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    //inizializzo la variabile che conta le motivazioni per le nuove indagini
                                    var motivazioni = 1;

                                    $('#concludi').prop('disabled',true);
                                    $('#annulla').prop('disabled',true);

                                    $('#nomeCp').prop('disabled',true);
                                    $('#cognomeCp').prop('disabled',true);

                                    $('#responso').prop('disabled',true);

                                    $('#formModal').on('shown.bs.modal', function() {});

                                    $("#nuovoFile").click(function()
                                    {
                                        $("#formIndagini").show(200);
                                        $('#nuovoFile').prop('disabled',true);
                                        $('#concludi').prop('disabled',false);
                                        $('#annulla').prop('disabled',false);
                                    });

                                    $("#annulla").click(function()
                                    {
                                        $("#formIndagini").hide(200);
                                        $('#nuovoFile').prop('disabled',false);
                                        $('#concludi').prop('disabled',true);
                                        $('#annulla').prop('disabled',true);
                                    });

                                    //imposta il form della nuova indagine in base allo stato selezionato
                                    function stato()
                                    {
                                        var stato = document.getElementById("statoIndagine_new").value;

                                        if(stato == 0){
                                            document.getElementById("divCentro_new").style.display = 'none';
                                            document.getElementById("divData_new").style.display = 'none';
                                            document.getElementById("divReferto_new").style.display = 'none';
                                            document.getElementById("divAllegato_new").style.display = 'none';
                                        }
                                        if(stato == 1){
                                            document.getElementById("divCentro_new").style.display = 'block';
                                            document.getElementById("divData_new").style.display = 'block';
                                            document.getElementById("divReferto_new").style.display = 'none';
                                            document.getElementById("divAllegato_new").style.display = 'none';
                                        }
                                        if(stato == 2){
                                            document.getElementById("divCentro_new").style.display = 'block';
                                            document.getElementById("divData_new").style.display = 'block';
                                            document.getElementById("divReferto_new").style.display = 'block';
                                            document.getElementById("divAllegato_new").style.display = 'block';
                                        }
                                    }

                                    //permette di visaulizzare l'input text 'altra motivazione' nel form della nuova indagine
                                    function altraMotivazione(id)
                                    {
                                        var motivo = document.getElementById("motivoIndagine_new" + id).value;
                                        if(motivo == 0){
                                            document.getElementById("motivoAltro_new" + id).type = "text";
                                        }
                                        else{
                                            document.getElementById("motivoAltro_new" + id).type = "hidden";
                                        }
                                    }

                                    //permette di visaulizzare l'input text 'nuovo careprovider' nel form della nuova indagine
                                    function altroCpp()
                                    {
                                        var cpp = document.getElementById("cppIndagine_new").value;
                                        if(cpp == -1){
                                            document.getElementById("cppAltro_new").type = "text";
                                        }
                                        else{
                                            document.getElementById("cppAltro_new").type = "hidden";
                                        }
                                    }

                                    //permette di inserire una nuova indagine
                                    function nuovaIndagine() {
                                        //assegno i tipi di motivazioni all'array
                                        var tipoDiagnosi = new Array(motivazioni);
                                        for (i = 1; i <= motivazioni; i++) {
                                            if (document.getElementById('radioSospetta' + String(i)).checked) {
                                                tipoDiagnosi[i - 1] = 1;
                                            } else if (document.getElementById('radioConfermata' + String(i)).checked) {
                                                tipoDiagnosi[i - 1] = 0;
                                            }
                                        }

                                        var tipo = document.getElementById("tipoIndagine").value;

                                        //viene controllato se è stato inserito un nuovo care provider
                                        if (document.getElementById("cppIndagine_new").value == -1) {
                                            var Cpp = document.getElementById("cppAltro_new").value;
                                            var idCpp = 0;
                                        } else {
                                            var Cpp = document.getElementById("cppIndagine_new").value;
                                            var options = cppIndagine_new.options;
                                            var idCpp = options[options.selectedIndex].id;
                                        }
                                        var idPaz = document.getElementById("idPaziente").value;
                                        var stato = document.getElementById("statoIndagine_new").value;
                                        var centro = $("#centroIndagine_new").find('option:selected').attr('id');
                                        var dataVis = document.getElementById("addIndagineData").value;

                                        //controllo che siano inserite tutte le motivazioni e le inserisco nell'array
                                        var motivo = new Array(motivazioni);
                                        var motiviValidi = true;
                                        var motiviRipetuti = false;
                                        for (i = 1; i <= motivazioni; i++) {
                                            //viene controllato se è stata inserita una nuova motivazione
                                            if (document.getElementById("motivoIndagine_new" + String(i)).value == 0) {
                                                var motivoAltro = document.getElementById("motivoAltro_new" + String(i)).value;
                                                if ((motivoAltro == "")) {
                                                    motiviValidi = false;
                                                }else if(motivo.includes(motivoAltro)){
                                                    motiviRipetuti = true;
                                                }
                                                else {
                                                    //se è stata inserita una nuova motivazione viene affiancato al nome, la data 0
                                                    // che servirà per identificare la nuova motivazione in IndaginiController
                                                    motivo[i - 1] = motivoAltro + "--0";
                                                }
                                            } else {
                                                var motivoIndagine = document.getElementById("motivoIndagine_new" + String(i)).value;
                                                if ((motivoIndagine == "")) {
                                                    motiviValidi = false;
                                                }else if(motivo.includes(motivoIndagine)){
                                                    motiviRipetuti = true;
                                                }
                                                else {
                                                    motivo[i - 1] = motivoIndagine;
                                                }
                                            }
                                        }

                                        if ((!campiVuoti()) || (motiviValidi)){
                                            if(motiviRipetuti){
                                                alert("Sono state inserite motivazioni uguali");
                                            }else
                                            {
                                                if (stato == '0') {
                                                    window.location.href = "/addIndRichiesta/" + tipo + "/" + tipoDiagnosi + "/" + motivo + "/" + Cpp + "/" + idCpp + "/" + idPaz + "/" + stato;
                                                    $('#formIndagini')[0].reset();
                                                }

                                                if (stato == '1') {
                                                    window.location.href = "/addIndProgrammata/" + tipo + "/" + tipoDiagnosi + "/" + motivo + "/" + Cpp + "/" + idCpp + "/" + idPaz + "/" + stato + "/" + centro + "/" + dataVis;
                                                    $('#formIndagini')[0].reset();
                                                }

                                                if (stato == '2') {
                                                    var referto = document.getElementById("referto1Id").value;
                                                    if (referto == "") referto = null;
                                                    var i = 1;
                                                    var flag = false;
                                                    var allegato = "";
                                                    while (i <= 10 && !flag) {
                                                        if (document.getElementById("allegato" + i + "Id").value != "") {
                                                            allegato += document.getElementById("allegato" + i + "Id").value + "-";
                                                            i++;
                                                        } else {
                                                            flag = true;
                                                            if (allegato != "") allegato = allegato.substring(0, allegato.length - 1);
                                                            else allegato = null;
                                                        }
                                                    }

                                                    window.location.href = "/addIndCompletata/" + tipo + "/" + tipoDiagnosi + "/" + motivo + "/" + Cpp + "/" + idCpp + "/" + idPaz + "/" + stato + "/" + centro + "/" + dataVis + "/" + referto + "/" + allegato + "/" + "final";
                                                    $('#formIndagini')[0].reset();
                                                }
                                            }
                                        }else{
                                            alert("Inserire tutti i campi");
                                        }
                                    }

                                    //funzione che controlla che i campi di una nuova indagine siano vuoti
                                    function campiVuoti()
                                    {
                                        var tipo = document.getElementById("tipoIndagine").value;

                                        if(document.getElementById("cppIndagine_new").value == -1){
                                            var Cpp = document.getElementById("cppAltro_new").value;
                                            var idCpp = 0;
                                        }else{
                                            var Cpp = document.getElementById("cppIndagine_new").value;
                                            var options = cppIndagine_new.options;
                                            var idCpp = options[options.selectedIndex].id;
                                        }
                                        var idPaz = document.getElementById("idPaziente").value;
                                        var stato = document.getElementById("statoIndagine_new").value;
                                        var centro = $("#centroIndagine_new").find('option:selected').attr('id');
                                        var dataVis = document.getElementById("addIndagineData").value;

                                        if(stato == '0'){
                                            if((tipo == '') || (Cpp == '') || (idPaz == '' || stato == '')){
                                                return true;
                                            }
                                        }

                                        if(stato == '1'){
                                            if((tipo == '') || (Cpp == '') || (idPaz == '' || stato == '') || (centro == ''|| dataVis=='')){
                                                return true;
                                            }
                                        }

                                        if(stato == '2'){
                                            if((tipo == '') || (Cpp == '') || (idPaz == '' || stato == '') || (centro == ''|| dataVis=='')){
                                                return true;
                                            }
                                        }

                                        return false;
                                    }

                                    //permette di aggiungere più motivazioni (diagnosi)
                                    function nuovaMotivazione()
                                    {
                                        motivazioni++;
                                        if(motivazioni <= 10) {
                                            document.getElementById('divMotivazione' + motivazioni).style.display="block";
                                            document.getElementById('eliminaMotivo').disabled=false;
                                        }else{
                                            document.getElementById('aggiungiMotivo').disabled=true;
                                            motivazioni = 10;
                                        }


                                        //$(function()  {
                                          //  $('#aggiungiMotivo').click(function(){
                                            //    var content = $('#divMotivazione').html();
                                                //var newdiv = $("<div>");
                                              //  newdiv.html(content);
                                                //$('#divMotivazione').after(newdiv);
                                            //});
                                        //});

                                    }

                                    //permette di eliminare l'ultima motivazione aggiunta
                                    function eliminaMotivazione() {
                                        if (motivazioni <= 10) {
                                            document.getElementById('divMotivazione' + motivazioni).style.display = "none";
                                            motivazioni--;
                                        }
                                        if (motivazioni == 1) {
                                            document.getElementById('eliminaMotivo').disabled = true;
                                            document.getElementById('aggiungiMotivo').disabled = false;
                                        }
                                    }

                                    //gestisce le button per la modifica
                                    $(document).on('click', "button.modifica", function ()
                                    {
                                        $(this).prop('disabled', true);
                                        $('#'+$(this).attr('id')+'.elimina').prop('disabled', true);
                                        var id = '#form'+$(this).attr('id');
                                        $(id).show(200);
                                    });

                                    //gestisce le button per l'eliminazione
                                    $(document).on('click', "button.elimina", function ()
                                    {
                                        var idInd = $(this).attr('id');
                                        var idUt = {{($current_user->data_patient()->first()->id_utente)}};
                                        var href="/delInd/"+idInd+"/"+idUt;
                                        if(confirm("Confermi di voler eliminare l'indagine?")){
                                            window.location.href=href;
                                        }
                                        else{
                                            windows.location.reload();
                                        }
                                    });

                                    //gestisce le button per confermare la modifica
                                    $(document).on('click', "a.conferma", function ()
                                    {
                                        var id = $(this).attr('data-id');
                                        var operationType =  $(this).attr('data-mod');
                                        var tipo = $('#tipoIndagine'+id).val();
                                        var motivo = $('#motivoIndagine_new'+id).val();
                                        if(motivo == 0){
                                            motivo = $('#motivoAltro_new'+id).val();
                                        }
                                        else{
                                            motivo = $('#motivoIndagine_new'+id).val();
                                        }

                                        var href;
                                        var Cpp = $("#cppIndagine_new"+id).val();
                                        var idCpp = $("#cppIndagine_new"+id).find('option:selected').attr('id');

                                        if(idCpp == ''){
                                            idCpp = 0;
                                        }
                                        if(Cpp == -1){
                                            Cpp = $("#cppAltro_new"+id).val();
                                            idCpp = 0;
                                        }

                                        var idPaz = $("#idPaziente"+id).val();
                                        var stato = $("#statoIndagine_new"+id).val();
                                        var centro = $("#centroIndagine_new"+id).find('option:selected').attr('id');
                                        var dataVis = $("#date"+id).val();

                                        if (document.getElementById('radioSospetta_new'+id).checked) {
                                            tipoDiagnosi = 1;
                                        }
                                        else if(document.getElementById('radioConfermata_new'+id).checked)
                                        {
                                            tipoDiagnosi = 0;
                                        }

                                        if(stato == '0'){
                                            if((tipo == '' || motivo == '') || (Cpp == '') || (idPaz == '' || stato == '')){
                                                alert("Inserire tutti i campi");
                                            }
                                            else {
                                                href = "/ModIndRichiesta/"+id+"/"+tipo+"/"+tipoDiagnosi+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato;
                                            }
                                        }

                                        if(stato == '1'){
                                            if((tipo == '' || motivo == '') || (Cpp == '') || (idPaz == '' || stato == '') || (centro == ''|| dataVis=='')){
                                                alert("Inserire tutti i campi");
                                            }
                                            else{
                                                href = "/ModIndProgrammata/"+id+"/"+tipo+"/"+tipoDiagnosi+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato+"/"+centro+"/"+dataVis;
                                            }
                                        }

                                        if(stato == '2'){
                                            if((tipo == '' || motivo == '') || (Cpp == '') || (idPaz == '' || stato == '') || (centro == ''|| dataVis=='')){
                                                alert("Inserire tutti i campi");
                                            }
                                            else
                                            {
                                                var referto = document.getElementById("referto_new"+id+"Id").value;
                                                if(referto=="") referto = null;
                                                var i=1;
                                                var flag = false;
                                                var allegato="";

                                                while(i<=10 && !flag)
                                                {
                                                    if(document.getElementById("allegato_new"+operationType+i+"Id").value != "")
                                                    {
                                                        allegato+=document.getElementById("allegato_new"+operationType+i+"Id").value+"-";
                                                        i++;
                                                    }
                                                    else
                                                    {
                                                        flag = true;
                                                        if(allegato != "") allegato = allegato.substring(0, allegato.length-1);
                                                        else allegato = null;
                                                    }
                                                }


                                                href = "/ModIndCompletata/"+id+"/"+tipo+"/"+tipoDiagnosi+"/"+motivo+"/"+Cpp+"/"+idCpp+"/"+idPaz+"/"+stato+"/"+centro+"/"+dataVis+"/"+referto+"/"+allegato;
                                            }
                                        }
                                        window.location.href=href;
                                    });

                                    $(function(){
                                        $('input[type=radio][name=radioTipo1]').change(function () {
                                            var motivo = "#motivoIndagine_new1";
                                            var nameRadio = "radioTipo1";
                                            var radio = $('input[type=radio][name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            @foreach($current_user->diagnosi() as $d)
                                            if (radio == "Sospetta") {
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                            } else{
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                            }
                                            @endforeach
                                          $(motivo).append("</optgroup>");
                                          $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                      });
                                        $('input[type=radio][name=radioTipo2]').change(function () {
                                            var motivo = "#motivoIndagine_new2";
                                            var nameRadio = "radioTipo2";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo3]').change(function () {
                                            var motivo = "#motivoIndagine_new3";
                                            var nameRadio = "radioTipo3";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo4]').change(function () {
                                            var motivo = "#motivoIndagine_new4";
                                            var nameRadio = "radioTipo4";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo5]').change(function () {
                                            var motivo = "#motivoIndagine_new5";
                                            var nameRadio = "radioTipo5";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo6]').change(function () {
                                            var motivo = "#motivoIndagine_new6";
                                            var nameRadio = "radioTipo6";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo7]').change(function () {
                                            var motivo = "#motivoIndagine_new7";
                                            var nameRadio = "radioTipo7";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo8]').change(function () {
                                            var motivo = "#motivoIndagine_new8";
                                            var nameRadio = "radioTipo8";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo9]').change(function () {
                                            var motivo = "#motivoIndagine_new9";
                                            var nameRadio = "radioTipo9";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                        $('input[type=radio][name=radioTipo10]').change(function () {
                                            var motivo = "#motivoIndagine_new10";
                                            var nameRadio = "radioTipo10";
                                            var radio = $('input[name=' + nameRadio +']:checked').val();
                                            $(motivo).empty();
                                            $(motivo).append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                            $(motivo).append($group);
                                            if (radio == "Sospetta") {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 1)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            } else {
                                                @foreach($current_user->diagnosi() as $d)
                                                @if($d->diagnosi_stato == 0)
                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                @endif
                                                @endforeach
                                            }
                                            $(motivo).append("</optgroup>");
                                            $(motivo).append("<option value='0'>Nuova diagnosi</option>");
                                        });
                                    });

                                </script>
                                <form style="display:none;" id="formIndagini" action="/uploadFile" method="POST" class="form-horizontal">
                                    <div class="tab-content">
                                        <div class="row">
                                            <div>
                                                <div class="col-lg-12" style="display:none;">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-4">ID Paziente:</label>
                                                        <div class="col-lg-5">
                                                            <input id="idPaziente" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" style="display:none;">
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-4">ID CP:</label>
                                                        <div class="col-lg-5">
                                                            @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                <input id="cpId" readonly value="$current_user->id_utente" class="form-control"/>
                                                            @else
                                                                <input id="cpId" readonly value="-1" class="form-control"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- End hidden row -->
                                            <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new" role="alert"  style="float: none; margin: 0 auto;">
                                                <div style="text-align: center;">
                                                    <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                                    <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                                </div>
                                            </div>
                                            </br>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Tipo Indagine *</label>
                                                    <div class="col-lg-5">
                                                        <select id="tipoIndagine" class="form-control" required>
                                                            <option selected hidden style='display: none' value="">Selezionare un tipo</option>
                                                            <?php use App\Models\InvestigationCenter\CentriTipologie ?>
                                                            @foreach(CentriTipologie::all() as $tipo)
                                                                <option id="{{($tipo->id_centro_tipologia)}}" value="{{($tipo->tipologia_nome)}}">{{$tipo->tipologia_nome}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Motivo *</label>
                                                    <div class="col-lg-5">
                                                        <button type="button" id="aggiungiMotivo" class="btn btn-primary" onclick="nuovaMotivazione();">Aggiungi motivo</button>
                                                        <button type="button" id="eliminaMotivo" class="btn btn-danger" disabled onclick="eliminaMotivazione();">Rimuovi motivo</button>
                                                        <div id="divMotivazione1">
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta1" name="radioTipo1" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta1">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata1" name="radioTipo1"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata1">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new1" class="form-control" onchange="altraMotivazione(1);" required>
                                                                <option selected hidden style='display: none' value="">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>

                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new1" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione2" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta2" name="radioTipo2" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta2">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata2" name="radioTipo2"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata2">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new2" class="form-control" onchange="altraMotivazione(2);cambioStato(2);">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new2" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione3" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta3" name="radioTipo3" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta3">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata3" name="radioTipo3"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata3">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new3" class="form-control" onchange="altraMotivazione(3)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new3" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione4" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta4" name="radioTipo4" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta4">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata4" name="radioTipo4"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata4">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new4" class="form-control" onchange="altraMotivazione(4)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new4" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione5" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta5" name="radioTipo5" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta5">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata5" name="radioTipo5"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata5">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new5" class="form-control" onchange="altraMotivazione(5)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new5" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione6" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta6" name="radioTipo6" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta6">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata6" name="radioTipo6"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata6">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new6" class="form-control" onchange="altraMotivazione(6)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new6" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione7" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta7" name="radioTipo7" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta7">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata7" name="radioTipo7"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata7">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new7" class="form-control" onchange="altraMotivazione(7)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new1" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione8" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta8" name="radioTipo8" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta8">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata8" name="radioTipo8"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata8">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new8" class="form-control" onchange="altraMotivazione(8)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new8" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione9" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta9" name="radioTipo9" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta9">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata9" name="radioTipo9"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata9">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new9" class="form-control" onchange="altraMotivazione(9)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new9" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                        <div id="divMotivazione10" hidden>
                                                            <div class="row">
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" value="Sospetta" id="radioSospetta10" name="radioTipo10" checked style="margin-left: 15px;">
                                                                    <label for="radioSospetta10">Sospetta</label>
                                                                    <input type="radio" value="Confermata" id="radioConfermata10" name="radioTipo10"  style="margin-left: 10px;">
                                                                    <label for="radioConfermata10">Confermata</label>
                                                                </div>
                                                            </div>
                                                            <select id="motivoIndagine_new10" class="form-control" onchange="altraMotivazione(10)">
                                                                <option selected hidden style='display: none' value="placeholder">Selezionare una motivazione..</option>
                                                                <optgroup label="Diagnosi del paziente">
                                                                    @foreach($current_user->diagnosi() as $d)
                                                                        @if($d->diagnosi_stato == 1)
                                                                            <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}" >{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                                <option value="0">Nuova diagnosi</option>
                                                            </select>
                                                            <input id="motivoAltro_new10" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Care provider *</label>
                                                    <div class="col-lg-5">
                                                        <select id="cppIndagine_new" class="form-control" onchange="altroCpp()">
                                                            <option selected hidden style='display: none' value="">Selezionare un Care Providers..</option>
                                                            <optgroup label="Care Providers">
                                                                @foreach($current_user->cppAssociati() as $cp)
                                                                    <?php $value = $cp->cpp_nome." ".$cp->cpp_cognome; $id = $cp->id_cpp; ?>
                                                                    @if($id == Session::get('beforeImpersonate'))
                                                                        <option selected id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                                                    @else
                                                                        <option id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </optgroup>
                                                            <option value="-1">Nuovo Care Providers..</option>
                                                        </select>
                                                        <input id="cppAltro_new" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Stato *</label>
                                                    <div class="col-lg-5">
                                                        <select id="statoIndagine_new" class="form-control" onchange="stato()">
                                                            <option selected value="0">Richiesta</option>
                                                            <option value="1">Programmata</option>
                                                            <option value="2">Completata</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="divCentro_new" style="display:none;">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Centro *</label>
                                                    <div class="col-lg-5">
                                                        <select id="centroIndagine_new" class="form-control">
                                                            <option selected hidden style='display: none' value="placeholder">Selezionare un centro..</option>
                                                            <optgroup label="Centri Diagnostici">
                                                                @foreach($current_user->centriIndagini() as $centri)
                                                                    <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="divData_new" style="display:none;">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Data *</label>
                                                    <div class="col-lg-5">
                                                        {{Form::date('date','', ['id'=>"addIndagineData", 'name'=>"addIndagineData", 'class' => 'form-control col-lg-6'])}}
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="divReferto_new" style="display:none;">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Referto</label>
                                                    <div class="col-lg-5" >
                                                        <div id="divReferto" name="divReferto" style="display: none;">
                                                            <input id="referto1" name="referto1" type="text" readonly class="form-control" style="width:75%; float:left; " />
                                                            <input id="referto1Id" name="referto1Id" hidden type="text" />
                                                            <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('referto','1','divReferto','modalRefertoButton')">-</div>
                                                            <br /><br />
                                                        </div>
                                                        <button id="modalRefertoButton" name="modalRefertoButton" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('referto','divReferto','modalRefertoButton', 'referto1', 'referto1Id')">
                                                            Carica referto
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="divAllegato_new" style="display:none;">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Allegato</label>
                                                    <div class="col-lg-5">
                                                        @for($i=1;$i<=10;$i++)
                                                            <div id="divAllegato{{$i}}" name="divAllegato{{$i}}" style="display: none;">
                                                                <input id="allegato{{$i}}" name="allegato{{$i}}" type="text" readonly class="form-control" style="width:75%; float:left; " />
                                                                <input id="allegato{{$i}}Id" name="allegato{{$i}}Id" hidden type="text" />
                                                                <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('allegato','{{$i}}','divAllegato{{$i}}','modalAllegatoButton')">-</div>
                                                                <br /><br />
                                                            </div>
                                                        @endfor
                                                        <button id="modalAllegatoButton" name="modalAllegatoButton" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('allegato','divAllegato','modalAllegatoButton', 'allegato', 'allegato')">
                                                            Carica allegato
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- FINE FORM NUOVA INDAGINE -->
                                <br>

                                <!-- STRINGA DIAGNOSI SE ACCESSO DA POST -->
                                <div id="info_diagnosi" align="center"><h4> </h4></div>

                                <!-- TABELLA INDAGINI RICHIESTE -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">Indagini Richieste</div>
                                            <div class=" panel-body">
                                                <div class="table-responsive" >
                                                    <table class="table" id="tableRichieste">
                                                        <thead>
                                                        <tr>
                                                            <th>Indagine</th>
                                                            <th>Motivo</th>
                                                            <th>Care provider</th>
                                                            <th style="text-align:center; min-width: 80px;">Opzioni</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($current_user->indagini() as $ind)
                                                            <?php
                                                            $diagnosis = $ind->tbl_diagnosi;
                                                            $numMaxDiagnosi = sizeof($diagnosis);
                                                            ?>
                                                            @if($ind->indagine_stato === '0')
                                                                <tr>
                                                                    <td>{{$ind->indagine_tipologia}} </td>
                                                                    <td>
                                                                        @foreach($diagnosis as $diagnosi)
                                                                            @if($numMaxDiagnosi > 1)
                                                                                {{$diagnosi->diagnosi_patologia}},
                                                                            @else
                                                                                {{$diagnosi->diagnosi_patologia}}
                                                                            @endif
                                                                            <?php $numMaxDiagnosi--?>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{$ind->careprovider}} </td>
                                                                    <td style="text-align:center">
                                                                        <button id="{{($ind->id_indagine)}}" class="modifica btn btn-success" ><i class="icon-pencil icon-white"></i></button>
                                                                        <button id="{{($ind->id_indagine)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
                                                                    </td>
                                                                </tr>

                                                                <tr id="rigaModR" >
                                                                    <td colspan="7">
                                                                        <form style="display:none;" id="form{{($ind->id_indagine)}}" class="form-horizontal" >
                                                                            <div class="tab-content">
                                                                                <div class="row">
                                                                                    <div >
                                                                                        <div class="col-lg-12" style="display:none;">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label col-lg-4">ID Paziente:</label>
                                                                                                <div class="col-lg-5">
                                                                                                    <input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-12" style="display:none;">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label col-lg-4">ID CP:</label>
                                                                                                <div class="col-lg-5">
                                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                                        <input id="cpIdR" readonly value="$current_user->id_utente" class="form-control"/>
                                                                                                    @else
                                                                                                        <input id="cpIdR" readonly value="-1" class="form-control"/>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> <!-- End hidden row -->
                                                                                    <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new{{($ind->id_indagine)}}" role="alert"  style="float: none; margin: 0 auto;">
                                                                                        <div style="text-align: center;">
                                                                                            <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                                                                            <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                                                                        </div>
                                                                                    </div></br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Tipo indagine *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="tipoIndagine{{($ind->id_indagine)}}" class="form-control">
                                                                                                    <option selected hidden style='display: none' value="placeholder">Selezionare un tipo</option>
                                                                                                    @foreach(CentriTipologie::all() as $tipo)
                                                                                                        <option id="{{($tipo->id_centro_tipologia)}}" value="{{($tipo->tipologia_nome)}}"
                                                                                                        <?php if($tipo->tipologia_nome == $ind->indagine_tipologia) echo "selected"; ?>
                                                                                                        >{{$tipo->tipologia_nome}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <?php
                                                                                                $diagnosis = $ind->tbl_diagnosi;
                                                                                                $numDiagnosi = 0;
                                                                                            ?>
                                                                                            @foreach($diagnosis as $diagnosi)
                                                                                                <label class="control-label col-lg-4">Motivo {{$numDiagnosi+1}} *</label>
                                                                                                <div class="col-lg-5">
                                                                                                    <div class="row">
                                                                                                        <div class="form-check form-check-inline" >
                                                                                                            <input type="radio" value="Sospetta" id="radioSospetta_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" name="radioTipo_new{{$ind->id_indagine}}_{{$numDiagnosi+1}}" style="margin-left: 15px;"
                                                                                                                   @if($diagnosi->diagnosi_stato == 1)
                                                                                                                   checked
                                                                                                                    @endif
                                                                                                            >
                                                                                                            <label for="radioSospetta">Sospetta</label>
                                                                                                            <input type="radio" value="Confermata" id="radioConfermata_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" name="radioTipo_new{{$ind->id_indagine}}_{{$numDiagnosi+1}}"  style="margin-left: 10px;"
                                                                                                                   @if($diagnosi->diagnosi_stato == 0)
                                                                                                                   checked
                                                                                                                    @endif
                                                                                                            >
                                                                                                            <label for="radioConfermata">Confermata</label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <select id="motivoIndagine_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" class="form-control" >
                                                                                                        <optgroup label="Diagnosi del paziente">
                                                                                                            @foreach($current_user->diagnosi() as $d)
                                                                                                                @if($d->diagnosi_stato == $diagnosi->diagnosi_stato)
                                                                                                                    <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}"
                                                                                                                            @if($diagnosi->id_diagnosi == $d->id_diagnosi)
                                                                                                                            selected
                                                                                                                            @endif
                                                                                                                    >{{($d->diagnosi_patologia)}} del {{Carbon\Carbon::parse($d->diagnosi_inserimento_data)->format('d-m-Y') }}</option>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                        </optgroup>
                                                                                                        <option value="0">Nuova diagnosi</option>
                                                                                                    </select>
                                                                                                    <input id="motivoAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                                                                </div>
                                                                                                <?php $numDiagnosi++; ?>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Care provider *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="cppIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                                                                                    <?php $i = explode("-", $current_user->cppInd($ind->id_diagnosi))?>
                                                                                                    <option hidden style='display: none' id="{{($i[1])}}" selected  value="{{($i[0])}}">{{$i[0]}}</option>
                                                                                                    <optgroup label="Care Providers">
                                                                                                        @foreach($current_user->cppAssociati() as $cp)
                                                                                                            <?php $value = $cp->cpp_nome." ".$cp->cpp_cognome; $id = $cp->id_cpp; ?>
                                                                                                            <option id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                                                                                        @endforeach
                                                                                                    </optgroup>
                                                                                                    <option value="-1">Nuovo Care Providers..</option>
                                                                                                </select>
                                                                                                <input id="cppAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Stato *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="statoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                                                                                    <option selected value="0">Richiesta</option>
                                                                                                    <option value="1">Programmata</option>
                                                                                                    <option value="2">Completata</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divCentro_new{{($ind->id_indagine)}}" style="display:none;">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Centro *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="centroIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                                                                                    <option selected hidden style='display: none' value="" id="">Selezionare un centro..</option>
                                                                                                    <optgroup label="Centri Diagnostici">
                                                                                                        @foreach($current_user->centriIndagini() as $centri)
                                                                                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divData_new{{($ind->id_indagine)}}" style="display:none;">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Data*</label>
                                                                                            <div class="col-lg-5">
                                                                                                <?php $d = explode(" ", $ind->indagine_data) ?>
                                                                                                <input id="date{{($ind->id_indagine)}}" value="{{($d[0])}}" type="date" class="form-control col-lg-6">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divRefertiR{{$ind->id_indagine}}" style="display:none;">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Referto</label>
                                                                                            <div class="col-lg-5">
                                                                                                <div id="divReferto_new{{$ind->id_indagine}}" name="divReferto_new{{$ind->id_indagine}}" style='display: none;';>
                                                                                                    <input id="referto_new{{$ind->id_indagine}}" name="referto_new{{$ind->id_indagine}}" type="text" readonly class="form-control" style="width:75%; float:left; " value=""/>
                                                                                                    <input id="referto_new{{$ind->id_indagine}}Id" name="referto_new{{$ind->id_indagine}}Id" hidden type="text" value=""/>
                                                                                                    <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('referto','_new{{$ind->id_indagine}}','divReferto_new{{$ind->id_indagine}}', 'modalRefertoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                    <br /><br />
                                                                                                </div>
                                                                                                <button id="modalRefertoButton_new{{$ind->id_indagine}}" name="modalRefertoButton_newC{{$ind->id_indagine}}" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('referto','divReferto_new{{$ind->id_indagine}}','modalRefertoButton_new{{$ind->id_indagine}}', 'referto_new{{$ind->id_indagine}}', 'referto_new{{$ind->id_indagine}}Id')">
                                                                                                    Carica referto
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divAllegatiR{{$ind->id_indagine}}" style="display:none;">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Allegato</label>
                                                                                            <div class="col-lg-5">
                                                                                                @for($i=1;$i<=10;$i++)
                                                                                                    <div id="divAllegato_newR{{$ind->id_indagine}}_{{$i}}" name="divAllegato_newR{{$ind->id_indagine}}_{{$i}}" style="display: none;">
                                                                                                        <input id="allegato_newR{{$ind->id_indagine}}_{{$i}}" name="allegato_newR{{$ind->id_indagine}}_{{$i}}" type="text" readonly class="form-control" style="width:75%; float:left; " />
                                                                                                        <input id="allegato_newR{{$ind->id_indagine}}_{{$i}}Id" name="allegato_newR{{$ind->id_indagine}}_{{$i}}Id" hidden type="text" />
                                                                                                        <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('allegato_newR{{$ind->id_indagine}}_','{{$i}}','divAllegato_newR{{$ind->id_indagine}}_{{$i}}','modalAllegatoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                        <br /><br />
                                                                                                    </div>
                                                                                                @endfor
                                                                                                <button id="modalAllegatoButton_new{{$ind->id_indagine}}" name="modalAllegatoButton_new{{$ind->id_indagine}}" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('allegato','divAllegato_newR{{$ind->id_indagine}}_','modalAllegatoButton_new{{$ind->id_indagine}}', 'allegato_newR{{$ind->id_indagine}}_', 'allegato_newR{{$ind->id_indagine}}_')">
                                                                                                    Carica allegato
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="text-align:center;">
                                                                                    <a href="" onclick="annullaR()" class=annulla id="annullaR"><button class="btn btn-danger"><i class="icon icon-undo"></i> Annulla modifiche</button></a>
                                                                                    <a onclick="return false;" class=conferma data-id="{{($ind->id_indagine)}}" data-mod="R{{$ind->id_indagine}}_"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                    </td>
                                                                </tr>

                                                                <script>

                                                                    //imposta lo stato del form per la modifica di una indagine richiesta
                                                                    $('#form{{($ind->id_indagine)}}').change('statoIndagine_new{{($ind->id_indagine)}}', function(){

                                                                        var stato = $('#statoIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(stato == 0){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").hide();
                                                                            $("#divData_new{{($ind->id_indagine)}}").hide();
                                                                            $("#divRefertiR{{($ind->id_indagine)}}").hide();
                                                                            $("#divAllegatiR{{($ind->id_indagine)}}").hide();

                                                                        }

                                                                        if(stato == 1){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").show();
                                                                            $("#divData_new{{($ind->id_indagine)}}").show();
                                                                            $("#divRefertiR{{($ind->id_indagine)}}").hide();
                                                                            $("#divAllegatiR{{($ind->id_indagine)}}").hide();
                                                                        }

                                                                        if(stato == 2){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").show();
                                                                            $("#divData_new{{($ind->id_indagine)}}").show();
                                                                            $("#divRefertiR{{($ind->id_indagine)}}").show();
                                                                            $("#divAllegatiR{{($ind->id_indagine)}}").show();
                                                                        }

                                                                    });
                                                                    //permette di visualizzare l'input text 'altra motivazione' nel form della modifica delle indagini richieste
                                                                    $('#form{{($ind->id_indagine)}}').change('motivoIndagine_new{{($ind->id_indagine)}}', function(){
                                                                        var motivo = $('#motivoIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(motivo == 0){

                                                                            document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "text";
                                                                        }else{
                                                                            document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "hidden";

                                                                        }

                                                                    });
                                                                    //permette di visualizzare l'input text 'nuovo careprovider' nel form della modifica delle indagini richieste
                                                                    $('#form{{($ind->id_indagine)}}').change('cppIndagine_new{{($ind->id_indagine)}}', function(){
                                                                        var cpp = $('#cppIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(cpp == -1){

                                                                            document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "text";
                                                                        }else{
                                                                            document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "hidden";

                                                                        }

                                                                    });

                                                                    $(function(){

                                                                        $('input[type=radio][name=radioTipo_new{{$ind->id_indagine}}]').change(function(){
                                                                            var radio = $('input[type=radio][name=radioTipo_new{{$ind->id_indagine}}]:checked').val();
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").empty();
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append($group);
                                                                            if(radio=="Sospetta")
                                                                            {
                                                                                @foreach($current_user->diagnosi() as $d)
                                                                                @if($d->diagnosi_stato == 1)
                                                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                                                @endif
                                                                                @endforeach
                                                                            }
                                                                            else
                                                                            {
                                                                                @foreach($current_user->diagnosi() as $d)
                                                                                @if($d->diagnosi_stato == 0)
                                                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                                                @endif
                                                                                @endforeach
                                                                            }
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("</optgroup>");
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("<option value='0'>Nuova diagnosi</option>");
                                                                        });
                                                                    });
                                                                </script>
                                                            @endif
                                                        @endforeach


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>    <!--paneldanger-->
                                        </div>    <!--col lg12-->
                                    </div>
                                </div><br>
                                <!-- TABELLA INDAGINI PROGRAMMATE -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">Indagini Programmate</div>
                                            <div class=" panel-body">
                                                <div class="table-responsive" >
                                                    <table class="table" id="tableProgrammate">
                                                        <thead>
                                                        <tr>
                                                            <th>Indagine</th>
                                                            <th>Motivo</th>
                                                            <th>Care provider</th>
                                                            <th>Data</th>
                                                            <th>Centro</th>
                                                            <th style="text-align:center; min-width: 80px;">Opzioni</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($current_user->indagini() as $ind)
                                                            <?php
                                                            $diagnosis = $ind->tbl_diagnosi;
                                                            $numMaxDiagnosi = sizeof($diagnosis);
                                                            ?>
                                                            @if($ind->indagine_stato === '1')
                                                                <tr>
                                                                    <td>{{$ind->indagine_tipologia}}</td>
                                                                    <td>
                                                                        @foreach($diagnosis as $diagnosi)
                                                                            @if($numMaxDiagnosi > 1)
                                                                                {{$diagnosi->diagnosi_patologia}},
                                                                                @else
                                                                                {{$diagnosi->diagnosi_patologia}}
                                                                            @endif
                                                                            <?php $numMaxDiagnosi--?>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{$ind->careprovider}} </td>
                                                                    <td><?php echo date('d/m/y', strtotime($ind->indagine_data)); ?> </td>
                                                                    <td>{{$current_user->nomeCentroInd($ind->id_centro_indagine)}} </td>
                                                                    <td style="text-align:center">
                                                                        <button id="{{($ind->id_indagine)}}" class="modifica btn btn-success" ><i class="icon-pencil icon-white"></i></button>
                                                                        <button id="{{($ind->id_indagine)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
                                                                    </td>
                                                                </tr>
                                                                <tr id="rigaModP">
                                                                    <td colspan="7">
                                                                        <form style="display:none;" id="form{{($ind->id_indagine)}}" class="form-horizontal" >
                                                                            <div class="tab-content">
                                                                                <div class="row">
                                                                                    <div >
                                                                                        <div class="col-lg-12" style="display:none;">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label col-lg-4">ID Paziente:</label>
                                                                                                <div class="col-lg-5">
                                                                                                    <input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-12" style="display:none;">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label col-lg-4">ID CP:</label>
                                                                                                <div class="col-lg-5">
                                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                                        <input id="cpIdP" readonly value="$current_user->id_utente" class="form-control"/>
                                                                                                    @else
                                                                                                        <input id="cpIdP" readonly value="-1" class="form-control"/>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> <!-- End hidden row -->
                                                                                    <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new{{($ind->id_indagine)}}" role="alert"  style="float: none; margin: 0 auto;">
                                                                                        <div style="text-align: center;">
                                                                                            <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                                                                            <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                                                                        </div>
                                                                                    </div></br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Tipo indagine *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="tipoIndagine{{($ind->id_indagine)}}" class="form-control">
                                                                                                    <option selected hidden style='display: none' value="placeholder">Selezionare un tipo</option>
                                                                                                    @foreach(CentriTipologie::all() as $tipo)
                                                                                                        <option id="{{($tipo->id_centro_tipologia)}}" value="{{($tipo->tipologia_nome)}}"
                                                                                                        <?php if($tipo->tipologia_nome == $ind->indagine_tipologia) echo "selected"; ?>
                                                                                                        >{{$tipo->tipologia_nome}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <?php
                                                                                            $diagnosis = $ind->tbl_diagnosi;
                                                                                            $numDiagnosi = 0;
                                                                                            ?>
                                                                                            @foreach($diagnosis as $diagnosi)
                                                                                                <label class="control-label col-lg-4">Motivo {{$numDiagnosi+1}} *</label>
                                                                                                <div class="col-lg-5">
                                                                                                    <div class="row">
                                                                                                        <div class="form-check form-check-inline" >
                                                                                                            <input type="radio" value="Sospetta" id="radioSospetta_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" name="radioTipo_new{{$ind->id_indagine}}_{{$numDiagnosi+1}}" style="margin-left: 15px;"
                                                                                                                   @if($diagnosi->diagnosi_stato == 1)
                                                                                                                   checked
                                                                                                                    @endif
                                                                                                            >
                                                                                                            <label for="radioSospetta">Sospetta</label>
                                                                                                            <input type="radio" value="Confermata" id="radioConfermata_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" name="radioTipo_new{{$ind->id_indagine}}_{{$numDiagnosi+1}}"  style="margin-left: 10px;"
                                                                                                                   @if($diagnosi->diagnosi_stato == 0)
                                                                                                                   checked
                                                                                                                    @endif
                                                                                                            >
                                                                                                            <label for="radioConfermata">Confermata</label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <select id="motivoIndagine_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" class="form-control" >
                                                                                                        <optgroup label="Diagnosi del paziente">
                                                                                                            @foreach($current_user->diagnosi() as $d)
                                                                                                                @if($d->diagnosi_stato == $diagnosi->diagnosi_stato)
                                                                                                                    <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}"
                                                                                                                            @if($diagnosi->id_diagnosi == $d->id_diagnosi)
                                                                                                                            selected
                                                                                                                            @endif
                                                                                                                    >{{($d->diagnosi_patologia)}} del {{Carbon\Carbon::parse($d->diagnosi_inserimento_data)->format('d-m-Y') }}</option>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                        </optgroup>
                                                                                                        <option value="0">Nuova diagnosi</option>
                                                                                                    </select>
                                                                                                    <input id="motivoAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                                                                </div>
                                                                                                <?php $numDiagnosi++; ?>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Care provider *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="cppIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                                                                                    <?php $i = explode("-", $current_user->cppInd($ind->id_diagnosi))?>
                                                                                                    <option hidden style='display: none' id="{{($i[1])}}" selected value="{{($i[0])}}">{{$i[0]}}</option>
                                                                                                    <optgroup label="Care Providers">
                                                                                                        @foreach($current_user->cppAssociati() as $cp)
                                                                                                            <?php $value = $cp->cpp_nome." ".$cp->cpp_cognome; $id = $cp->id_cpp; ?>
                                                                                                            @if($id == Session::get('beforeImpersonate'))
                                                                                                                <option selected id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                                                                                            @else
                                                                                                                <option id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    </optgroup>
                                                                                                    <option value="-1">Nuovo Care Providers..</option>
                                                                                                </select>
                                                                                                <input id="cppAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Stato *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="statoIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                                                                                    <option value="0">Richiesta</option>
                                                                                                    <option selected value="1">Programmata</option>
                                                                                                    <option value="2">Completata</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divCentro_new{{($ind->id_indagine)}}" >
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Centro *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="centroIndagine_new{{($ind->id_indagine)}}"  class="form-control">
                                                                                                    <option hidden style='display: none' id="{{($ind->id_centro_indagine)}}" selected value="{{($current_user->nomeCentroInd($ind->id_centro_indagine))}}">{{$current_user->nomeCentroInd($ind->id_centro_indagine)}}</option>
                                                                                                    <optgroup label="Centri Diagnostici">
                                                                                                        @foreach($current_user->centriIndagini() as $centri)
                                                                                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divData_new{{($ind->id_indagine)}}" >
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Data*</label>
                                                                                            <div class="col-lg-5">
                                                                                                <?php $d = explode(" ", $ind->indagine_data) ?>
                                                                                                <input id="date{{($ind->id_indagine)}}" value="{{($d[0])}}" type="date" class="form-control col-lg-6">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divRefertiP{{$ind->id_indagine}}" style="display:none;">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Referto</label>
                                                                                            <div class="col-lg-5">
                                                                                                <div id="divReferto_new{{$ind->id_indagine}}" name="divReferto_new{{$ind->id_indagine}}"
                                                                                                <?php if($ind->indagine_referto == "")
                                                                                                    echo "style='display: none;'";
                                                                                                    ?>
                                                                                                >
                                                                                                    @if($ind->indagine_referto != null)
                                                                                                        <input id="referto_new{{$ind->id_indagine}}" name="referto_new{{$ind->id_indagine}}" type="text" readonly class="form-control" style="width:75%; float:left; " value="{{$ind->getFile($ind->indagine_referto)->file_nome}}"/>
                                                                                                        <input id="referto_new{{$ind->id_indagine}}Id" name="referto_new{{$ind->id_indagine}}Id" hidden type="text" value="{{$ind->indagine_referto}}"/>
                                                                                                    @else
                                                                                                        <input id="referto_new{{$ind->id_indagine}}" name="referto_new{{$ind->id_indagine}}" type="text" readonly class="form-control" style="width:75%; float:left; " value=""/>
                                                                                                        <input id="referto_new{{$ind->id_indagine}}Id" name="referto_new{{$ind->id_indagine}}Id" hidden type="text" value=""/>
                                                                                                    @endif
                                                                                                    <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('referto','_new{{$ind->id_indagine}}','divReferto_new{{$ind->id_indagine}}', 'modalRefertoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                    <br /><br />
                                                                                                </div>
                                                                                                <button id="modalRefertoButton_new{{$ind->id_indagine}}" name="modalRefertoButton_newC{{$ind->id_indagine}}" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('referto','divReferto_new{{$ind->id_indagine}}','modalRefertoButton_new{{$ind->id_indagine}}', 'referto_new{{$ind->id_indagine}}', 'referto_new{{$ind->id_indagine}}Id')">
                                                                                                    Carica referto
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divAllegatiP{{$ind->id_indagine}}" style="display:none;">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Allegato</label>
                                                                                            <div class="col-lg-5">
                                                                                                @for($i=1;$i<=10;$i++)
                                                                                                    <div id="divAllegato_newP{{$ind->id_indagine}}_{{$i}}" name="divAllegato_newP{{$ind->id_indagine}}_{{$i}}" style="display: none;">
                                                                                                        <input id="allegato_newP{{$ind->id_indagine}}_{{$i}}" name="allegato_newP{{$ind->id_indagine}}_{{$i}}" type="text" readonly class="form-control" style="width:75%; float:left; " />
                                                                                                        <input id="allegato_newP{{$ind->id_indagine}}_{{$i}}Id" name="allegato_newP{{$ind->id_indagine}}_{{$i}}Id" hidden type="text" />
                                                                                                        <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('allegato_newP{{$ind->id_indagine}}_{{$i}}','{{$i}}','divAllegato_newP{{$ind->id_indagine}}_{{$i}}','modalAllegatoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                        <br /><br />
                                                                                                    </div>
                                                                                                @endfor
                                                                                                <button id="modalAllegatoButton_new{{$ind->id_indagine}}" name="modalAllegatoButton_new{{$ind->id_indagine}}" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('allegato','divAllegato_newP{{$ind->id_indagine}}_','modalAllegatoButton_new{{$ind->id_indagine}}', 'allegato_newP{{$ind->id_indagine}}_', 'allegato_newP{{$ind->id_indagine}}_')">
                                                                                                    Carica allegato
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="text-align:center;">
                                                                                    <a href="" onclick="annullaP()" class=annulla id="annullaP"><button class="btn btn-danger"><i class="icon icon-undo"></i> Annulla modifiche</button></a>
                                                                                    <a href="" onclick="return false;" class=conferma data-id="{{($ind->id_indagine)}}" data-mod="P{{$ind->id_indagine}}_"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                <script>

                                                                    //imposta lo stato del form per la modifica di una indagine programmata
                                                                    $('#form{{($ind->id_indagine)}}').change('statoIndagine_new{{($ind->id_indagine)}}', function(){

                                                                        var stato = $('#statoIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(stato == 0){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").hide();
                                                                            $("#divData_new{{($ind->id_indagine)}}").hide();
                                                                            $("#divRefertiP{{($ind->id_indagine)}}").hide();
                                                                            $("#divAllegatiP{{($ind->id_indagine)}}").hide();

                                                                        }

                                                                        if(stato == 1){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").show();
                                                                            $("#divData_new{{($ind->id_indagine)}}").show();
                                                                            $("#divRefertiP{{($ind->id_indagine)}}").hide();
                                                                            $("#divAllegatiP{{($ind->id_indagine)}}").hide();
                                                                        }

                                                                        if(stato == 2){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").show();
                                                                            $("#divData_new{{($ind->id_indagine)}}").show();
                                                                            $("#divRefertiP{{($ind->id_indagine)}}").show();
                                                                            $("#divAllegatiP{{($ind->id_indagine)}}").show();
                                                                        }

                                                                    });

                                                                    //permette di visualizzare l'input text 'altra motivazione' nel form della modifica delle indagini programmate
                                                                    $('#form{{($ind->id_indagine)}}').change('motivoIndagine_new{{($ind->id_indagine)}}', function(){
                                                                        var motivo = $('#motivoIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(motivo == 0){

                                                                            document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "text";
                                                                        }else{
                                                                            document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "hidden";

                                                                        }

                                                                    });

                                                                    //permette di visualizzare l'input text 'nuovo careprovider' nel form della modifica delle indagini programmate
                                                                    $('#form{{($ind->id_indagine)}}').change('cppIndagine_new{{($ind->id_indagine)}}', function(){
                                                                        var cpp = $('#cppIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(cpp == -1){

                                                                            document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "text";
                                                                        }else{
                                                                            document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "hidden";

                                                                        }

                                                                    });

                                                                    $(function(){

                                                                        $('input[type=radio][name=radioTipo_new{{$ind->id_indagine}}]').change(function(){
                                                                            var radio = $('input[type=radio][name=radioTipo_new{{$ind->id_indagine}}]:checked').val();
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").empty();
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append($group);
                                                                            if(radio=="Sospetta")
                                                                            {
                                                                                @foreach($current_user->diagnosi() as $d)
                                                                                @if($d->diagnosi_stato == 1)
                                                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                                                @endif
                                                                                @endforeach
                                                                            }
                                                                            else
                                                                            {
                                                                                @foreach($current_user->diagnosi() as $d)
                                                                                @if($d->diagnosi_stato == 0)
                                                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                                                @endif
                                                                                @endforeach
                                                                            }
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("</optgroup>");
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("<option value='0'>Nuova diagnosi</option>");
                                                                        });
                                                                    });

                                                                </script>

                                                            @endif
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>    <!--paneldanger-->
                                        </div>    <!--col lg12-->
                                    </div>
                                </div><br>
                                <!-- TABELLA INDAGINI COMPLETATE -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">Indagini Completate</div>
                                            <div class=" panel-body">
                                                <div class="table-responsive" >
                                                    <table class="table" id="tableCompletate">
                                                        <thead>
                                                        <tr>
                                                            <th>Indagine</th>
                                                            <th>Motivo</th>
                                                            <th>Care provider</th>
                                                            <th>Data</th>
                                                            <th style="text-align:center">Referto</th>
                                                            <th style="text-align:center">Allegati</th>
                                                            <th style="text-align:center; min-width: 80px;">Opzioni</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($current_user->indagini() as $ind)
                                                            <?php
                                                            $diagnosis = $ind->tbl_diagnosi;
                                                            $numMaxDiagnosi = sizeof($diagnosis);
                                                            ?>
                                                            @if($ind->indagine_stato === '2')
                                                                <tr>
                                                                    <td>{{$ind->indagine_tipologia}} </td>
                                                                    <td>
                                                                        @foreach($diagnosis as $diagnosi)
                                                                            @if($numMaxDiagnosi > 1)
                                                                                {{$diagnosi->diagnosi_patologia}},
                                                                            @else
                                                                                {{$diagnosi->diagnosi_patologia}}
                                                                            @endif
                                                                            <?php $numMaxDiagnosi--?>
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{$ind->careprovider}} </td>
                                                                    <td><?php echo date('d/m/y', strtotime($ind->indagine_data)); ?> </td>
                                                                    <td style="text-align:center;">
                                                                        @if($ind->indagine_referto != NULL)
                                                                            <a href = "downloadImage/{{$ind->indagine_referto}}">
                                                                                <button class="btn btn-info"  type="button" id="">
                                                                                    <i class="glyphicon glyphicon-download-alt"></i>
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                            <button class="btn btn-danger"  type="button" id="">
                                                                                <i class="icon-ban-circle"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <?php $allegati = App\Models\InvestigationCenter\AllegatiIndagini::where('id_indagine',$ind->id_indagine)->get(); ?>
                                                                        @if(sizeof($allegati)==0)
                                                                            <button class="btn btn-danger"  type="button" id="">
                                                                                <i class="icon-ban-circle"></i>
                                                                            </button>
                                                                        @else
                                                                            <button class="btn btn-info" type="button"  data-toggle="modal"  data-target="#allegatiModal" id="allegatiModalButton{{$ind->id_indagine}}" >
                                                                                <i class="icon-list-alt"></i>
                                                                            </button>
                                                                            <script>
                                                                                $( "#allegatiModalButton{{$ind->id_indagine}}" ).click(function() {
                                                                                    <?php $i=1; ?>
                                                                                    @foreach($allegati as $allegato)
                                                                                    $("#divAllegatoInModal{{$i}}").show();
                                                                                    $("#linkDownloadAllegato{{$i}}").attr("href", "downloadImage/{{$allegato->id_file}}");
                                                                                    $("#spanAllegatoInModal{{$i}}").text("{{($ind->getFile($allegato->id_file))->file_nome}}");
                                                                                    <?php $i++; ?>
                                                                                    @endforeach
                                                                                });
                                                                            </script>
                                                                        @endif
                                                                    </td>
                                                                <!--<td><a href = "downloadImage/{{$ind->indagine_allegato}}"><button class="btn btn-info"  type="button" id="">
                                                                    <i class="icon-file-text"></i></button></a> </td> ciao -->
                                                                    <td style="text-align:center">
                                                                        <button id="{{($ind->id_indagine)}}" class="modifica btn btn-success" ><i class="icon-pencil icon-white"></i></button>
                                                                        <button id="{{($ind->id_indagine)}}" class="elimina btn btn-danger"><i class="icon-remove icon-white"></i></button>
                                                                    </td>

                                                                </tr>
                                                                <tr id="rigaModC" >
                                                                    <td colspan="7">
                                                                        <form style="display:none;" id="form{{($ind->id_indagine)}}" class="form-horizontal" >
                                                                            <div class="tab-content">
                                                                                <div class="row">
                                                                                    <div >
                                                                                        <div class="col-lg-12" style="display:none;">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label col-lg-4">ID Paziente:</label>
                                                                                                <div class="col-lg-5">
                                                                                                    <input id="idPaziente{{($ind->id_indagine)}}" readonly value="{{$current_user->idPazienteUser()}}" class="form-control"/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-12" style="display:none;">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label col-lg-4">ID CP:</label>
                                                                                                <div class="col-lg-5">
                                                                                                    @if(UtentiTipologie::where('id_tipologia', $current_user->id_tipologia)->first()->tipologia_nome == User::CAREPROVIDER_ID)
                                                                                                        <input id="cpIdC" readonly value="$current_user->id_utente" class="form-control"/>
                                                                                                    @else
                                                                                                        <input id="cpIdC" readonly value="-1" class="form-control"/>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> <!-- End hidden row -->
                                                                                    <div hidden class="col-lg-6 alert alert-danger" id="formAlert_new{{($ind->id_indagine)}}" role="alert"  style="float: none; margin: 0 auto;">
                                                                                        <div style="text-align: center;">
                                                                                            <i class="glyphicon glyphicon-exclamation-sign" ></i>
                                                                                            <strong>Attenzione:</strong> Compilare correttamente i campi bordati in rosso.
                                                                                        </div>
                                                                                    </div></br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Tipo indagine *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="tipoIndagine{{($ind->id_indagine)}}" class="form-control">
                                                                                                    <option selected hidden style='display: none' value="placeholder">Selezionare un tipo</option>
                                                                                                    @foreach(CentriTipologie::all() as $tipo)
                                                                                                        <option id="{{($tipo->id_centro_tipologia)}}" value="{{($tipo->tipologia_nome)}}"
                                                                                                        <?php if($tipo->tipologia_nome == $ind->indagine_tipologia) echo "selected"; ?>
                                                                                                        >{{$tipo->tipologia_nome}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <?php
                                                                                            $diagnosis = $ind->tbl_diagnosi;
                                                                                            $numDiagnosi = 0;
                                                                                            ?>
                                                                                            @foreach($diagnosis as $diagnosi)
                                                                                                <label class="control-label col-lg-4">Motivo {{$numDiagnosi+1}} *</label>
                                                                                                <div class="col-lg-5">
                                                                                                    <div class="row">
                                                                                                        <div class="form-check form-check-inline" >
                                                                                                            <input type="radio" value="Sospetta" id="radioSospetta_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" name="radioTipo_new{{$ind->id_indagine}}_{{$numDiagnosi+1}}" style="margin-left: 15px;"
                                                                                                                   @if($diagnosi->diagnosi_stato == 1)
                                                                                                                   checked
                                                                                                                    @endif
                                                                                                            >
                                                                                                            <label for="radioSospetta">Sospetta</label>
                                                                                                            <input type="radio" value="Confermata" id="radioConfermata_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" name="radioTipo_new{{$ind->id_indagine}}_{{$numDiagnosi+1}}"  style="margin-left: 10px;"
                                                                                                                   @if($diagnosi->diagnosi_stato == 0)
                                                                                                                   checked
                                                                                                                    @endif
                                                                                                            >
                                                                                                            <label for="radioConfermata">Confermata</label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <select id="motivoIndagine_new{{($ind->id_indagine)}}_{{$numDiagnosi+1}}" class="form-control" >
                                                                                                        <optgroup label="Diagnosi del paziente">
                                                                                                            @foreach($current_user->diagnosi() as $d)
                                                                                                                @if($d->diagnosi_stato == $diagnosi->diagnosi_stato)
                                                                                                                    <option value="{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}"
                                                                                                                            @if($diagnosi->id_diagnosi == $d->id_diagnosi)
                                                                                                                            selected
                                                                                                                            @endif
                                                                                                                    >{{($d->diagnosi_patologia)}} del {{Carbon\Carbon::parse($d->diagnosi_inserimento_data)->format('d-m-Y') }}</option>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                        </optgroup>
                                                                                                        <option value="0">Nuova diagnosi</option>
                                                                                                    </select>
                                                                                                    <input id="motivoAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire motivazione.."  class="form-control"/>
                                                                                                </div>
                                                                                                <?php $numDiagnosi++; ?>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Care provider *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="cppIndagine_new{{($ind->id_indagine)}}" class="form-control" >
                                                                                                    <?php $i = explode("-", $current_user->cppInd($ind->id_diagnosi))?>
                                                                                                    <option hidden style='display: none' id="{{($i[1])}}" selected value="{{($i[0])}}">{{$i[0]}}</option>
                                                                                                    <optgroup label="Care Providers">
                                                                                                        @foreach($current_user->cppAssociati() as $cp)
                                                                                                            <?php $value = $cp->cpp_nome." ".$cp->cpp_cognome; $id = $cp->id_cpp; ?>
                                                                                                            <option id="{{$id}}" value="{{$value}}">{{$value}}</option>
                                                                                                        @endforeach
                                                                                                    </optgroup>
                                                                                                    <option value="-1">Nuovo Care Providers..</option>
                                                                                                </select>
                                                                                                <input id="cppAltro_new{{($ind->id_indagine)}}" type="hidden" placeholder="Inserire CareProvider"  class="form-control"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Stato *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="statoIndagine_new{{($ind->id_indagine)}}" class="form-control">
                                                                                                    <option value="0">Richiesta</option>
                                                                                                    <option value="1">Programmata</option>
                                                                                                    <option selected value="2">Completata</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divCentro_new{{($ind->id_indagine)}}" >
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Centro *</label>
                                                                                            <div class="col-lg-5">
                                                                                                <select id="centroIndagine_new{{($ind->id_indagine)}}"  class="form-control">
                                                                                                    <option hidden style='display: none' id="{{($ind->id_centro_indagine)}}" selected value="{{($current_user->nomeCentroInd($ind->id_centro_indagine))}}">{{$current_user->nomeCentroInd($ind->id_centro_indagine)}}</option>
                                                                                                    <optgroup label="Centri Diagnostici">
                                                                                                        @foreach($current_user->centriIndagini() as $centri)
                                                                                                            <option id="{{($centri->id_centro)}}" value="{{($centri->centro_nome)}}">{{$centri->centro_nome}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divData_new{{($ind->id_indagine)}}" >
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Data*</label>
                                                                                            <div class="col-lg-5">
                                                                                                <?php $d = explode(" ", $ind->indagine_data) ?>
                                                                                                <input id="date{{($ind->id_indagine)}}" value="{{($d[0])}}" type="date" class="form-control col-lg-6">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group" id="divRefertiC{{$ind->id_indagine}}">
                                                                                            <label class="control-label col-lg-4">Referto</label>
                                                                                            <div class="col-lg-5">
                                                                                                <div id="divReferto_new{{$ind->id_indagine}}" name="divReferto_new{{$ind->id_indagine}}"
                                                                                                <?php if($ind->indagine_referto == "")
                                                                                                    echo "style='display: none;'";
                                                                                                    ?>
                                                                                                >
                                                                                                    @if($ind->indagine_referto != null)
                                                                                                        <input id="referto_new{{$ind->id_indagine}}" name="referto_new{{$ind->id_indagine}}" type="text" readonly class="form-control" style="width:75%; float:left; " value="{{$ind->getFile($ind->indagine_referto)->file_nome}}"/>
                                                                                                        <input id="referto_new{{$ind->id_indagine}}Id" name="referto_new{{$ind->id_indagine}}Id" hidden type="text" value="{{$ind->indagine_referto}}"/>
                                                                                                    @else
                                                                                                        <input id="referto_new{{$ind->id_indagine}}" name="referto_new{{$ind->id_indagine}}" type="text" readonly class="form-control" style="width:75%; float:left; " value=""/>
                                                                                                        <input id="referto_new{{$ind->id_indagine}}Id" name="referto_new{{$ind->id_indagine}}Id" hidden type="text" value=""/>
                                                                                                    @endif
                                                                                                    <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('referto','_new{{$ind->id_indagine}}','divReferto_new{{$ind->id_indagine}}', 'modalRefertoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                    <br /><br />
                                                                                                </div>
                                                                                                <button id="modalRefertoButton_new{{$ind->id_indagine}}" name="modalRefertoButton_newC{{$ind->id_indagine}}" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('referto','divReferto_new{{$ind->id_indagine}}','modalRefertoButton_new{{$ind->id_indagine}}', 'referto_new{{$ind->id_indagine}}', 'referto_new{{$ind->id_indagine}}Id')">
                                                                                                    Carica referto
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divAllegatiC{{$ind->id_indagine}}">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label col-lg-4">Allegato</label>
                                                                                            <div class="col-lg-5">

                                                                                                <?php
                                                                                                $allegati = $ind->getAllegati();
                                                                                                $n = sizeof($allegati);
                                                                                                $n++;
                                                                                                $i=1;
                                                                                                ?>
                                                                                                @foreach($allegati as $allegato)
                                                                                                    <div id="divAllegato_newC{{$ind->id_indagine}}_{{$i}}" name="divAllegato_newC{{$ind->id_indagine}}_{{$i}}">
                                                                                                        <input id="allegato_newC{{$ind->id_indagine}}_{{$i}}" name="allegato_newC{{$ind->id_indagine}}_{{$i}}" type="text" readonly class="form-control" value="{{($ind->getFile($allegato->id_file))->file_nome}}" style="width:75%; float:left; " />
                                                                                                        <input id="allegato_newC{{$ind->id_indagine}}_{{$i}}Id" name="allegato_newC{{$ind->id_indagine}}_{{$i}}Id" hidden type="text" value="{{$allegato->id_file}}" />
                                                                                                        <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('allegato_newC{{$ind->id_indagine}}_','{{$i}}','divAllegato_newC{{$ind->id_indagine}}_{{$i}}','modalAllegatoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                        <br /><br />
                                                                                                    </div>
                                                                                                    <?php $i++;?>
                                                                                                @endforeach
                                                                                                @for($i=$n;$i<=10;$i++)
                                                                                                    <div id="divAllegato_newC{{$ind->id_indagine}}_{{$i}}" name="divAllegato_newC{{$ind->id_indagine}}_{{$i}}" style="display: none;">
                                                                                                        <input id="allegato_newC{{$ind->id_indagine}}_{{$i}}" name="allegato_newC{{$ind->id_indagine}}_{{$i}}" type="text" readonly class="form-control" style="width:75%; float:left; " />
                                                                                                        <input id="allegato_newC{{$ind->id_indagine}}_{{$i}}Id" name="allegato_newC{{$ind->id_indagine}}_{{$i}}Id" hidden type="text" />
                                                                                                        <div class="btn btn-danger" style="width: 20%; float: right;" onclick="minusPressed('allegato_newC{{$ind->id_indagine}}_','{{$i}}','divAllegato_newC{{$ind->id_indagine}}_{{$i}}','modalAllegatoButton_new{{$ind->id_indagine}}')">-</div>
                                                                                                        <br /><br />
                                                                                                    </div>
                                                                                                @endfor
                                                                                                <button id="modalAllegatoButton_new{{$ind->id_indagine}}" name="modalAllegatoButton_new{{$ind->id_indagine}}" type="button" class="btn btn-primary" data-toggle="modal"  data-target="#favoritesModal" onclick="caricaFilePressed('allegato','divAllegato_newC{{$ind->id_indagine}}_','modalAllegatoButton_new{{$ind->id_indagine}}', 'allegato_newC{{$ind->id_indagine}}_', 'allegato_newC{{$ind->id_indagine}}_')">
                                                                                                    Carica allegato
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="text-align:center;">
                                                                                    <a href="" onclick="annullaC()" class=annulla id="annullaC"><button class="btn btn-danger"><i class="icon icon-undo"></i> Annulla modifiche</button></a>
                                                                                    <a href="" onclick="return false;" class=conferma data-id="{{($ind->id_indagine)}}" data-mod="C{{$ind->id_indagine}}_"><button class="btn btn-success"><i class="icon icon-check"></i> Conferma modifiche</button></a>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                <script>

                                                                    //imposta lo stato del form per la modifica di una indagine completata
                                                                    $('#form{{($ind->id_indagine)}}').change('statoIndagine_new{{($ind->id_indagine)}}', function(){

                                                                        var stato = $('#statoIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(stato == 0){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").hide();
                                                                            $("#divData_new{{($ind->id_indagine)}}").hide();
                                                                            $("#divRefertiC{{($ind->id_indagine)}}").hide();
                                                                            $("#divAllegatiC{{($ind->id_indagine)}}").hide();

                                                                        }

                                                                        if(stato == 1){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").show();
                                                                            $("#divData_new{{($ind->id_indagine)}}").show();
                                                                            $("#divRefertiC{{($ind->id_indagine)}}").hide();
                                                                            $("#divAllegatiC{{($ind->id_indagine)}}").hide();
                                                                        }

                                                                        if(stato == 2){

                                                                            $("#divCentro_new{{($ind->id_indagine)}}").show();
                                                                            $("#divData_new{{($ind->id_indagine)}}").show();
                                                                            $("#divRefertiC{{($ind->id_indagine)}}").show();
                                                                            $("#divAllegatiC{{($ind->id_indagine)}}").show();
                                                                        }

                                                                    });

                                                                    //permette di visualizzare l'input text 'altra motivazione' nel form della modifica delle indagini completate
                                                                    $('#form{{($ind->id_indagine)}}').change('motivoIndagine_new{{($ind->id_indagine)}}', function(){
                                                                        var motivo = $('#motivoIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(motivo == 0){

                                                                            document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "text";
                                                                        }else{
                                                                            document.getElementById("motivoAltro_new{{($ind->id_indagine)}}").type = "hidden";

                                                                        }

                                                                    });

                                                                    //permette di visualizzare l'input text 'nuovo careprovider' nel form della modifica delle indagini completate
                                                                    $('#form{{($ind->id_indagine)}}').change('cppIndagine_new{{($ind->id_indagine)}}', function(){
                                                                        var cpp = $('#cppIndagine_new{{($ind->id_indagine)}}').val();

                                                                        if(cpp == -1){

                                                                            document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "text";
                                                                        }else{
                                                                            document.getElementById("cppAltro_new{{($ind->id_indagine)}}").type = "hidden";

                                                                        }
                                                                    });

                                                                    $(function(){

                                                                        $('input[type=radio][name=radioTipo_new{{$ind->id_indagine}}]').change(function(){
                                                                            var radio = $('input[type=radio][name=radioTipo_new{{$ind->id_indagine}}]:checked').val();
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").empty();
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("<option selected hidden style='display: none' value=\"placeholder\">Selezionare una motivazione..</option>");
                                                                            var $group = $("<optgroup label='Diagnosi del paziente'>");
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append($group);
                                                                            if(radio=="Sospetta")
                                                                            {
                                                                                @foreach($current_user->diagnosi() as $d)
                                                                                @if($d->diagnosi_stato == 1)
                                                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                                                @endif
                                                                                @endforeach
                                                                            }
                                                                            else
                                                                            {
                                                                                @foreach($current_user->diagnosi() as $d)
                                                                                @if($d->diagnosi_stato == 0)
                                                                                $group.append("<option value='{{($d->diagnosi_patologia)}}--{{($d->diagnosi_inserimento_data)}}'>{{($d->diagnosi_patologia)}} del <?php echo date('d/m/y', strtotime($d->diagnosi_inserimento_data)); ?></option>");
                                                                                @endif
                                                                                @endforeach
                                                                            }
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("</optgroup>");
                                                                            $("#motivoIndagine_new{{$ind->id_indagine}}").append("<option value='0'>Nuova diagnosi..</option>");
                                                                        });
                                                                    });

                                                                </script>

                                                            @endif
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>    <!--paneldanger-->
                                        </div>    <!--col lg12-->
                                    </div><br>
                                </div>
                            </div>
                            <!-- FINE COLLAPSE DIARIO INDAGINI DIAGNOSTICHE -->
                            <script >

                                //permette di aprire il form per l'invio di una mail ad un centro indagini
                                $(document).on('click', "a.mail", function () {
                                    $(this).attr('data-target','#formModal');
                                    $("#nomeutente").val($(this).attr('data-id'));
                                    $("#mail").val("{{($current_user->getEmail())}}");

                                });

                                //permette di aprire il form per l'invio di un messaggio privato ad un cpp di un centro indagini
                                $(document).on('click', "a.a-messaggio", function () {
                                    $(this).attr('data-target','#messageModal');

                                });


                            </script>
                            <!-- COLLAPSE CENTRI INDAGINI DIAGNOSTICHE -->
                            <div id="collapse2" class="panel-collapse collapse"><hr/>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">Studi Specialistici</div>
                                            <div class=" panel-body">
                                                <div class="table-responsive" >
                                                    <table class="table" id="tableStudiSpecialistici">
                                                        <thead>
                                                        <tr>
                                                            <th>Studio</th>
                                                            <th>Sede</th>
                                                            <th>Contatti</th>
                                                            <th>Mail</th>
                                                            <th style="text-align:center">Messaggio FSEM</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($current_user->centriIndagini() as $c)
                                                            @if($c->id_tipologia === 1)
                                                                <tr>
                                                                    <td> {{$c->centro_nome}} </td>
                                                                    <td> {{$c->centro_indirizzo}} </td>
                                                                    <td>
                                                                        @foreach($current_user->contattoCentro($c->id_centro) as $cont)
                                                                            <i class="material-icons" style="font-size:16px">&#xe0cd;</i><a href="">{{$cont}}</a><br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td><button class="btn btn-warning"  type="button" id="btnSpec" value="{{($c->centro_mail)}}"  >
                                                                            <i class="icon-envelope"></i></button> <!-- data-target="#formModal" -->
                                                                        <a class="mail" data-id="{{($c->centro_mail)}}" data-toggle="modal" href="">{{$c->centro_mail}}</a>
                                                                    </td>
                                                                    <td> <button class="btn-messaggio btn"  type="button" id="" ><i class="material-icons" style="font-size:16px">&#xe0cb;</i></button>
                                                                        <a  class="a-messaggio" data-id="{{$current_user->cppPersCont($c->id_centro)}}" data-toggle="modal" href="">{{$current_user->cppPersCont($c->id_centro)}} </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>    <!--paneldanger-->
                                        </div>    <!--col lg12-->
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">Studi Radiologici</div>
                                            <div class=" panel-body">
                                                <div class="table-responsive" >
                                                    <table class="table" id="tableStudiRadiologici">
                                                        <thead>
                                                        <tr>
                                                            <th>Studio</th><th>Sede</th><th>Contatti</th><th>Mail</th><th style="text-align:center">Messaggio FSEM</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($current_user->centriIndagini() as $c)
                                                            @if($c->id_tipologia === 2)
                                                                <tr>
                                                                    <td> {{$c->centro_nome}} </td>
                                                                    <td> {{$c->centro_indirizzo}} </td>
                                                                    <td>
                                                                        @foreach($current_user->contattoCentro($c->id_centro) as $cont)
                                                                            <i class="material-icons" style="font-size:16px">&#xe0cd;</i><a href="">{{$cont}}</a><br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td><button class="btn btn-warning"  type="button" id="btnSpec" value="{{($c->centro_mail)}}"  >
                                                                            <i class="icon-envelope"></i></button> <!-- data-target="#formModal" -->
                                                                        <a class="mail" data-id="{{($c->centro_mail)}}" data-toggle="modal" >{{$c->centro_mail}}</a>
                                                                    </td>
                                                                    <td> <button class="btn-messaggio btn"  type="button" id="" ><i class="material-icons" style="font-size:16px">&#xe0cb;</i></button>
                                                                        <a  class="a-messaggio" data-id="{{$current_user->cppPersCont($c->id_centro)}}" data-toggle="modal" href="">{{$current_user->cppPersCont($c->id_centro)}} </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>    <!--paneldanger-->
                                        </div>    <!--col lg12-->
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">Laboratori Analisi</div>
                                            <div class=" panel-body">
                                                <div class="table-responsive" >
                                                    <table class="table" id="tableLaboratoriAnalisi">
                                                        <thead>
                                                        <tr>
                                                            <th>Studio</th><th>Sede</th><th>Contatti</th><th>Mail</th><th style="text-align:center">Messaggio FSEM</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($current_user->centriIndagini() as $c)
                                                            @if($c->id_tipologia === 3)
                                                                <tr>
                                                                    <td> {{$c->centro_nome}} </td>
                                                                    <td> {{$c->centro_indirizzo}} </td>
                                                                    <td>
                                                                        @foreach($current_user->contattoCentro($c->id_centro) as $cont)
                                                                            <i class="material-icons" style="font-size:16px">&#xe0cd;</i><a href="">{{$cont}}</a><br>
                                                                        @endforeach
                                                                    </td>
                                                                    <td><button class="btn btn-warning"  type="button" id="btnSpec" value="{{($c->centro_mail)}}"  >
                                                                            <i class="icon-envelope"></i></button> <!-- data-target="#formModal" -->
                                                                        <a class="mail" data-id="{{($c->centro_mail)}}" data-toggle="modal" >{{$c->centro_mail}}</a>
                                                                    </td>
                                                                    <td> <button class="btn-messaggio btn"  type="button" id="" ><i class="material-icons" style="font-size:16px">&#xe0cb;</i></button>
                                                                        <a  class="a-messaggio" data-id="{{$current_user->cppPersCont($c->id_centro)}}" data-toggle="modal" href="">{{$current_user->cppPersCont($c->id_centro)}} </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>    <!--paneldanger-->
                                        </div>    <!--col lg12-->
                                    </div>
                                </div><!--row-->
                            </div>
                            <!-- FINE COLLAPSE CENTRI INDAGINI DIAGNOSTICHE -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL CARICAMENTO FILE-->
    <div class="modal fade" id="favoritesModal" id="favoritesModal"
         tabindex="-1" role="dialog"
         aria-labelledby="favoritesModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form target="fileResponse" method="post" action="/uploadFileFromIndagini" enctype = "multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"
                                aria-label="Close" onclick="chiudiPressedInModal()">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"
                            id="favoritesModalLabel">Carica File</h4>
                    </div>
                    <div class="modal-body">
                        <p>Selezionare un file da caricare sul proprio registro.</p>
                        <input  type = "hidden" name = "idPaz" value = "{{$current_user->id_utente}}" />
                        <input type="file" id="nomefile" name="nomefile" required/>
                        <br /><br />
                        <label for="comm">Note sul file:</label>
                        <textarea name="comm" id="comm" cols = "60" rows = "2"  required></textarea>
                        <iframe frameBorder="0" id="fileResponse" name="fileResponse" style="height:50px;"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button name="closeModal" id="closeModal" type="button"
                                class="btn btn-default"
                                data-dismiss="modal">Chiudi</button>
                        <span class="pull-right">
          <button type="submit" class="btn btn-primary" id="buttonCarica" name="buttonCarica" onClick="caricaPressedInModal()">
            Carica
          </button>
        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--MODAL VISUALIZZAZIONE ALLEGATI-->
    <div class="modal fade" id="allegatiModal"  tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="favoritesModalLabel">Visualizza Allegato</h4>
                </div>
                <div class="modal-body">
                    <p>Selezionare un allegato dalla lista per visualizzarlo.</p>
                    @for($i=1;$i<=10;$i++)
                        <div id="divAllegatoInModal{{$i}}" style="display:none; margin-top:5px;">
                            <a id="linkDownloadAllegato{{$i}}" href="">
                                <button class="btn btn-info"  type="button">
                                    <i class="glyphicon glyphicon-list-alt"></i>
                                    <span id="spanAllegatoInModal{{$i}}">Nome File</span>
                                </button>
                            </a>
                        </div>
                    @endfor
                </div>
                <div class="modal-footer">
                    <button name="closeModal" id="closeModal" type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function caricaPressedInModal()
        {
            if(document.getElementById("nomefile").value!="" && document.getElementById("comm").value!="")
            {
                document.getElementById("buttonCarica").style.display='none';
            }
        }

        function caricaFilePressed(tipo, nomeDiv, nomeButton, input1, input2)
        {
            if(tipo == 'referto')
            {
                if(document.getElementById(nomeDiv).style.display != 'none')
                {
                    document.getElementById(nomeButton).removeAttribute("data-toggle");
                    window.alert("Impossibile caricare altri referti.");
                }
                else
                {
                    document.getElementById("closeModal").onclick = function ()
                    {
                        if(document.getElementById("buttonCarica").style.display=='none')
                        {
                            document.getElementById(nomeDiv).style.display = 'block';
                            document.getElementById(input1).value = document.getElementById("nomefile").value.split("\\")[2];
                            document.getElementById(input2).value = window.frames['fileResponse'].document.getElementById("idFileCaricato").value;
                            document.getElementById("buttonCarica").style.display = 'block';
                        }

                        document.getElementById("nomefile").value = "";
                        document.getElementById("comm").value= "";
                        var frame = document.getElementById("fileResponse"),
                            frameDoc = frame.contentDocument || frame.contentWindow.document;
                        frameDoc.documentElement.innerHTML="";
                    };
                }
            }
            else if(tipo == 'allegato')
            {
                if(document.getElementById(nomeDiv+"10").style.display != 'none')
                {
                    document.getElementById(nomeButton).removeAttribute("data-toggle");
                    window.alert("Impossibile caricare più di 10 allegati");
                }
                else
                {
                    document.getElementById("closeModal").onclick = function ()
                    {
                        if(document.getElementById("buttonCarica").style.display=='none')
                        {
                            var id;
                            if(document.getElementById(nomeDiv+"1").style.display== 'none')
                            {
                                nomeDiv+="1";
                                id="1";
                            }
                            else if(document.getElementById(nomeDiv+"2").style.display == 'none')
                            {
                                nomeDiv+="2";
                                id="2";
                            }
                            else if(document.getElementById(nomeDiv+"3").style.display == 'none')
                            {
                                nomeDiv+="3";
                                id="3";
                            }
                            else if(document.getElementById(nomeDiv+"4").style.display == 'none')
                            {
                                nomeDiv+="4";
                                id="4";
                            }
                            else if(document.getElementById(nomeDiv+"5").style.display == 'none')
                            {
                                nomeDiv+="5";
                                id="5";
                            }
                            else if(document.getElementById(nomeDiv+"6").style.display == 'none')
                            {
                                nomeDiv+="6";
                                id="6";
                            }
                            else if(document.getElementById(nomeDiv+"7").style.display == 'none')
                            {
                                nomeDiv+="7";
                                id="7";
                            }
                            else if(document.getElementById(nomeDiv+"8").style.display == 'none')
                            {
                                nomeDiv+="8";
                                id="8";
                            }
                            else if(document.getElementById(nomeDiv+"9").style.display == 'none')
                            {
                                nomeDiv+="9";
                                id="9";
                            }
                            else if(document.getElementById(nomeDiv+"10").style.display == 'none')
                            {
                                nomeDiv+="10";
                                id="10";
                            }

                            document.getElementById(nomeDiv).style.display = 'block';
                            document.getElementById(input1+id).value = document.getElementById("nomefile").value.split("\\")[2];
                            document.getElementById(input2+id+"Id").value = window.frames['fileResponse'].document.getElementById("idFileCaricato").value;
                            document.getElementById("buttonCarica").style.display = 'block';
                        }

                        document.getElementById("nomefile").value = "";
                        document.getElementById("comm").value= "";
                        var frame = document.getElementById("fileResponse"),
                            frameDoc = frame.contentDocument || frame.contentWindow.document;
                        frameDoc.documentElement.innerHTML="";
                    };
                }
            }
        }

        function minusPressed(tipo,id,nomeDiv,nomeButton)
        {
            if(tipo == 'allegato' || tipo.substring(0,13) == 'allegato_newC' || tipo.substring(0,13) == 'allegato_newP' || tipo.substring(0,13) == 'allegato_newR')
            {
                var prefissoDiv, prefissoInput;
                if(tipo == 'allegato')
                {
                    prefissoDiv = "divAllegato";
                    prefissoInput = tipo;
                }
                else
                {
                    prefissoDiv = nomeDiv.split("_")[0]+"_"+nomeDiv.split("_")[1]+"_";
                    prefissoInput = tipo.split("_")[0]+"_"+tipo.split("_")[1]+"_";
                }

                var i=parseInt(id);
                var flag = false;
                while(i<10 && !flag)
                {
                    if(document.getElementById(prefissoDiv+(i+1)).style.display != 'none')
                    {
                        document.getElementById(prefissoInput+i).value = document.getElementById(prefissoInput+(i+1)).value;
                        document.getElementById(prefissoInput+i+"Id").value = document.getElementById(prefissoInput+(i+1)+"Id").value;
                        i++;
                    }
                    else
                    {
                        flag = true;
                        document.getElementById(prefissoInput+i).value="";
                        document.getElementById(prefissoInput+i+"Id").value="";
                        document.getElementById(prefissoDiv+i).style.display = 'none';
                    }
                }
            }
            else
            {
                document.getElementById(tipo+id).value="";
                document.getElementById(tipo+id+"Id").value="";
                document.getElementById(nomeDiv).style.display = 'none';
            }
            document.getElementById(nomeButton).setAttribute("data-toggle","modal");
        }
    </script>
    <!-- FINE ACCORDION -->
    <!--END PAGE CONTENT -->
@endsection
