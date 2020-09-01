@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Taccuino Paziente')
@section('content')



<!--PAGE CONTENT -->
<!-- <script src="draw.js"></script> -->
<div id="content">
	<div class="inner" style="min-height:1200px;">
		<div class="row">
			<div class="col-lg-12">
				<h2>Taccuino Paziente</h2>
				<!-- TODO: Rinserire dal resp vecchio le politiche di lettura in base al livello di confidenzialità -->
			</div>
		</div>
	<hr />

	<!--inizio modal canvas-->
		{{ csrf_field() }}
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<div class="modal" id="canvasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Annotazioni del paziente e rappresentazione del dolore</h4><br>
					<!-- <button type="submit" id="sendBtn" onclick="save_pain()" name="sendBtn" class="btn btn-primary">Salva e Chiudi</button> -->
					<!--<button class="btn btn-danger btn-lg btn-line btn-block" style="text-align:left;" onclick="erase_dolore()">btn-lg-->
						<button type="button" class="btn btn-danger " style="text-align:right;" onclick="erase_dolore('front')">
							<i class="icon-eraser icon-2x"></i> Cancella tutto fronte</button>
							<button type="button" class="btn btn-danger " style="text-align:right;" onclick="erase_dolore_back('true', 'true')">
								<!--&nbsp;&nbsp;&nbsp;--><i class="icon-eraser icon-2x"></i> Cancella tutto retro</button>
								<button type="button" class="btn btn-danger " style="text-align:right;" onclick="cancella3D()">
									<!--&nbsp;&nbsp;&nbsp;--><i class="icon-eraser icon-2x"></i> Cancella 3D</button>
								<button type="button" class="btn btn-danger " style="text-align:right;" onclick="toggleBackFront()">
									<!--&nbsp;&nbsp;&nbsp;--><i class=" icon-resize-horizontal icon-2x"></i> Fronte/Retro</button>
									
									<button id="3d_button" type="button" class="btn btn-danger " style="text-align:right;" onclick="toggle3D()">
									<!--&nbsp;&nbsp;&nbsp;--><i class=" icon-resize-horizontal icon-2x"></i> Visuale 2D</button>
									<br><br>
									<div class="well col-lg-12">
											<div class="pain_save">
												
											<label class="control-label col-lg-1" for="datanota">Commento:</label>
												{{Form::textarea('save_pain_textarea', null, ['id'=>"save_pain_textarea", 'name'=>"save_pain_textarea", 'placeholder'=>"Inserire note personali come modalità di insorgenza del dolore, durata etc...", 'rows'=>"1", 'class'=>"form-control"])}}
											</div>
										</br><br>
									<div class="form-group">
											<label class="control-label col-lg-1" for="datanota">Data:</label>
											<div class="col-lg-3">
												{{Form::date('date', \Carbon\Carbon::now(), ['id'=>"datanota", 'name'=>"datanota", 'class'=>"form-control"])}}
											</div> 
											<form id="myform" action="/pazienti/taccuino/addReporting" method="POST" enctype="multipart/form-data">
											{{csrf_field()}}
											<input class="btn btn-primary" type="file" id="files" name="files[]" multiple="multiple">
											<input type="hidden" name="dataURLFront" id="dataURLFront" value="">
											<input type="hidden" name="dataURLBack" id="dataURLBack" value="">
											<input type="hidden" name="drawn_2d" id="drawn_2d" value="">
											<input type="hidden" name="datan" id="datan" value="">
											<input type="hidden" name="textarea" id="textarea" value="">
											<input type="hidden" name="meshes" id="meshes" value="">
											<input type="hidden" name="idLog" id="idLog" value="{{ $idLog->id_audit }}">

										</form>
										</div>
										
												
									</div>
									<p id="myp"><strong><mark>Comandi per l'utilizzo:</mark><br>- Tasto destro del mouse per girare l'uomo<br>- Tasto centrale del mouse / doppio click destro per cambiare altezza della camera</strong></p>	
								</div>

								<div class="modal-body" style="max-height: calc(100vh - 320px);" id="taccuino">
									
									<!-- <div class="row"> -->
									
										<div class="well col-lg-8" id="3d_canv">
											
											<canvas id="c" class="modalCanvass" style="border:2px solid;"></canvas>
											<canvas id="canvas_dolore" class="front" width="347" height="866" style="border:2px solid;"></canvas>
											<input type="hidden" name="front">
											<canvas id="canvas_dolore_back" class="back" width="347" height="866" style="border:2px solid;"></canvas>
											<input type="hidden" name="back">
										</div>
									<div class="well col-lg-4">
										
										<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#00ff00')">
											&nbsp;&nbsp;<img src="img/taccuino/dolore_verde.png" /> Nessun dolore</button>
											<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#ffffff')">
												&nbsp;&nbsp;<img src="img/taccuino/dolore_bianco.png" /> Dolore lieve</button>
												<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#2323d2')">
													&nbsp;&nbsp;<img src="img/taccuino/dolore_blu.png" /> Dolore moderato</button>
													<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#8a2070')">
														&nbsp;&nbsp;<img src="img/taccuino/dolore_viola.png" /> Dolore intenso</button>
														<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#7a0026')">
															&nbsp;&nbsp;<img src="img/taccuino/dolore_porpora.png" /> Dolore forte</button>
															<button type="button" class="btn btn-primary btn-lg btn-line btn-block" style="text-align:left;" onClick="color_dolore('#ff0000')">
																&nbsp;&nbsp;<img src="img/taccuino/dolore_rosso.png" /> Dolore molto forte</button>
																<br/>
                                                <button class="btn btn-danger btn-lg btn-line btn-block" style="text-align:left;" onclick="erase_dolore('all')">
                                                	&nbsp;&nbsp;&nbsp;<i class="icon-eraser icon-2x"></i> Cancella tutto</button>
													
												</div>
									<!-- fine row -->
											<!-- </div> -->
										<!-- fine modal-body -->
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" onclick="save_pain()">Salva e chiudi</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi e annulla</button>
										</div>
									</div>
									
								</div>
								
                            </div>

                        
                        <!--fine modal canvas-->

                            <div class="row">
                            	<div class="col-lg-12">
                            		<div class="box dark">
                            			@if($current_user->getDescription() == User::PATIENT_DESCRIPTION)
                            			<header>
                            				<h5>Aggiorna il taccuino</h5>
                            				</header>
                            				<p>
                            				<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#canvasModal" id="new"><i class="icon-pencil"></i>Nuova segnalazione</button>
                            				</p>
                            			@endif
                            			<div class="col-lg-12" id="home_page_canvas">
                            				<div class="panel panel-warning ">
                            					<div class="panel-heading">
                            						Annotazioni
                            					</div>
                            					<div class="panel-body">
												
                            						<div class="table-responsive" >
                            							<table class="table" style=" table-layout: fixed;">
                            								<thead>
                            									<tr>
                            										<th>Descrizione</th>
                            										<th>Data</th>
                            										<th>Opzioni</th>
                            									</tr>
                            								</thead>
                            								<tbody>
																<!-- TODO: rivedere dal vecchio resp le cronologie -->
																<?php $i = 0;?>
																@if(!empty($records))
																@foreach ($records as $record)
																
                            									<tr>
                            										<td class="fit"><div style="width: 500px; height:80px;overflow-y:scroll;">{{ $record->taccuino_descrizione }}</div></td>
                            										<td><?php echo date('d/m/y', strtotime($record->taccuino_data)); ?></td>
                            										<td>
                            											<form action="/pazienti/taccuino/removeReporting" method="POST">
                            												{{ csrf_field() }}
                            											
																			<div class="left">
																				@if($record->taccuino_2d_drawn == 1)
																			<button type="button" id="showPain_{{$record->id_taccuino}}" class="showPain btn btn-default btn-info" value="2D">
																				<i class='icon-search'></i>  2D
																			</button>
																			@endif
																			<button type="button" id="showPain_{{$record->id_taccuino}}" class="showPain btn btn-default btn-info" value="3D">
																			<i class='icon-search'></i>  3D
																			</button>
																			
																			
																			<!-- <button type="button" id="buttonFile_{{$record->id_taccuino}}"class= "btn btn-default btn-success buttonDownload" onclick ='fileDownload("{{$record->id_taccuino}}")' value="{{$record->id_taccuino}}"> <i class="icon-download"></i> Scarica Files</button> -->
																			
																			
																		
																			<div class="dropdown">
																				<button type="button" onclick="dropDownToggle('{{$record->id_taccuino}}')" data-toggle="dropdown" class="btn btn-success dropButton" value="{{$record->id_taccuino}}">Download <span class="caret"></span></button>
																					<div id="myDrop_{{$record->id_taccuino}}" class="dropdown-content large">
																					<?php $i = 0; ?>
																					@foreach($userFiles as $file)
																					@if($file->pivot->id_taccuino == $record->id_taccuino)
																						<a href="/downloadImage/{{$file->id_file}}">{{$file->file_nome}}</a>
																						<?php $i++; ?>
																						@endif
																						@endforeach
																						@if($i == 0)
																					<a>Nessun file associato alla segnalazione</a>
																					@endif
																					</div>
																			
																			
																			</div>

																			<button id="removePain_{{$record->id_taccuino}}" class="space removePain btn btn-default btn-danger">
																				<i class="icon-remove"></i>
																			</button>	
																		</div>
																			
																			@foreach($userFiles as $file)
																			@if($file->pivot->id_taccuino == $record->id_taccuino)
																			
																			<input type="hidden" id="download_{{$record->id_taccuino}}_{{$i}}" class="download_{{$record->id_taccuino}}" value="{{$file->pivot->id_file}}">
																			<?php $i++; ?>
																			@endif
																			@endforeach

																			
																	</td>
																		
																			
																			
																			<input type="hidden" name="id_taccuino" id="id_contact" value="{{$record->id_taccuino}}">
																		
																		<input id="painFront_{{$record->id_taccuino}}" type="hidden" value="{{$record->taccuino_report_anteriore}}"></input>
																		
																		<input id="painBack_{{$record->id_taccuino}}" type="hidden" value="{{$record->taccuino_report_posteriore}}"></input>
																		@if(count($men3D) > 0)
																		@foreach($men3D as $man)
																		@if($man->id_taccuino == $record->id_taccuino)
																		<input id="man3D_{{$record->id_taccuino}}" type="hidden" value="{{$man->selected_places}}"></input>
																		@endif
																		@endforeach
																		@endif
																	</tr>
																</form>
															
																<?php $i = $i + 1;?>
																@endforeach
																@endif
                            								</tbody>
														</table>
														
													</div>
													
                            					</div>
									<!--<div class="panel-footer" style="text-align:right">
										<button class="btn btn-primary btn-sm btn-line" data-toggle="modal" data-target="#modpatcontemergmodal"><i class="icon-pencil icon-white"></i> Modifica</button>
									</div>-->
									
							</div>
							
						</div>
						
							
							<canvas id="c" class="homeCanvas"></canvas>
							<center><img id="canvasimg" class="{{$current_user->getGender()}}>"> <img id="canvasimg_back"><br/><br/></center>
							
						
					
								
						
					</div>
				</div>
		</div>
	</div>
</div>

    <!-- The main three.js file -->
	<!-- if there are some problems just download Threejs library and insert the files needed in ./public/js -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/108/three.min.js'></script>
    <!-- This brings in the ability to load custom 3D objects in the .gltf file format. Blender allows the ability to export to this format out the box -->
    <script src='https://cdn.jsdelivr.net/gh/mrdoob/three.js@r92/examples/js/loaders/GLTFLoader.js'></script>
    <!-- This is a simple to use extension for three.js that activates all the rotating, dragging and zooming controls we need for both mouse and touch, there isn't a clear CDN for this that I can find -->
	<script src="{{ asset('js/OrbitControls.js') }}"></script>
	<script src="{{ asset('js/Man3d_taccuino.js') }}"></script>
	<script src="{{ asset('js/dolore.js') }}"></script>


<!--END PAGE CONTENT -->
@endsection