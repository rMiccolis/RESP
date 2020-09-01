@extends( 'layouts.fhirPatient' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'FHIR RELATEDPERSON' )
@section( 'content' )

<?php 

$emergency = $data_output['emergency'];
$pazFam = $data_output['pazFam'];
$parenti = $data_output['parenti'];
$relazioni = $data_output['relazioni'];
$patient = $data_output['patient'];

?>
<link href="/css/resourcePatient.css" rel="stylesheet">
<script src="/js/formscripts/resourceRelatedPerson.js"></script>

<!--PAGE CONTENT -->

        <div id="content"> <!--MODCN-->
            <div class="inner" style="min-height:800px;" >
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="box dark">
                            <header>
                                <h2 style="color:#1d71b8;"> FHIR RESOURCE RELATEDPERSON </h2>
                            </header> 
                            <div class="body">
                                <div class="table-responsive">
                                    <div class="panel-heading text-right">
                                        <div id="inputFile" style="display: none;">
                                            <form method="POST" action="/api/fhir/RelatedPerson" enctype="multipart/form-data">
                                            	{{ csrf_field() }}
                                                <input id="file" name="file" type="file" />
                                                <input hidden id="paziente_id" name="paziente_id" type="text" value="{{$patient->id_paziente}}" />
                                                <input id="import-file" type="submit" value="Import" class="btn btn-primary" disabled>
                                                <input id="import-annulla" type="button" value="Annulla" class="btn btn-default">
                                            </form>
                                        </div>
                                        <div id="inputFileUpdate"  style="display: none;">
                                      {{Form::open(array( 'id' => 'updateInputForm' , 'onsubmit' =>'updateInputForm()' ,'method' => 'PUT' ,'files'=>'true', 'enctype'=>'multipart/form-data'))}}
                                      {{ csrf_field() }}
                                      <input id="fileUpdate" name="fileUpdate" type="file" />
                                      <input hidden id="contatto_id" type="text" value="{{$current_user->id_utente}}" />
                                      <input hidden id="paziente_id" name="paziente_id" type="text" value="{{$patient->id_paziente}}" />
                                      {{Form::button('Upload',['id'=>'upload', 'type' => 'submit', 'class' => 'btn btn-primary', 'disabled'] )}}
                                      {{Form::button('Annulla',['id'=>'annulla', 'type' => 'button', 'class' => 'btn btn-default'] )}}
                                      {{Form::close()}} 
                                      
                                      </div>
                                        <u class="text-primary">Import Emergency Contact</u>
                                        <button id="upload-res"  onclick="openInputFile()" type="button" class="btn btn-primary btn-md btn-circle" ><i class="glyphicon glyphicon-cloud-upload"></i></button>
                                    </div> <!-- panel-heading text-right -->

<!-- DIV SHOW PATIENT -->
<div class="container">
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SHOW RELATEDPERSON RESOURCE</h4>
        </div>
        <div class="modal-body" >
        </div>
        <div class="modal-footer">
          <a class="link-export" >Export</a>
          </div>
      </div>
      
    </div>
  </div>
  
</div>
<!-- END DIV SHOW PATIENT -->

<!-- DIV EXPORT -->
<div class="container">
    <!-- Modal -->
  <div class="modal fade" id="myModalExport" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SELECT RESOURCES</h4>
        </div>
        <div class="modal-body" >
        </div>
        <div class="modal-footer">
        <button id="{{$patient->id_paziente}}" type="button" class="button-export1" >Export</button>
          </div>
      </div>
      
    </div>
  </div>
  
