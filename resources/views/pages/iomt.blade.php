@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'IoMT')
@section('content')

<!--PAGE CONTENT -->
<!--utilità per i pazienti Ospedali - Linee guida -->
<div id="content">
    <div class="inner" >
        <div class="col-lg-12"><h1><center> IoMT </center></h1>
        </div>
        <div class="accordion ac" id="accordionUtility">
            <div class="accordion-group">
                <div class="accordion-heading centered">
                    <div class = "col-lg-12">
                        <div  class = "col-lg-3">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#eKuore">
                                <h3>eKuore</h3>
                            </a>
                        </div>
                        <div  class = "col-lg-3">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#HbMeter">
                                <h3>HbMeter</h3>
                            </a>
                        </div>
                        <div  class = "col-lg-3">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#Kardia">
                                <h3>Kardia</h3>
                            </a>
                        </div>
                        <div  class = "col-lg-3">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUtility" href="#VoxTester">
                                <h3>VoxTester</h3>
                            </a>
                        </div>
                    </div><!--col-lg-12-->
                </div><!--accordion- group heading centered-->

                <!--Accordition eKuore-->
                <div id="eKuore" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class ="row">
                            <h3><center>eKuore</center></h3>
                            <!--Accordion Ospedali-->
                            <div class="accordion-group" id = "ac-Osp">
                                <div class="col-lg-12">
                                    <div class="panel warning">
                                        <div class = "panel-body">
                                            <br><br>
                                            <form action="{{ route('IoMTStore')}}" method="post" class="form-horizontal" enctype="multipart/form-data" id="formekuore">
                                                <input name="input_name" value="eKuore" hidden />
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <label for="upload_file" class="control-label col-sm-3">Upload auscultazione</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input class="form-control" type="file" name="upload_audio" id="upload_audio">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="btn btn-primary" type="submit" value="Upload auscultazione">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br><br><br>
                                            <div class="table-responsive">
                                                <table class="table" id="tableekuore">
                                                    <tr>
                                                        <th>Data caricamento</th>
                                                        <th>Auscultazioni</th>
                                                        <th>Azioni</th>
                                                    </tr>
                                                    @foreach($ekuores as $ekuore)
                                                    <tr>
                                                        <td>{{ $ekuore->date }}</td>
                                                        <td><a href="{{ url($ekuore->fileaudio) }}" download>{{ basename($ekuore->fileaudio) }}</a></td>
                                                        <td>
                                                            <!--TODO da implementare-->
                                                            <div class="btn-group">
                                                                <button class="btn btn-success"><i class="icon-ok"></i>Referto</button><!--Il colore del bottone dovrebbe essere verde solo in presenza del referto, settarlo a rosso in caso contrartio-->
                                                                <button class="btn btn-warning"><i class="icon-pencil"></i>Privacy</button>
                                                                <button class="btn btn-danger"><i class="icon-trash"></i>Elimina</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div><!--panel warning-->
                                </div><!--col-lg-12-->
                            </div><!--accordion-group ac-Osp-->
                        </div><!--row-->
                    </div><!--accordion inner-->
                </div><!--accordion-body collapse-->

                <!---Accordition HbMeter-->
                <div id="HbMeter" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class ="row">
                            <h3><center>HbMeter</center></h3>

                            <!--Accordion HbMeter-->
                            <div class="accordion-group" id = "ac-Osp">
                                <div class="col-lg-12">
                                    <div class="panel warning" >

                                        <div class = "panel-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Giorno dell'analisi</th>
                                                        <th>Valore dell'analisi</th>
                                                        <th>Analisi laboratorio</th>
                                                        <th>Immagine congiuntiva</th>
                                                        <th>Azioni</th>
                                                    </tr>
                                                    @foreach($hbmeters as $hbm)
                                                    <tr>
                                                        <td>{{ $hbm->analisi_giorno }}</td>
                                                        <td>{{ $hbm->analisi_valore }}</td>
                                                        @if($hbm->analisi_laboratorio == "0.0")
                                                        <td>-</td>
                                                        @else
                                                        <td>{{ $hbm->analisi_laboratorio }}</td>
                                                        @endif
                                                        <td><a href="{{url($hbm->img_palpebra)}}" download>{{ basename($hbm->img_palpebra) }}</a></td>
                                                        <td>
                                                            <!--TODO da implementare-->
                                                            <div class="btn-group-vertical">
                                                                <button class="btn btn-success"><i class="icon-ok"></i>Referto</button><!--Il colore del bottone dovrebbe essere verde solo in presenza del referto, settarlo a rosso in caso contrartio-->
                                                                <button class="btn btn-warning"><i class="icon-pencil"></i>Privacy</button>
                                                                <button class="btn btn-danger"><i class="icon-trash"></i>Elimina</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </table>

                                            </div>
                                        </div>

                                    </div><!--panel warning-->

                                </div><!--col-lg-12-->
                            </div><!--accordion-group ac-Osp-->
                        </div><!--row-->
                    </div><!--accordion inner-->
                </div><!--accordion-body collapse-->

                <!--Accordition Kardia-->
                <div id="Kardia" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class ="row">
                            <h3><center>Kardia</center></h3>
                            <!--Accordion Ospedali-->
                            <div class="accordion-group" id = "ac-Osp">
                                <div class="col-lg-12">
                                    <div class="panel warning">
                                        <div class = "panel-body">
                                            <br><br>
                                            <form action="{{ route('IoMTStore')}}" method="post" class="form-horizontal" enctype="multipart/form-data" id="formkardia">
                                                <input name="input_name" value="Kardia" hidden />
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <label for="upload_file" class="control-label col-sm-3">Upload ECG</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input class="form-control" type="file" name="upload_pdf" id="upload_pdf">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="btn btn-primary" type="submit" value="Upload ECG">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br><br><br>
                                            <div class="table-responsive">
                                                <table class="table" id="tablekardia">
                                                    <tr>
                                                        <th>Data caricamento</th>
                                                        <th>Ecg</th>
                                                        <th>Azioni</th>
                                                    </tr>
                                                    @foreach($kardias as $kardia)
                                                    <tr>
                                                        <td>{{ $kardia->date }}</td>
                                                        <td><a href="{{ url($kardia->filepdf) }}" download>{{ basename($kardia->filepdf) }}</a></td>
                                                        <td>
                                                            <!--TODO da implementare-->
                                                            <div class="btn-group">
                                                                <button class="btn btn-success"><i class="icon-ok"></i>Referto</button><!--Il colore del bottone dovrebbe essere verde solo in presenza del referto, settarlo a rosso in caso contrartio-->
                                                                <button class="btn btn-warning"><i class="icon-pencil"></i>Privacy</button>
                                                                <button class="btn btn-danger"><i class="icon-trash"></i>Elimina</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div><!--panel warning-->
                                </div><!--col-lg-12-->
                            </div><!--accordion-group ac-Osp-->
                        </div><!--row-->
                    </div><!--accordion inner-->
                </div><!--accordion-body collapse-->

                <!--Accordition VoxTester-->
                <div id="VoxTester" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class ="row">
                            <h3><center>VoxTester</center></h3>

                            <!--Accordion VoxTester-->
                            <div class="accordion-group" id = "ac-Osp">
                                <div class="col-lg-12">
                                    <div class="panel warning" >

                                        <div class = "panel-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Registrazione</th>
                                                        <th>Azioni</th>
                                                    </tr>
                                                    @foreach($uniquevoxtesters as $vxt)
                                                    <tr>
                                                        <td>{{ $vxt->date }}</td>
                                                        <td><a href="{{url($vxt->audio)}}" download>{{ basename($vxt->audio) }}</a></td>
                                                        <td>
                                                            <!--TODO da implementare-->
                                                            <div class="btn-group">
                                                                <button class="btn btn-success"><i class="icon-ok"></i>Referto</button><!--Il colore del bottone dovrebbe essere verde solo in presenza del referto, settarlo a rosso in caso contrartio-->
                                                                <button class="btn btn-warning"><i class="icon-pencil"></i>Privacy</button>
                                                                <button class="btn btn-danger"><i class="icon-trash"></i>Elimina</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </table>

                                            </div>
                                        </div>

                                    </div><!--panel warning-->

                                </div><!--col-lg-12-->
                            </div><!--accordion-group ac-Osp-->
                        </div><!--row-->
                    </div><!--accordion inner-->
                </div><!--accordion-body collapse-->



            </div><!--accordion group-->
        </div><!--accordion Utility-->

    </div><!--inner-->

</div> <!--content-->
<!--END PAGE CONTENT -->
@endsection