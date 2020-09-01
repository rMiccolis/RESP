<!-- MENU SECTION -->
	<div id="left">
		<div class="media user-media well-small">
		<!-- Url differenti per riconoscere l'impersonificazione dell'utente -->
		@if(Auth::user()->isImpersonating())
			<a class="user-link" href="/patient-home">
		@else
			<a class="user-link" href="/home">
		@endif
				<!-- TODO: Aggiungere controllo se l'immagine del profilo è stata impostata -->
				<img class="media-object img-thumbnail user-img" alt="Immagine Utente" src="/img/user.gif"/>
			</a>
			<br/>
			<div class="media-body">
				<h5 class="media-heading">
				{{$current_user->getName()}}
				</h5>
			
				<h5 class="media-heading">
				{{$current_user->getSurname()}}
				</h5>
			</div>
			<br/>
		</div>
		<!--ANAGRAFICA RIDOTTA-->
		<div class="well well-sm">
			<ul class="list-small">
				<li><strong>C.F.</strong>:
					<span>
						{{$current_user->getFiscalCode()}}
					</span>
				
				</li>
				<li><strong>Data di nascita</strong>:
					<span>
						<?php echo date('d/m/y', strtotime($current_user->getBirthdayDate())); ?>

					</span> <strong>Età</strong>:
					<span>
						{{$current_user->getAge($current_user->getBirthdayDate())}}
					</span>
				
				</li>
				<li><strong>Telefono</strong>: {{$current_user->getTelephone()}}
				</li>
				@if($current_user->getRole() == $current_user::CAREPROVIDER_ID)
				<li><a href="#" data-toggle="modal" data-target="#formModal"><i class="icon-envelope-alt"></i>{{$current_user->getEmail()}}</a>
				</li>
				@endif
			</ul>
			@if($current_user->getRole() == $current_user::CAREPROVIDER_ID)
				<button class="btn btn-primary btn-sm btn-line center-block" data-toggle="modal" data-target="#modcppswmodal"><i class="icon-key icon-white"></i> Modifica Password</button>
				@if(Session::has('SuccessEditPassword'))
				         <div class="alert alert-success" role="alert">
				             {{ Session::get('SuccessEditPassword') }}
				         </div>
				@endif
				@if ($errors->any())
					<div class="alert alert-danger" role="alert">
						@if(Session::has('FailEditPassword'))
	                		{{ Session::get('FailEditPassword') }}
	                	@endif
						@foreach ($errors->all() as $error)
	    					<li>{{ $error}}</li> 
	            		@endforeach
	            	</div>
				@endif
			@endif
		</div>
		<!--FINE ANAGRAFICA RIDOTTA-->
		
		<script>

		//permette di inviare una mail tramite il modal mail
		function send1(){
			
			var paz = document.getElementById("mail").value ;
			var cpp = document.getElementById("nomeutente").value ;
			var ogg = document.getElementById("oggettomail").value ;
			var testo = document.getElementById("contenuto").value ;

			
			window.location.href = "http://localhost:8000/mail/"+cpp+"/"+paz+"/"+ogg+"/"+testo;
			
			}


		</script>
		
		<script>
//Questa funzione prende i valori nel form della mail
function prendeValori(){
	var paz = document.getElementById("mail").value ;
	var cpp = document.getElementById("nomeutente").value ;
	var ogg = document.getElementById("oggettomail").value ;
	var testo = document.getElementById("contenuto").value ;
	window.location.href = "http://localhost:8000/mail/"+cpp+"/"+paz+"/"+ogg+"/"+testo;
	}
