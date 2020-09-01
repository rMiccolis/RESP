@extends('layouts.app') @extends('includes.template_head')

@section('pageTitle', 'Visite') @section('content')


<!--PAGE CONTENT -->

@if($errors->any())
<div style="display:none" class="errorForm" id="errorForm_{{$errors->first()}}"></div>
@endif


<script>

window.onload =  function() {
			
			let error = $('.errorForm').attr('id');

			if (error != undefined) {
				error = error.split('_')[1]
			alert("Errore nell'aggiunta della visita: " + error);
			}
};



</script>





<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Visite</h2>

                        <?php
                        /*
                         * include_once ($_SERVER['DOCUMENT_ROOT'].'/sections/algoritmoDiagnostico.php');
                         * //session_start();
                         * //$_SESSION['cp_Id'] = getMyID();
                         * $myRole = getRole(getMyID());
                         * //$_SESSION['pz_Id'] = $this->get_var("pz_Id");
                         *
                         * $pz_id = $_SESSION['pz_Id'];
                         * if ( isset ( $_SESSION['cp_Id'])){
                         * $cp_id = $_SESSION['cp_Id'];
                         * $id_prop = $cp_id;
                         * }
                         * else
                         * $id_prop = getMyID();
                         * $maxConfidentiality = 0;
                         * $defaultPermissions = false;
                         * if($myRole == 'ass' or $myRole == 'emg' or getInfo('idcpp', 'careproviderpaziente', 'idutente = ' . $pz_id ) == getMyID())
                         * {
                         * $response = 'Permit';
                         * $maxConfidentiality = INF;
                         * $defaultPermissions = true;
                         * }
                         * else
                         * $response = getResponse('Diario visite', 'Lettura');
                         * if ($response == 'Permit')
                         * {
                         * setAuditAction(getMyID(), 'Accesso a Visite');
                         * if ($maxConfidentiality == 0)
                         * $maxConfidentiality = policyInfo('Visite', 'Confidenzialit�');
                         * if (!$defaultPermissions)
                         * {
                         * $obligations = policyInfo('Diario visite', 'Obblighi');
                         * if ($obligations == 'In presenza del titolare' && $myRole != 'ass')
                         * echo "Questa sezione pu� essere consultata solo in presenza del titolare" .
                         * "<br>";
                         * }
                         * }
                         * else echo "<h5>Permesso negato<h5>";
                         */
                        // $today = date('Y-m-d');
                        ?>
		<br>
			</div>
		</div>

		<hr />
		<form class="form-horizontal" 
					action="{{action('VisiteController@addVisita')}}" method="POST" enctype="multipart/form-data" id="visit">
					{{ Form::open(array('url' => '/visite/addVisita')) }}
					{{ csrf_field() }}
		<div class="row">
			<div class="col-lg-12">
				
				<div class="btn-group">
					<!--bottoni per la gestione della visita -->
					<button type="button" class="btn btn-primary" id="btn_nuovavisita"
						onclick="onClickNuovaVisita()">
						Inizia Nuova Visita
					</button>
					 <!-- <button type="submit" class="btn btn-primary" id="btn_concludivisita" disabled="true"
						onclick="onClickConcludiVisita() ">
						<i class="icon-ok-sign"></i> Concludi visita
						</button> -->
						{{ Form::submit('Concludi visita', ['id'=>"btn_concludivisita",
						'onclick'=>"onClickConcludiVisita()", 'class' => 'btn btn-primary', 'disabled'=>true])}}
					
					<!--<button class="btn btn-primary" id="btn_salvavisita" disabled><i class="icon-save"></i> Salva visita</button>-->
					<button class="btn btn-primary" id="btn_annullavisita" disabled
						onclick="onClickAnnullaVisita()">
						Annulla visita
					</button>
				</div>
				
			</div>
		</div>

		
		<!-- FUNZIONI PER GESTIRE I BUTTON "INIZIA NUOVA VISITA", "CONCLUDI VISITA" E "ANNULLA VISITA" -->
					<script>
						function avviaAlgoritmoDIagnostico() {
                            	$.ajaxSetup({
		                            headers: {
		                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                            }
		                        });

		                        $.ajax({
		                            type: 'POST',
		                            url: '{{ route("algoritmoDiagnostico") }}',
		                            success: function(response)
		                            {
		                                console.log(response);

		                                var divToShow = document.getElementById("display_algoritmo");
  										divToShow.style.display = "block";

  										var tHeadTable = document.getElementById('tHeadTable');
  										while(tHeadTable.firstChild) { 
		                                    tHeadTable.removeChild(tHeadTable.firstChild); 
		                                }

		                                var tr = document.createElement('tr');
										tHeadTable.appendChild(tr);

										var th = document.createElement('th');
										tr.appendChild(th);

										var th = document.createElement('th');
										th.innerHTML = "Diagnosi";
										tr.appendChild(th);

										var th = document.createElement('th');
										tr.appendChild(th);

										var th = document.createElement('th');
										th.setAttribute("class","text-center");
										th.innerHTML = "Anamnesi";
										tr.appendChild(th);

										var th = document.createElement('th');
										tr.appendChild(th);
										var th = document.createElement('th');
										tr.appendChild(th);

										var th = document.createElement('th');
										th.setAttribute("class","text-center");
										th.innerHTML = "Obiettività";
										tr.appendChild(th);

										var th = document.createElement('th');
										tr.appendChild(th);
										var th = document.createElement('th');
										tr.appendChild(th);

										var th = document.createElement('th');
										th.setAttribute("class","text-center");
										th.innerHTML = "Indagini";
										tr.appendChild(th);


  										var tBodyTable = document.getElementById('tBodyTable');
  										while(tBodyTable.firstChild) { 
		                                    tBodyTable.removeChild(tBodyTable.firstChild); 
		                                }

		                                for (var i = 0; i < response.length; i++) {
										  	var tr = document.createElement('tr');
										  	tr.id = i;
										  	tr.setAttribute("class","righe");
										  	tBodyTable.appendChild(tr);

										  	var td = document.createElement('td');
										  	td.setAttribute("align","center");
										  	tr.appendChild(td);

										  	var a = document.createElement('a');
										  	a.id = response[i].codice_diag + "z";
										  	a.setAttribute("name","btn_salvaDiagnosi");
										  	a.setAttribute("class","btn btn-warning btn-sm");
										  	td.appendChild(a);

										  	var itag = document.createElement('i');
										  	itag.setAttribute("class","icon-save");
										  	a.appendChild(itag);

										  	var td = document.createElement('td');
										  	td.innerHTML = response[i].codice_descrizione;
										  	tr.appendChild(td);

										  	var td = document.createElement('td');
										  	tr.appendChild(td);

										  	var td = document.createElement('td');
										  	td.setAttribute("align","center");
										  	tr.appendChild(td);

										  	var button = document.createElement('button');
										  	button.id = response[i].codice_diag + "a";
										  	button.setAttribute("name","btn_algoritmo");
										  	button.setAttribute("class","btn btn-success btn-sm");
										  	button.setAttribute("data-toggle","modal");
										  	button.setAttribute("data-target","#modCodeAlgo");
										  	td.appendChild(button);

										  	var itag = document.createElement('i');
										  	itag.setAttribute("class","icon-search");
										  	button.appendChild(itag);

										  	var td = document.createElement('td');
										  	tr.appendChild(td);
										  	var td = document.createElement('td');
										  	tr.appendChild(td);

										  	var td = document.createElement('td');
										  	td.setAttribute("align","center");
										  	tr.appendChild(td);

										  	var button = document.createElement('button');
										  	button.id = response[i].codice_diag + "b";
										  	button.setAttribute("name","btn_algoritmo");
										  	button.setAttribute("class","btn btn-success btn-sm");
										  	button.setAttribute("data-toggle","modal");
										  	button.setAttribute("data-target","#modCodeAlgo");
										  	td.appendChild(button);

										  	var itag = document.createElement('i');
										  	itag.setAttribute("class","icon-search");
										  	button.appendChild(itag);

										  	var td = document.createElement('td');
										  	tr.appendChild(td);
										  	var td = document.createElement('td');
										  	tr.appendChild(td);

										  	var td = document.createElement('td');
										  	td.setAttribute("align","center");
										  	tr.appendChild(td);

										  	var button = document.createElement('button');
										  	button.id = response[i].codice_diag + "c";
										  	button.setAttribute("name","btn_algoritmo");
										  	button.setAttribute("class","btn btn-success btn-sm");
										  	button.setAttribute("data-toggle","modal");
										  	button.setAttribute("data-target","#modCodeAlgo");
										  	td.appendChild(button);

										  	var itag = document.createElement('i');
										  	itag.setAttribute("class","icon-search");
										  	button.appendChild(itag);

										  	var td = document.createElement('td');
										  	td.setAttribute("align","center");
										  	tr.appendChild(td);

										  	cambiaNumPatologie(0);
										  	var select = document.getElementById("patologie");
    										select.value = 0;

											var button = document.getElementById("btn_annullaAlgo");
    										button.setAttribute('class','btn btn-danger');
											button.disabled = false;
										} 
		                                

		                            },
		                            error: function (error) {
		                                console.log(error);
		                            }


		                        }); 
                         }

                         function cambiaNumPatologie(index){
							if(index==0){
								$('.righe').hide();
								$('#0').show();
								$('#1').show();
								$('#2').show();
								$('#3').show();
								$('#4').show();	
							} else if(index==1){
								$('.righe').hide();
								$('#0').show();
								$('#1').show();
								$('#2').show();
								$('#3').show();
								$('#4').show();
								$('#5').show();
								$('#6').show();
								$('#7').show();
								$('#8').show();
								$('#9').show();
							} else {
								$('.righe').show();
							}
						}

                        function onClickNuovaVisita() {
								eraseAll();
                            	document.getElementById("btn_nuovavisita").innerHTML = "Visita in corso...";
                            	document.getElementById("avviso_no_visite").hidden = true;
                            	document.getElementById("display_visita").hidden = false;
                            	document.getElementById("form_visita").hidden = false;
                            	document.getElementById("tabs_nuovavisita").hidden = false;
                            	document.getElementById("btn_nuovavisita").disabled = true;
                  
                            	document.getElementById("btn_concludivisita").disabled = false;
                            	document.getElementById("btn_concludivisita").style.backgroundColor = "green";
                            	
                            	document.getElementById("btn_annullavisita").disabled = false;
                            	document.getElementById("btn_annullavisita").style.backgroundColor = "red"; 
                         }

                        function onClickAnnullaVisita() {
                        	document.getElementById("btn_nuovavisita").innerHTML = "Inizia Nuova Visita";
                        	document.getElementById("avviso_no_visite").hidden = false;
                        	document.getElementById("btn_nuovavisita").disabled = false;   
                        	                        	
                        	document.getElementById("btn_concludivisita").disabled = true;
                        	document.getElementById("btn_concludivisita").style.backgroundColor = "";
                        	
                        	document.getElementById("btn_annullavisita").disabled = true;
                        	document.getElementById("btn_annullavisita").style.backgroundColor = ""; 

                        	document.getElementById("display_visita").hidden = true;
                        	document.getElementById("form_visita").hidden = true;
							document.getElementById("tabs_nuovavisita").hidden = true;
							

							eraseAll();
                     }
                        function onClickConcludiVisita(){
                        	//window.open("http://www.html.it", "myWindow");
							setSelectedPlaces();
							if(

									document.getElementById("add_visita_data").value==""||
									document.getElementById("add_visita_motivazione").value==""||
									document.getElementById("add_visita_osservazioni").value==""||
									document.getElementById("add_visita_conclusioni").value==""||
									document.getElementById("add_parametro_altezza").value==""||
									document.getElementById("add_parametro_peso").value==""||
									document.getElementById("add_parametro_pressione_minima").value==""||
									document.getElementById("add_parametro_pressione_massima").value==""||
									document.getElementById("add_parametro_frequenza_cardiaca").value==""


						){
								alert("ERRORE AGGIUNTA VISITA, TUTTI I CAMPI SONO OBBLIGATORI");

							}else {

								alert("VISITA AGGIUNTA CORRETTAMENTE!");
							}

                        	document.getElementById("visit").submit();




                        	document.getElementById("btn_nuovavisita").innerHTML = "Inizia Nuova Visita";
                        	document.getElementById("avviso_no_visite").hidden = false;
                        	document.getElementById("btn_nuovavisita").disabled = false;
              
                        	document.getElementById("btn_concludivisita").disabled = true;
                        	document.getElementById("btn_concludivisita").style.backgroundColor = "";
                        	
                        	document.getElementById("btn_annullavisita").disabled = true;
                        	document.getElementById("btn_annullavisita").style.backgroundColor = ""; 

                        	document.getElementById("form_visita").hidden = true;
                        	document.getElementById("tabs_nuovavisita").hidden = true;
                        }                
                        </script>
		
		
		<br />
		<div class="row">
			<div class="col-lg-12">
				<div class="btn-group">
					<!--bottoni per la gestione della visita-->
					<button class="btn btn-warning" id="btn_avviaAlgo"
						data-toggle="modal" data-target="" onclick="avviaAlgoritmoDIagnostico()">
						<i class="icon-list"></i> Avvia algoritmo diagnostico
					</button>
					<button class="btn btn-warning" id="btn_annullaAlgo" disabled>
						<i class="icon-trash" disabled></i> Annulla algoritmo
					</button>
				</div>
			</div>
		</div>
		<hr />
		<div class="row" id="avviso_no_visite">
			<div class="col-lg-12">
				<h3>Non ci sono visite in corso.</h3>
			</div>
		</div>

		<!-- INIZIA NUOVA VISITA -->
		<div class="row" id="display_visita" hidden>
			<div class="col-lg-12">
				<ul class="nav nav-tabs" id="tabs_nuovavisita">
					<li class="active"><a href="#tab_info" data-toggle="tab">Info
							generali</a></li>
					<li><a href="#tab_rilevazioni" data-toggle="tab">Rilevazioni</a></li>
					<li><a href="#tab_files" data-toggle="tab">Files</a></li>
				</ul>


				<!-- INIZIO CONTENUTO TAB -->

					<div class="tab-content">
						<!--TAB INFO GENERALI-->
						<div class="tab-pane fade in active" id="tab_info">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_visita_data">Data:</label>
										<div class="col-lg-4">
											<!--  <input type="date" id="add_visita_data" name="add_visita_data"
												class="form-control" value=$today=date('Y-m-d') ;  >-->
												{{Form::date('date','', ['id'=>"add_visita_data", 'name'=>"add_visita_data", 'class' => 'form-control col-lg-6'])}}
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_visita_motivazione">Motivo
											visita:</label>
										<div class="col-lg-8">
											<!--  <input type="text" name="add_visita_motivazione" id="add_visita_motivazione"
												class="form-control col-lg-6" />-->
												{{Form::text('motivazioni','', ['id'=>"add_visita_motivazione", 'name'=>"add_visita_motivazione", 'class'=>'form-control col-lg-6'])}}
												
										</div>
									</div>
									<div class="form-group">
										<label for="add_visita_osservazioni"
											class="control-label col-lg-4">Osservazioni:</label>
										<div class="col-lg-8">
											<!-- <textarea id="add_visita_osservazioni" name="add_visita_osservazioni"
												class="form-control"></textarea>-->
												{{Form::text('osservazioni','', ['id'=>"add_visita_osservazioni", 'name'=>"add_visita_osservazioni", 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="add_visita_conclusioni"
											class="control-label col-lg-4">Conclusioni:</label>
										<div class="col-lg-8">
											<!--  <textarea id="add_visita_conclusioni" name="add_visita_conclusioni"
												class="form-control"></textarea>-->
												{{Form::text('conclusioni','', ['id'=>"add_visita_conclusioni", 'name'=>"add_visita_conclusioni", 'class'=>'form-control'])}}
										</div>
									</div>
									<!--
									<div class="form-group">
										<label for="visita_fileupl" class="control-label col-lg-4">Allegati:</label>
										<div class="col-lg-8">
											<input id="visita_fileupl" name="visita_fileupl[]" class="file" type="file" multiple=true data-preview-file-type="any"/>
										</div>
									</div>
									-->

								</div>
							</div>
						</div>

						<!--TAB MISURAZIONI-->
						<div class="tab-pane fade" id="tab_rilevazioni">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_parametro_altezza">Altezza(cm):</label>
										<div class="input-group col-lg-8">
											<!--  <span class="input-group-addon">cm</span> <input
												type="number" name="visita_altezza" id="visita_altezza"
												class="form-control" />-->
												{{Form::number('','', ['id'=>"add_parametro_altezza", 'name'=>"add_parametro_altezza", 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_parametro_peso">Peso(kg):</label>
										<div class="input-group col-lg-8">
											<!-- <span class="input-group-addon">kg</span> <input
												type="number" name="visita_peso" id="visita_peso"
												class="form-control" />-->
												{{Form::number('','', ['id'=>"add_parametro_peso", 'name'=>"add_parametro_peso", 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_parametro_pressione_minima">Pressione
											sistolica(mmHg):</label>
										<div class="input-group col-lg-8">
											<!-- <span class="input-group-addon">mmHg</span> <input
												type="number" name="visita_PAmax" id="visita_PAmax"
												class="form-control" />-->
												{{Form::number('','', ['id'=>"add_parametro_pressione_minima", 'name'=>"add_parametro_pressione_minima", 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_parametro_pressione_massima">Pressione
											diastolica(mmHg):</label>
										<div class="input-group col-lg-8">
											<!-- <span class="input-group-addon">mmHg</span> <input
												type="number" name="visita_PAmin" id="visita_PAmin"
												class="form-control" />-->
												{{Form::number('','', ['id'=>"add_parametro_pressione_massima", 'name'=>"add_parametro_pressione_massima", 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="add_parametro_frequenza_cardiaca">Frequenza
											cardiaca:</label>
										<div class="input-group col-lg-8">
											<!-- <span class="input-group-addon">bpm</span> <input
												type="number" name="visita_FC" id="visita_FC"
												class="form-control" />-->
												{{Form::number('','', ['id'=>"add_parametro_frequenza_cardiaca", 'name'=>"add_parametro_frequenza_cardiaca", 'class'=>'form-control'])}}
										</div>
									</div>
								</div>
							</div>
						</div>





						<div class="tab-pane fade" id="tab_files">
							<div class="row">
								<div class="col-lg-12" id="3d_canv">
								
									<div class="form-group">
										<input class="btn btn-primary" type="file" id="files" name="files[]" multiple="multiple">
										<input type="hidden" name="idLog" id="idLog" value="{{ $log->id_audit }}">
										<input type="hidden" name="meshes" id="meshes" value="">
										<br>
										<label for="descrizione">Aggiungi commento</label>
										<textarea rows="1" cols="50" name="descrizione" id="descrizione" form="visit"></textarea>
										
									</div>
									<canvas id="c" style="border:2px solid;"></canvas>

								</div>
							</div>
						</div>
						












						<!--fineTAB MISURAZIONI-->
					</div>
					{{ Form::close() }}
				</form>
				<!-- FINE CONTENUTO TAB -->
			</div>
		</div>


		<div class="row" id="display_algoritmo" hidden>
			<div class="form-group">
				<label class="control-label col-lg-3" for="patologie">Numero di patologie:</label>
				<div class="col-lg-2">
					<select class="form-control" name="patologie" id="patologie"
						onchange="cambiaNumPatologie(this.selectedIndex);">
						<option value="0">5</option>
						<option value="1">10</option>
						<option value="2">All</option>
					</select>
				</div>     
                <label class="control-label col-lg-12"></label>
			</div>

			<div class="col-lg-12">
				<ul class="nav nav-tabs" id="tabs_nuovavisita">
					<li class="active"><a href="#tab_algoritmo" data-toggle="tab">Algoritmo
							Diagnostico</a></li>
				</ul>

				<!-- INIZIO CONTENUTO TAB -->
				<form class="form-horizontal" id="form_visita">
					<div class="tab-content">
						<!--TAB INFO GENERALI-->
						<div class="tab-pane fade in active" id="tab_info">
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive" id="divTable">
										<table class="table" id="tableConfermate">
											<thead id = "tHeadTable">
												
											</thead>
											<tbody id= "tBodyTable">
        											
                                            </tbody>
										</table>
									</div>
									<!--table responsive-->
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- FINE CONTENUTO TAB -->
			</div>
		</div>


		<div class="accordion ac" id="accordionVisite">
			<div class="accordion-group">
				<div class="row">
					<div class="accordion-heading centered">
						<div class="col-lg-12">
							<div class="col-lg-4">
								<a class="accordion-toggle" data-toggle="collapse"
									data-parent="#accordionVisite" href="#Info">
									<h3>
										Informazioni Visite <span> <i class="icon-angle-down"></i>
										</span>
									</h3>
								</a>
							</div>
							<div class="col-lg-4">
								<a class="accordion-toggle" data-toggle="collapse"
									data-parent="#accordionVisite" href="#Rilievi">
									<h3>
										Precedenti Rilievi <span> <i class="icon-angle-down"></i>
										</span>
									</h3>
								</a>
							</div>
						</div>
						<!--col-lg-12-->
					</div>
					<!--accordion heading centered-->
				</div>
				<!--row-->
			</div>
			<!--accordion group-->

			<!-- TAB INFORMAZIONI VISITE PRECEDENTI -->
			<div id="Info" class="accordion-body collapse">
				<div class="row">
					<!--info-->
					<div class="col-lg-12">
						<h2>Informazioni Visite Precedenti</h2>
						<hr>
@foreach($current_user->visiteUser() as $visita)

						<!-- INSERIRE FOR PER TABELLE GIALLEEE -->
						<div class="panel-body">
							<div class="panel panel-warning">
								<div class="panel-heading">Visita del
									<?php echo date('d/m/y', strtotime($visita->visita_data)); ?>
									<button id="visita_{{$visita->id_visita}}" type="button" class="hideButton btn btn-default btn-primary" data-toggle="modal" data-target="#canvasModal_{{$visita->id_visita}}">
											<i class="icon-search"></i> Mostra Files</button></button>
								</div>
									
									<div class="table-responsive">
									<table class="table">
									
										<thead>
										
										</thead>
										<tbody>
										
											<form class="form-horizontal" id="modpatinfo" method="post">
												
												<div class="modal-body">
													<div class="form-group">
														<label class="control-label col-lg-4">Motivo:</label>
														<div class="col-lg-8">
															{{Form::label($visita->visita_motivazione)}}</div>
													</div>


													<div class="form-group">
														<label class="control-label col-lg-4">Osservazioni:</label>
														<div class="col-lg-8">
															{{Form::label($visita->visita_osservazioni)}}</div>
															
														</div>

													<div class="form-group">
														<label class="control-label col-lg-4">Conclusioni:</label>
														<div class="col-lg-8">
															{{Form::label($visita->visita_conclusioni)}}</div>
													</div>
													
													
											</form>
											
											

															

						<!-- Modasssssssssssssssssssssssssssssssssssssssssssssssssssssssssl -->
						<div class="modal visitsModal" id="canvasModal_{{$visita->id_visita}}" tabindex="-1" role="dialog" aria-labelledby="canvasModal_{{$visita->id_visita}}" aria-hidden="true">
						<div id="modalLarge" class="modal-dialog lg-modal-dialog">
							<div class="modal-content">
							<div class="modal-header">
								<h2 class="modal-title" id="canvasModallLabel">Files 3D <p id="myp"><strong><mark>Comandi per l'utilizzo:</mark><br>- Tasto destro del mouse per girare l'uomo<br>- Tasto centrale del mouse / doppio click destro per cambiare altezza della camera</strong></p></h2>
							</div>
							<div class="modal-body modalCanvas" id="modalCanvas_{{$visita->id_visita}}">
							<div class="right">
									<h1><strong>Files caricati per questa visita:</strong></h1><br>
									<ul>
									
									@foreach($men3D as $man)
									@if($man->id_visita == $visita->id_visita)
									<input type="hidden" id="man3d_{{$visita->id_visita}}" value="{{$man->selected_places}}"></input>
									@endif
									@endforeach


									<?php $i = 0;?>									
									@foreach($userFiles as $file)
									@if($file->pivot->id_visita == $visita->id_visita)
									<?php $i++;?> 
									<li style=" font-size: large;"><h3><strong><a href="downloadImage/{{$file->id_file}}">{{$file->file_nome}}</a></strong></h3></li>
									@endif

									@endforeach
									@if($i == 0)
									<!-- won't never be executed because if $i==0 then the modal button is not visible -->
									<!-- see Man3D_visite.js to understand -->
									<h1 id="noData_{{$visita->id_visita}}" class="noData"><strong>Nessun file caricato per questa visita</strong></h1> 
									@endif
								</ul>
								<br>
								<h2><strong>Commento inserito:</strong></h2>
								<p style=" font-size: large; left: 0.5%; position: relative;">
								<!-- <ul> -->
									<!-- <li style=" font-size: large; left: 1%; position: relative;">{{$visita->commento}}</li> -->
								<!-- </ul> -->
								{{$visita->commento}}
								</p>
								</div>
								
								
							</div>
							
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="icon-remove"></i> Close</button>
							</div>
							</div>
						</div>
						</div>
<!-- Modasssssssssssssssssssssssssssssssssssssssssssssssssssssssssl -->

										</tbody>
									</table>
								</div>
							</div>
							<!-- panel body -->
						</div>
						<!-- col lg 12 -->
						<!-- FINE FORR -->
						@endforeach
					</div>

				</div>
			</div>
			<!--FINE TAB INFORMAZIONI VISITE PRECEDENTI -->
							
								<?php
        // $numVisite = $this->get_var("numVisite");
        /*
         * for ( $i = 0; (($i < $numVisite) and ($i < 5)) ; $i++){
         * $cognome = $this->get_var("cognomeV".$i);
         * $dataVisita = italianFormat( $this->get_var("datavisita".$i) );
         * $motivo = $this->get_var("motivo".$i);
         * $osservazioni = $this->get_var("osservazioni".$i);
         * $conclusioni = $this->get_var("conclusioni".$i);
         * $idp = $this->get_var("idp".$i);
         * $idpro = $this->get_var("bool".$i);
         *
         * if ( $idpro == true ){
         * echo '<div class="panel panel-warning"><div class="panel-heading">';
         * echo 'Visita del '.$dataVisita.' inserita dal paziente';
         * echo'</div><div class="panel-body">';
         * echo '<strong>Motivo : </strong>'.$motivo.'<br>';
         * echo '<strong>Osservazioni : </strong>'.$osservazioni.'<br>';
         * echo '<strong>Conclusioni: </strong>'.$conclusioni.'<br>';
         * echo '</div></div>';
         * }else{
         * echo '<div class="panel panel-danger"><div class="panel-heading">';
         * echo 'Visita del '.$dataVisita.' inserita da '.$cognome.'';
         * echo'</div><div class="panel-body">';
         * echo '<strong>Motivo : </strong>'.$motivo.'<br>';
         * echo '<strong>Osservazioni : </strong>'.$osservazioni.'<br>';
         * echo '<strong>Conclusioni: </strong>'.$conclusioni.'<br>';
         * echo '</div></div>';
         * }
         * }
         */
        ?>


			<div id="Rilievi" class="accordion-body collapse">
				<div class="row">

					<!--rilievi-->
					<div class="col-lg-12">
						<h2>Rilievi Visite Precedenti</h2>
						<hr>
						<div class="panel panel-warning">
							<div class="panel-heading">Rilievi Visite Precedenti</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Data
												<th>Altezza</th>
												<th>Peso</th>
												<th>P.A. Max</th>
												<th>P.A. Min</th>
												<th>Freq. card.</th>
												<th>Rilevatore</th>
											</tr>
										</thead>
										<tbody>
										<!-- INIZIO FOR RILIEVI PRECEDENTI -->
										@foreach($parametri_vitali as $data)
										<tr>
											<td><!-- Data       --> <strong><?php echo date('d/m/y', strtotime($data->data)); ?></strong></td>
											<td><!-- Altezza    -->{{Form::label($data->parametro_altezza)}}</td>
											<td><!-- Peso       -->{{Form::label($data->parametro_peso)}}</td>
											<td><!-- P.A. Max   -->{{Form::label($data->parametro_pressione_massima)}}</td>
											<td><!-- P.A. Min   -->{{Form::label($data->parametro_pressione_minima)}}</td>
											<td><!-- Freq. Card.-->{{Form::label($data->parametro_frequenza_cardiaca)}}</td>
											<td><!-- Rilevatore -->{{Form::label($current_user->getSurname())}}</td>
										</tr>
										@endforeach
										<!-- FINE FOR -->
											
												<?php
            // $numParVit = $this->get_var("numParVit");
            /*
             * for ( $i = 0; (($i < $numParVit) and ($i < 5)) ; $i++){
             * $data = italianFormat($this->get_var("data".$i) );
             * $altezza = $this->get_var("paramaltezza".$i);
             * $peso = $this->get_var("parampeso".$i);
             * $paMax = $this->get_var("parampamax".$i);
             * $paMax = ( $paMax == 0) ? ' ------ ' : $paMax;
             * $paMin = $this->get_var("parampamin".$i);
             * $paMin = ( $paMin == 0) ? ' ------ ' : $paMin;
             * $fc = $this->get_var("paramfc".$i);
             * $fc = ( $fc == 0) ? ' ------ ' : $fc;
             * $prop = $this->get_var("propParam".$i);
             * $rilevatore = $this->get_var("rilevatore".$i);
             * echo'
             * <tr>
             * <td>'.$data. '</td>
             * <td>'. $altezza . '</td>
             * <td>'. $peso .'</td>
             * <td>'.$paMax .'</td>
             * <td>'. $paMin .'</td>
             * <td>'.$fc.'</td>
             * <td>'.$rilevatore.'</td>
             * </tr>';
             * }
             */
            ?>
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
			<!--accordion body collapse-->
		</div>


		<!--accordion visite-->

		<!--MODAL DIAGNOSI -->
		<div class="col-lg-12">
			<div class="modal fade" id="diagnosiModal" tabindex="-1"
				role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="titolo_moddiagnosi"></h4>
						</div>
						<form class="form-horizontal" id="form_moddiagnosi">
							<div class="modal-body">
								<ul class="nav nav-tabs" id="tabs_diagnosi">
									<li class="active"><a href="#tab_moddiagnosi" data-toggle="tab">Dati
											diagnosi</a></li>
									<li><a href="#tab_terapiefarmacologiche" data-toggle="tab">Terapie
											farmacologiche</a></li>
								</ul>

								<div class="tab-content">
									<!--TAB MODDIAGNOSI-->
									<div class="tab-pane active" id="tab_moddiagnosi">
										<div class="form-group">
											<label class="control-label col-lg-4">Patologia</label>
											<div class="col-lg-8">
												<input class="form-control" type="text" id="diag_patologia">
												<span class="help-block" id="diag_patologia_helpblock"></span>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4" for="diag_status">Status:</label>
											<div class="col-lg-8">
												<select name="diag_status" id="diag_status"
													class="form-control">
													<option value="Sospetta">Sospetta</option>
													<option value="Confermata">Confermata</option>
													<option value="Esclusa">Esclusa</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4" for="diag_datainizio">Data
												inizio:</label>
											<div class="col-lg-8">
												<input type="date" id="diag_datainizio"
													name="diag_datainizio" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-4" for="diag_datafine">Data
												fine:</label>
											<div class="col-lg-8">
												<input id="diag_datafine" name="diag_datafine"
													class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label for="diagnosi_osservazioni"
												class="control-label col-lg-4">Osservazioni:</label>
											<div class="col-lg-8">
												<textarea id="diagnosi_osservazioni"
													name="diagnosi_osservazioni" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<!--FINE TAB MODDIAGNOSI-->

									<!--TAB TERAPIE FARMACOLOGICHE-->
									<div class="tab-pane fade" id="tab_terapiefarmacologiche">
										<div class="row">
											<div class="col-lg-12">
												<div class="box dark">
													<header>
														<h5>Seleziona terapia farmacologica</h5>
														<div class="toolbar">
															<ul class="nav">
																<li><a id="btn_nuovaterfarm"><i
																		class="icon-plus-sign icon-white"></i> Nuova</a></li>
															</ul>
														</div>
													</header>
													<div class="body">
														<div class="table-responsive">
															<table class="table table-hover tooltip_terfarm">
																<thead>
																	<tr>
																		<th>Farmaco</th>
																		<th>Status</th>
																		<th>Data inizio<br /> <small class="text-muted">(aaaa-mm-gg)</small></th>
																		<th>Data fine<br /> <small class="text-muted">(aaaa-mm-gg)</small></th>
																		<th>Forma Farm.</th>
																		<th>Sommin.</th>
																		<th>Freq.</th>
																	</tr>
																</thead>
																<tbody id="tabella_terfarm">

																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12" id="box_dettagliterfarm"></div>
										</div>
									</div>


									<!--FINE TAB TERAPIE FARMACOLOGICHE-->
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default"
									data-dismiss="modal">Annulla</button>
								<button type="submit" class="btn btn-primary">Salva e Chiudi</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>


		<!-- FINE MODAL DIAGNOSI-->
	</div>

	<!--MODAL ALGORITMO DIAGNOSTICO-->
	<div class="col-md-4">
		<div class="modal fade" id="modCodeAlgo" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true" id="chiudimodpatinfo">&times;</button>
						<h4 class="modal-title" id="H2">Algoritmo Diagnostico</h4>
					</div>
					<form method="post">
						<div class="modal-body">
							<label style="font: bold;" id="lblDescrizione"></label>
							<div id="lblJsonCodeAlgo">
								<!--In questo DIV vengono aggiunte dalla funziona apriICD9 le checkbox con i relativi nomi-->
							</div>
							<!--modal-body-->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">Annulla</button>
							<button type="button" class="btn btn-success"
								data-dismiss="modal" onclick="salvaCheckAlgoDiag()">Salva</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<!--END PAGE CONTENT -->
<!-- The main three.js file -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/108/three.min.js'></script>
    <!-- This brings in the ability to load custom 3D objects in the .gltf file format. Blender allows the ability to export to this format out the box -->
    <script src='https://cdn.jsdelivr.net/gh/mrdoob/three.js@r92/examples/js/loaders/GLTFLoader.js'></script>
    <!-- This is a simple to use extension for three.js that activates all the rotating, dragging and zooming controls we need for both mouse and touch, there isn't a clear CDN for this that I can find -->
    <script src="{{ asset('js/OrbitControls.js') }}"></script>
	<script src="{{ asset('js/Man3d_visite.js') }}"></script>
	

@endsection
