jQuery(document).ready(function($) {

	//visualizza la modal modifica
	jQuery('body').on('click', '.open-modal', function() {
		var idTerapia = $(this).val();
		var tipo_terapia = $(this).data('tip_ter');
		$.get('terapia/' + idTerapia + '/' + tipo_terapia, function(data) {
			jQuery('#id_terapia_mod').val(data.id_terapie);
			jQuery('#id_farmaco_codifa_mod').val(data.id_farmaco);
			jQuery('#tipo_terapia_mod').val(data.tipo_terapia);
			jQuery('#somministrazione').val(data.somministrazione);
			jQuery('#forma_farmaceutica').val(data.forma_farmaceutica);
			jQuery('#data_Inizio').val(data.dataInizio);
			jQuery('#data_Fine').val(data.dataFine);
			jQuery('#diagnosi_mod').val(data.diagnosi);
			jQuery('#livello_confidenzialita_mod').val(data.livello_confidenzialita);
			jQuery('#verif_mod').val(data.verificatosi);
			jQuery('#note_diagnosi').val(data.note);

			if (tipo_terapia == '0') {
				jQuery('#confidenzialitaCampo_mod').hide();
				jQuery('#diagnosi_campo').hide();
				jQuery('#data_Inizio_campo').hide();
				jQuery('#data_Fine_campo').hide();
				jQuery('#verif_mod_campo').show();
				jQuery('#note_mod').text("Motivo *");
			}

			if (tipo_terapia == '1' || tipo_terapia == '2') {
				jQuery('#confidenzialitaCampo_mod').show();
				jQuery('#diagnosi_campo').show();
				jQuery('#data_Inizio_campo').show();
				jQuery('#data_Fine_campo').show();
				jQuery('#verif_mod_campo').hide();
			}

			if (tipo_terapia == '2') {
				jQuery('#note_mod').text("Motivo *");
			}

			jQuery('#btn-save').val("update");
			jQuery('#EditorModal').modal('show');


		});
	});
	//Aggiorna informazioni del farmaco nella modal modifica
	$("#id_farmaco_codifa_mod").change(function() {
		var idFarmaco = $(this).val();
		$.get('farmaco/' + idFarmaco, function(data) {

			jQuery('#somministrazione').val(data.somministrazione);
			jQuery('#forma_farmaceutica').val(data.forma_farmaceutica);

		});
	});

	//Aggiorna i campi nella modal modifica in base al tipo di terapa
	$("#tipo_terapia_mod").change(function() {

		var tipo_terapia = $(this).val();
		if (tipo_terapia == '0') {
			jQuery('#confidenzialitaCampo_mod').hide();
			jQuery('#diagnosi_campo').hide();
			jQuery('#data_Inizio_campo').hide();
			jQuery('#data_Fine_campo').hide();
			jQuery('#verif_mod_campo').show();
			jQuery('#note_mod').text("Motivo *");
		}

		if (tipo_terapia == '1' || tipo_terapia == '2') {
			jQuery('#confidenzialitaCampo_mod').show();
			jQuery('#diagnosi_campo').show();
			jQuery('#data_Inizio_campo').show();
			jQuery('#data_Fine_campo').show();
			jQuery('#verif_mod_campo').hide();
			jQuery('#note_mod').text("Note *");
		}

		if (tipo_terapia == '2') {
			jQuery('#note_mod').text("Motivo *");
		}


	});
	//visualizza informazioni farmaco nella modal info farmaco
	jQuery('body').on('click', '.open-info', function() {
		var idFarmaco = $(this).val();
		$.get('farmaco/' + idFarmaco, function(data) {
			jQuery('#nomeFarmacoTxt').text(data.nome_farmaco);
			jQuery('#atcTxt').text(data.atc);
			jQuery('#tipologiaSomministrazioneTxt').text(data.somministrazione);
			jQuery('#formaFarmaceuticaTxt').text(data.forma_farmaceutica);
			jQuery('#principioAttvoTxt').text(data.principio_attivo);
			jQuery('#infoFarmacoModal').modal('show');

		});

	});

});
//visualizza informazioni farmaco nella modal nuova terapia
jQuery("body").on("change", ".idFarmaco", function() {
	var idFarmaco = $(this).val();
	$.get('farmaco/' + idFarmaco, function(data) {
		jQuery('#id_farmaco_somministrazione').val(data.somministrazione);
		jQuery('#id_forma_farmaceutica').val(data.forma_farmaceutica);

	});
});
//ordina le terapie vietate, in corso, concluse in ordine alfabetico o cronologco
// cliccando sull'intestazoine delle colonne delle rispettive tabelle
function sortTable(tableClass, n) {
	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;

	table = document.getElementById('myTable' + tableClass);
	var element = document.getElementById('iconSortAlph' + tableClass);
	if (n == 0) {

		if (element.classList.contains('icon-sort-by-alphabet')) {

			element.classList.remove("icon-sort-by-alphabet");
			element.classList.add("icon-sort-by-alphabet-alt");

		} else {

			element.classList.remove("icon-sort-by-alphabet-alt");
			element.classList.add("icon-sort-by-alphabet");

		}
	}
	if (n == 1) {

		element = document.getElementById('iconSortNum' + tableClass);
		if (element.classList.contains('icon-sort-by-order')) {

			element.classList.remove("icon-sort-by-order");
			element.classList.add("icon-sort-by-order-alt");

		} else {

			element.classList.remove("icon-sort-by-order-alt");
			element.classList.add("icon-sort-by-order");
		}
	}

	switching = true;
	dir = "asc";
	while (switching) {
		switching = false;
		rows = table.rows;
		for (i = 1; i < (rows.length - 1); i++) {
			shouldSwitch = false;
			x = rows[i].getElementsByTagName("TD")[n];
			y = rows[i + 1].getElementsByTagName("TD")[n];
			if (dir == "asc") {
				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					shouldSwitch = true;
					break;
				}
			} else if (dir == "desc") {
				if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
					shouldSwitch = true;
					break;
				}
			}
		}
		if (shouldSwitch) {
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			switchcount++;
		} else {
			if (switchcount == 0 && dir == "asc") {
				dir = "desc";
				switching = true;
			}
		}
	}
}

