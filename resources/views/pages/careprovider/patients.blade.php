@extends( 'layouts.app' )

@section( 'pageTitle', 'Pazienti' )
@section( 'content' )

    <script src="/js/formscripts/resourcePatient.js"></script>

<!--PAGE CONTENT -->
    <div class="container-fluid" id="content">
            <div class="inner" style="min-height:600px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box dark">
                            <header>
                                <h2>Elenco Pazienti</h2>
                            </header> 
                            <div class="body">
                                <div class="table-responsive">
                                    <table id="dataTables-elencopaz" class="table-striped table-bordered table-hover table display no-footer" data-sp-rows="30" role="grid">
                                        <thead>
                                            <tr role="row">
                                                <th tabindex="0" rowspan="1" colspan="1">ID</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Registro</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Mail</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Cognome</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Nome</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Codice Fiscale</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Telefono</th>
                                                <th tabindex="0" rowspan="1" colspan="1">Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patients as $patient)
                                                <tr align="center">
                                                    <td>{{$patient->id_paziente}}</td>
                                                    <td><a href="/patient-visit/{{$patient->id_paziente}}"><button class='btn btn-default btn-success' type='submit'><i class='icon-check'></i></button></a></td>
                                                    <td><button class='btn btn-warning btn-mailCppSet inviaMailPaziente' data-toggle='modal' data-target='#formModal1' type='button' id ='{{$patient->getMail()}}' onclick='passaDati("{{$patient->getName()}} {{$patient->getSurname()}}")' aria-haspopup= 'true' aria-expanded= 'true' value = '$j'><i class= 'icon-envelope'></i><div style="display:none;">{{$patient->getMail()}}</div></button></td>
                                                    <td style ="font-size: 14";><b>{{$patient->getSurname()}}</b></td>
                                                    <td style ="font-size: 14";><b>{{$patient->getName()}}</b></td>
                                                    <td>{{$patient->getFiscalCode()}}</td>
                                                    <td>{{$patient->getPhone()}}</td>
                                                    <td><button class='btn btn-info ' onclick='EXPORTPDF'><i class='icon-book'></i></button></td>
                                                </tr>
                                            @endforeach
                                            @empty($patients)
                                                Nessun paziente presente.
                                            @endempty
                                        </tbody>
                                    </table>
                                </div><!--table-responsive-->
                            </div ><!--body-->
                        </div><!--box dark-->
                    </div><!--class="col-lg-12-->
                </div><!--class="row"-->
            </div><!--class inner--->
    </div> <!--containerfluid-->

        <!--MODAL EMAIL-->
    <div class="col-lg-12">
        <div class="modal fade" id="formModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiformmodalmail">&times;</button>
                        <h4 class="modal-title" id="H2">Nuova Email</h4>
                    </div>
                    <form class="form-horizontal"  id="patmailform">
                    <div class="modal-body">
                        <div class="form-group">
                           <!--il getvar deve prendere nome e cognome del medico-->
                           <label class="control-label col-lg-4">Da {{$current_user->getName()}} {{$current_user->getSurname()}}</label>
                           <div class="col-lg-8">
                               <input type="text" name="nomeutente" id="nomeutente" value="{{$current_user->getEmail()}}" readonly class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4" id="nomePaziente"></label>
                            <div class="col-lg-8">
                                <input type="text" name="mail" id="mailPaziente" value="INVALID MAIL" readonly class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="oggettomail" class="control-label col-lg-4">Oggetto:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="oggettomail" id="oggettomail" class="form-control col-lg-6"/>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="contenuto" class="control-label col-lg-4">Testo:</label>
                            <div class="col-lg-8">
                               <textarea name="contenuto" id="contenuto" class="form-control col-lg-6" rows="6"></textarea>
                            </div>
                        </div>
                    </div> <!-- fine modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-abort" data-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Invia</button> 
                    </div>
                    </form>
                </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
        </div> <!-- fine modal -->
    </div> <!-- col-lg-12 -->
    <!--  FINE MODAL EMAIL-->   
    </div>

    <script>
        $(".inviaMailPaziente").click(function () {
            var mail = this.id;
            $("#mailPaziente").val(mail);
       });
    </script>
    
    <script type="text/javascript">
		function passaDati(nome){
				document.getElementById('nomePaziente').innerHTML = "A " + nome;
			}
	</script>

    <script>
        $(document).ready(function(){
            $('#dataTables-elencopaz').DataTable({
                "columnDefs": [
                    { "orderable": false, "aTargets": [1, 2, 6, 7 ]}
                ]
            });
        });
    </script>

    <!-- formscripts/admin.js da modificare con elencoPz.js-->
      <!--<script src="formscripts/admin.js"></script>-->
    <!-- MODCN -->
    <script src="formscripts/modcentercp.js"></script>
    <!-- Jquery Autocomplete -->
    <script src="assets/plugins/autocomplete/typeahead.bundle.js"></script>

    <!-- Script notifice tooltip -->
    <script src="formscripts/elencoPz.js"></script>

<!--END PAGE CONTENT --> 

@endsection