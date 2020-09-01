<?php
$id_careP= $current_user->dataCareProvider()->first()->id_cpp;
?>
<!-- MENU SECTION -->
<div id="left">
    <div class="row" >
        <div class="well well-sm">
        </div>
        <div class="well well-sm">
        </div>

    </div>
    <ul id="menu" class="collapse">
        <li class="panel" style="font-size:15px"> <a href="/fhirCareProviderIndexHome/{{$id_careP}}" > <em class="glyphicon glyphicon-user" ></em> Profile </a>
        </li>



        <!--  	<li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-hospital"></em> Organization </a>
            </li>
            <li class="panel" style="font-size:15px"> <a href="/"> <em class="glyphicon glyphicon-exclamation-sign"></em> Allergy Intollerance </a>
            </li>
            <li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-file-text-alt"></em> Device </a>
            </li>
            <li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-hospital"></em> Procedure </a>
            </li>
            <li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-file-text-alt"></em> Medication </a>
            </li>-->
    </ul>
    <!--END MENU SECTION -->
</div>