</script>
		
		
		<!--MODAL EMAIL-->
		<div class="col-lg-12">
			<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiformmodalmail">&times;</button>
							<h4 class="modal-title" id="H2">Nuova Email</h4>
						</div>
						<form class="form-horizontal" id="patmailform">
							<div class="modal-body">
								<div class="form-group">
									<!--il getvar deve prendere nome e cognome del medico-->
									<label class="control-label col-lg-4">A:</label>
								
									<div class="col-lg-8"><!-- readonly -->
										<input type="text" name="nomeutente" id="nomeutente" readonly value="EMAIL-CP"  class="form-control"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4">Da:</label>
									<div class="col-lg-8"><!-- readonly -->
										<input type="text" name="mail" id="mail" readonly value="PAZIENTE-EMAIL" class="form-control"/>
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
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
								<button type="submit" onclick="send1()" class="btn btn-primary">Invia</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<!--  FINE MODAL EMAIL-->

		@if($current_user->getRole() == $current_user::PATIENT_ID)
		<div class="row">
			<div class="well well-sm">

				<!-- TODO: aggiungere controllo se vi è già una visita in corso -->
				<a href="visits" class="btn btn-primary btn-block" id="btn_menu_nuovavisita"><i class="icon-stethoscope"></i>  Visite</a>

			</div>
		</div>

		<ul id="menu" class="collapse">
{{--			@if($current_user->isImpersonating())--}}
{{--				<li class="panel {{Request::path() === 'patient-summary' ? 'active' : ''}}"> <a href="/patient-summary-cp"> <em class="icon-table"></em> Patient Summary esteso </a>--}}
{{--				</li>--}}
{{--			@else--}}
{{--				<li class="panel {{Request::path() === 'patient-summary' ? 'active' : ''}}"> <a href="/patient-summary"> <em class="icon-table"></em> Patient Summary esteso </a>--}}
{{--				</li>--}}
{{--			@endif--}}
				<li class="panel {{Request::path() === 'patient-summary' ? 'active' : ''}}"> <a href="/patient-summary"> <em class="icon-table"></em> Patient Summary esteso </a>
			<!-- ANAMNESI -->

			<li class="panel {{Request::path() === 'anamnesi' ? 'active' : ''}}"> <a href="{{url('anamnesi')}}"> <em class="icon-archive"></em> Anamnesi </a>
			</li>


			<!-- VACCINAZIONE -->
            <li class="panel {{Request::path() === 'vaccinazioni' ? 'active' : ''}}"> <a href="/vaccinazioni"> <em class="icon-file-text-alt"></em> Vaccinazioni </a>
			</li>


			<!-- ALLERGIE / INTOLLERANZE -->

            <li class="panel {{Request::path() === 'indagini' ? 'active' : ''}}"> <a href="/indagini"> <em class="icon-search"></em> Indagini diagnostiche </a>
            </li>
			<li class="panel {{Request::path() === 'diagnosi' ? 'active' : ''}}"> <a href="/diagnosi"> <em class="icon-file-text-alt"></em> Diagnosi </a>
			</li>
            <li class="panel {{Request::path() === 'terapie_farmacologiche' ? 'active' : ''}}"> <a href="/terapie_farmacologiche"> <em class="icon-medkit"></em> Terapie farmacologiche </a>
            </li>

            <li class="panel {{Request::path() === 'IoMT' ? 'active' : ''}}"> <a href="{{route('IoMT')}}"> <em class="icon-globe"></em> IoMT </a></li>

			<li class="panel {{Request::path() === 'files' ? 'active' : ''}}"> <a href="/files"> <em class="icon-file"></em> Files </a>
			</li>
			<li class="panel  {{Request::path() === 'taccuino' ? 'active' : ''}}"> <a href="{{ url('taccuino') }}"> <em class="icon-book"></em> Taccuino Paziente </a>
			</li>
			<li class="panel {{Request::path() === 'calcolatrice-medica' ? 'active' : ''}}"> <a href="{{ url('calcolatrice-medica') }}"> <em class="icon-keyboard"></em> Calcolatrice Medica </a>
			</li>
			<li class="panel {{Request::path() === 'links' ? 'active' : ''}}"> <a href="{{ url('utility') }}"> <em class="icon-tag"></em> Utility </a>
			</li>
			
		</ul>
		@elseif($current_user->getRole() == $current_user::CAREPROVIDER_ID)
				<ul id="menu" class="collapse">
                    <li class="panel {{Request::path() === 'patients-list' ? 'active' : ''}}"> <a href="{{ url('patients-list') }}"> <i class="icon-stethoscope" style="font-size:36px"></i> Pazienti </a></li>
                    
                    <li class="panel {{Request::path() === 'structures' ? 'active' : ''}}"> <a href="{{ url('structures') }}"> <em class="icon-home" style="font-size:36px"></em> Strutture </a></li>
                </ul>
		@endif
	</div>
<!--END MENU SECTION -->

<!-- MODAL MODIFICA PASSWORD CARE PROVIDER-->
    <div class="col-lg-12">
        <div class="modal fade" id="modcppswmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudimodcppsw">&times;</button>
                        <h4 class="modal-title" id="H2">Modifica password</h4>
                    </div>
                    <form class="form-horizontal" action="/user/updatepassword" method="post">
					{{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modcurrentpsw" class="control-label col-lg-4">Password attuale:</label>
                            <div class="col-lg-8">
                                <input type="password" name="current_password" id="current_password" class="form-control col-lg-6" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modnewpsw" class="control-label col-lg-4">Nuova password:</label>
                            <div class="col-lg-8">
                                <input type="password" name="password" id="password" class="form-control col-lg-6" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label col-lg-4">Conferma password:</label>
                            <div class="col-lg-8">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control col-lg-6" value=""/>
                            </div>
                        </div>
                    </div> <!-- fine modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Salva</button> 
                    </div> <!-- fine modal-foote -->
                    </form>
				</div> <!-- fine modal-content -->
            </div> <!-- fine modal-dialog-->
        </div> <!-- fine modal -->
    </div>
    <!--FINE MODIFICA PASSWORD CARE PROVIDER-->