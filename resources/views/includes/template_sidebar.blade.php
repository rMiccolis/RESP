<!-- RIGHT STRIP  SECTION -->
<div id="right">
<br>

	<!--PARAMETRI DI MONITORAGGIO-->
	<div class="panel panel-primary">
		<div class="panel-body">
			<ul class="list-small">
				<li><strong>Altezza</strong>:
					<span>
						ALTEZZA-VAL
					</span> m <span>(DATA INSERIMENTO ALTEZZA)</span>
				</li>
				<li><strong>Peso</strong>:
					<span>
						PESO-VAL
					</span> kg <span>(DATA INSERIMENTO PESO)</span>
				</li>
				<li><strong>BMI</strong>:
					<span>BMI-VAL</span>
				<!-- TODO: implementare codice vecchio template -->
					</span>
				</li>
				<li><strong>P.A.</strong>:
					<span>PA-VAL</span>
				<!-- TODO: implementare codice vecchio template -->
					</span> <span>(DATA-PA>)</span>
				</li>
				<li><strong>F.C.</strong>:
					<span>FC-VAL</span>
				<!-- TODO: implementare codice vecchio template -->
					</span> bpm <span>(DATA INSERIMENTO FC)</span>
				</li>
			</ul>
		</div>
	</div>
	<!--FINE PARAMETRI DI MONITORAGGIO-->
	<!--TERAPIE FARMACOLOGICHE IN CORSO-->
	<div class="panel panel-warning">
    	<div class="panel-heading">Terapie farmacologiche in corso</div>
		<div class="panel-body">
			<div class="table-responsive">
				<small>
					<table class="table">
						<thead>
							<tr>
								<th style="font-size: 12px">Farmaco</th>
                                <th style="font-size: 12px">Data inizio</th>
                                <th style="font-size: 12px">Data fine</th>
							</tr>
						</thead>
						<tbody>
						    @foreach($terapie as $ind)
                                @if($ind->tipo_terapia == 1 && (($confidenzialita_auth != 0 && $confidenzialita_auth >= $ind->id_livello_confidenzialita) || ($confidenzialita_auth == 0)))
                                <tr>
                                    <td style="font-size: 12px">
                                        {{$ind->getFarmaco()->descrizione_breve}}
                                    </td>
                                    <td style="font-size: 12px">
                                        {{$ind->data_inizio->format('d/m/Y')}}
                                    </td>
                                    <td style="font-size: 12px">
                                    {{$ind->data_inizio->format('d/m/Y')}}
                                    </td>
                                </tr>
                                @endif
                            @endforeach
						</tbody>
					</table>
				</small>
			</div>
		</div>
	</div>
	<!--FINE TERAPIE FARMACOLOGICHE IN CORSO-->
	<!--FARMACI DA NON SOMMINISTRARE-->
	<div class="panel panel-danger">
		<div class="panel-heading">Farmaci da non somministrare</div>
		<div class="panel-body">
			<div class="table-responsive">
				<small>
					<table class="table">
						<thead>
							<tr>
								<th style="font-size: 12px">Farmaco</th>
                                <th style="font-size: 12px">Principio Attivo</th>
                                <th style="font-size: 12px">Motivo</th>
							</tr>
						</thead>
						<tbody>
						@foreach($terapie as $ind)
                            @if($ind->tipo_terapia == 0)
                            <tr>
                                <td style="font-size: 12px">
                                    {{$ind->getFarmaco()->descrizione_breve}}
                                </td>
                                <td style="font-size: 12px">
                                    {{$ind->getFarmaco()->getPrincipioAttivo()}}<!-- get farmaco saved in db  -->
                                </td>
                                <td style="font-size: 12px">
                                    {{$ind->note}}<!-- get text verificatosi  -->
                                </td>
                            </tr>
                            @endif
                        @endforeach
						</tbody>
					</table>
				</small>
			</div>
		</div>
	</div>
	<!--FINE FARMACI DA NON SOMMINISTRARE-->
	<!--ANAMNESI PATOLOGICA-->
	<div class="panel panel-primary">
		<div class="panel-heading">Anamnesi Patologica (prossima e remota)</div>
		<div class="panel-body">
			<div class="table-responsive">
				<small>
					<table class="table">
						<thead>
							<tr>
								<th>
								<strong style="font-size: 12px;"><b>Patologia</b></strong></th>
								<th><strong style="font-size: 12px "><b>Data Principio</b></strong></th>
								<th><strong style="font-size: 12px;"><b>Data Guarigione</b></strong></th>
								<th><strong style="font-size: 12px;"><b>Stato</b></strong></th>
							</tr>
						</thead>
						<tbody>
						<!-- TODO: implementare codice vecchio template -->
						</tbody>
					</table>
				</small>
			</div>
		</div>
	</div>
	<!--FINE ANAMNESI PATOLOGICA-->
</div>
<!-- END RIGHT STRIP  SECTION -->