//Nasconde la tabella selezionata alla sola riga di intestazione
function hideShow(tableID) {
	var table = document.getElementById(tableID);
	if (table.style.display === "none") {
		table.style.display = "block";
	} else {
		table.style.display = "none";
	}
}
//inserisce una nuova diagnosi
function nuovaDiagnosi() {

	var stato = document.getElementById("statoD").value;
	var Cpp = document.getElementById("CppIdD").value;
	var idPaz = document.getElementById("pzId").value;
	var patol = document.getElementById("nomeD").value;

	if (Cpp == -1) {
		Cpp = document.getElementById("cppAltro_new").value;
		idCpp = 0;
	}

	if (patol == '' || Cpp == 'notSelected' || stato == '') {
		alert("Compilare tutti i campi");

	} else {
		$.get("/addDiagn/" + stato + "/" + Cpp + "/" + idPaz + "/" + patol, function() {
			$('#formD')[0].reset();

			$.get("/getdiagnosi/", function(data) {

				var serversParsed = $.parseJSON(data);
				var $el = $("#diagnosi");
				$el.empty(); // remove old options

				$.each(serversParsed, function(index, value) {

					$el.append($("<option></option>").attr("value", value.id_diagnosi).text(value.diagnosi_patologia));
					$('#diagnosi').val(value.id_diagnosi);

				});

			});

		});
	}

}

//ricerca una terapia e ne mostra il risultato
function cercaTerapia() {

	var txtSearch = document.getElementById("txtCerca").value;
	var option;
	document.getElementById('msg_search').style.display = "none";
	document.getElementById('msg_search').textContent = "";

	if (document.getElementById("inlineRadio1").checked) { $option = 1}
	if (document.getElementById("inlineRadio2").checked) { $option = 2}
	if (document.getElementById("inlineRadio3").checked) { $option = 3}

	$.get("/searchTerapia/" + $option + "/" + txtSearch , function(data) {

		var serversParsed = $.parseJSON(data);
		var $el = $("#tbody_search0");
		$("#tbody_search0").empty();// remove old options
		$("#tbody_search1").empty();// remove old options
		$("#tbody_search2").empty();// remove old options
		if(data != '[]'){

			$.each(serversParsed, function(index, value) {

				if (value.tipo_terapia == 0) {

					$el = $('#tbody_search' + String(value.tipo_terapia));

					$el.append($("<tr>"));
					$el.append($("<td>" + value.nome_farmaco + "</td>"));
					$el.append($("<td>" + value.principio_attivo + "</td>"));
					$el.append($("<td>" + value.atc + "</td>"));
					$el.append($("<td>" + value.verificatosi + "</td>"));
					$el.append($("<td>" + value.note + "</td>"));
					$el.append($("<td>" + value.prescrittore + "</td>"));

				}

				if (value.tipo_terapia == 1 || value.tipo_terapia == 2) {

					$el = $('#tbody_search' + String(value.tipo_terapia));

					$el.append($("<tr>"));
					$el.append($("<td>" + value.nome_farmaco + "</td>"));
					$el.append($("<td>" + value.dataInizio + "</td>>"));
					$el.append($("<td>" + value.dataFine + "</td>>"));
					$el.append($("<td>" + value.prescrittore + "</td>"));
					$el.append($("<td>" + value.diagnosi + "</td>"));
					$el.append($("<td>" + value.note + "</td>"));

				}
				$el.append($("<td><button type=\"button\" class=\"btn btn-success open-modal\" value=\"" + value.id_terapie + "\" data-tip_ter=\"" + value.tipo_terapia + "\"><i class=\"icon-pencil icon-white\"></i></button> <button class=\"btn btn-primary open-info\"  data-toggle=\"modal\" value=\"" + value.id_farmaco + "\"><i class=\"icon-info-sign icon-white\"></i></button> <button type=\"button\" class=\"elimina btn btn-danger\" value=\"" + value.id_terapie + "\" ><i class=\"icon-remove icon-white\"></i></button></td></tr>" ));
			});
		} else {
			document.getElementById('msg_search').style.display = "block";
			document.getElementById('msg_search').textContent = "Nessuna Corrispondenza trovata";

		}

	});

}