</div>
<!-- END DIV EXPORT -->

                                    <h2>EMERGENCY CONTACTS</h2>
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Surname</th>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Show</th>
                                                <th>Update</th>
                                                <th>Export</th>
                                                <th>Delete</th>
                                                </tr>                        
                                        </thead>
                                        <tbody>
                                        <tr>
                                        @foreach($emergency as $em)
                                        <td align="center">{{$em->id_contatto}}</td>
                                        <td align="center">{{$em->cognome}}</td>
                                        <td align="center">{{$em->nome}}</td>
                                        @foreach($relazioni as $rel)
                                        @if($rel->Code == $em->relazione)
                                        <td align="center">{{$rel->Display}}</td>
                                        @endif
                                        @endforeach
                                        <td align="center"> <button id="{{$em->id_contatto.',Contatto'}}" type="button " class="button-show" ><i class="glyphicon glyphicon-eye-open"></i></button></td>
                                        <td align="center"><button id="{{$em->id_contatto}}" value="{{$em->id_contatto}}"  onclick="openInputFileUpdate(this.id)" type="button" class="button-update" ><i class="icon-cloud-upload"></button></td>
                                        <td align="center">
                                       <button id="" type="button " class="button-export" ><i class="icon-cloud-download"></i></button>                  
                                       </td>
                                       <td align="center">
                                       {{Form::open(array( 'action' => array('Fhir\Modules\FHIRRelatedPerson@destroy', $em->id_contatto) ,'method' => 'DELETE'))}}
                                      {{ csrf_field() }}
                                      <input hidden id="patient_id" name="patient_id" type="text" value="{{$patient->id_paziente}}" />
                                      <input hidden id="type" name="type" type="text" value="EM" />
                                      {{Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'button-delete'] )  }}
                                      {{Form::close()}} 
                                       </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        
                                    </table>
                                    
                                    
                                    <div class="panel-heading text-right">
                                        <div id="inputFileRel" style="display: none;">
                                            <form method="POST" action="/api/fhir/RelatedPerson" enctype="multipart/form-data">
                                            	{{ csrf_field() }}
                                                <input id="fileRel" name="fileRel" type="file" />
                                                <input hidden id="paziente_id" name="paziente_id" type="text" value="{{$patient->id_paziente}}" />
                                                <input id="import-fileRel" type="submit" value="Import" class="btn btn-primary" disabled>
                                                <input id="import-annullaRel" type="button" value="Annulla" class="btn btn-default">
                                            </form>
                                        </div>
                                        <div id="inputFileUpdateRel"  style="display: none;">
                                      {{Form::open(array( 'id' => 'updateInputFormRel' , 'onsubmit' =>'updateInputFormRel()' ,'method' => 'PUT' ,'files'=>'true', 'enctype'=>'multipart/form-data'))}}
                                      {{ csrf_field() }}
                                      <input id="fileUpdateRel" name="fileUpdateRel" type="file" />
                                      <input hidden id="parente_id" type="text" value="{{$current_user->id_utente}}" />
                                      <input hidden id="paziente_id" name="paziente_id" type="text" value="{{$patient->id_paziente}}" />
                                      {{Form::button('Upload',['id'=>'uploadRel', 'type' => 'submit', 'class' => 'btn btn-primary', 'disabled'] )}}
                                      {{Form::button('Annulla',['id'=>'annullaRel', 'type' => 'button', 'class' => 'btn btn-default'] )}}
                                      {{Form::close()}} 
                                      
                                      </div>
                                        <u class="text-primary">Import Relatives</u>
                                        <button id="upload-res"  onclick="openInputFileRel()" type="button" class="btn btn-primary btn-md btn-circle" ><i class="glyphicon glyphicon-cloud-upload"></i></button>
                                    </div> <!-- panel-heading text-right -->
                                    
                                    
                                     <h2>RELATIVES</h2>
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Surname</th>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Show</th>
                                                <th>Update</th>
                                                <th>Export</th>
                                                <th>Delete</th>
                                                </tr>                        
                                        </thead>
                                        <tbody>
                                        <tr>
                                        @foreach($parenti as $p)
                                        <td align="center">{{$p->id_parente}}</td>
                                        <td align="center">{{$p->cognome}}</td>
                                        <td align="center">{{$p->nome}}</td>
                                        @foreach($pazFam as $pf)
                                        @if($pf->id_parente == $p->id_parente)
                                        @foreach($relazioni as $rel)
                                        @if($pf->relazione == $rel->Code)
                                        <td align="center">{{$rel->Display}}</td>
                                        @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                        <td align="center"> <button id="{{$p->id_parente.',Parente'}}" type="button " class="button-show" ><i class="glyphicon glyphicon-eye-open"></i></button></td>
                                        <td align="center"><button id="{{$p->id_parente}}" value="{{$p->id_parente}}"  onclick="openInputFileUpdateRel(this.id)" type="button" class="button-update" ><i class="icon-cloud-upload"></button></td>
                                        <td align="center">
                                       <button id="" type="button " class="button-export" ><i class="icon-cloud-download"></i></button>                  
                                       </td>
                                       <td align="center">
                                       {{Form::open(array( 'action' => array('Fhir\Modules\FHIRRelatedPerson@destroy', $p->id_parente) ,'method' => 'DELETE'))}}
                                      {{ csrf_field() }}
                                      <input hidden id="patient_id" name="patient_id" type="text" value="{{$patient->id_paziente}}" />
                                      <input hidden id="type" name="type" type="text" value="REL" />
                                      {{Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'button-delete'] )  }}
                                      {{Form::close()}} 
                                       </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        
                                    </table>
                                    
                                    
                                    
                                </div><!--table-responsive-->
                            </div ><!--body-->
                        </div><!--box dark-->
                    </div><!--class="col-lg-12-->
                </div><!--class="row"-->
            </div><!--class inner--->
        </div><!--nomenu-->
                    
            
    
    <!-- formscripts/admin.js da modificare con elencoPz.js-->
      <!--<script src="formscripts/admin.js"></script>-->
    <!-- MODCN -->
    <script src="formscripts/modcentercp.js"></script>
    <!-- Jquery Autocomplete -->
    <script src="assets/plugins/autocomplete/typeahead.bundle.js"></script>

    <!-- Script notifice tooltip -->
    <script src="formscripts/elencoPz.js"></script>
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--END PAGE CONTENT --> 

@endsection