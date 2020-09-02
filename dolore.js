// const { forEach } = require("lodash");
var userDrawnFront = 0;
var userDrawnBack = 0;
var canvas1, canvasback;
var ctx, ctxback;
var flag = false, flagback = false;
var prevX = 0;
var currX = 0;
var prevY = 0;
var currY = 0;
var dot_flag = false;

var prevXback = 0;
var currXback = 0;
var prevYback = 0;
var currYback = 0;
var dot_flagback = false;

var colorepennello = "white";
var dimpennello = 15;

var outlineImage = new Image();
var outlineImageBack = new Image();

function mobtabcheck() {
	var check = false;
	(function (a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true; })(navigator.userAgent || navigator.vendor || window.opera);
	return check;
};

$(document).ready(function () {

	checkNumberFiles();
	let neww = document.getElementById("new");
	neww.style.zIndex = 99;
	neww.style.position = "relative";

	$('.homecanvas').show();
	$("#canvasimg").hide();
	$("#canvasimg_back").hide();

	//window.mobilecheck=mobcheck();
	window.mobileAndTabletcheck = mobtabcheck();

	if ($('#canvasimg').hasClass('F')) {
		outlineImage.src = "img/taccuino/female_front_.png";
		outlineImageBack.src = "img/taccuino/female_back_.png";
	} else {
		outlineImage.src = "img/taccuino/male_front_.png";
		outlineImageBack.src = "img/taccuino/male_back_.png";
	}
	outlineImage.onload = function () {
		prepareCanvas("");
		save_dolore("");
	}

	outlineImageBack.onload = function () {
		prepareCanvas("_back");
		save_dolore("_back");
	}

	$('#canvas_dolore_back').hide();
	$('#canvas_dolore').hide();

});

function toggleBackFront() {
	$('#c').hide();
	if ($('#canvas_dolore_back').is(":visible")) {
		$('#canvas_dolore_back').hide();
		$('#canvas_dolore').show();
		$('.modalCanvass').hide(); // canvas element relative to 3d man inside the modal
	} else {
		$('#canvas_dolore').hide();
		$('#canvas_dolore_back').show();
		$('#c').hide(); //#c is the id of the 3d men canvas (controlled from script1.js) so we hide both 3d men inside modal and on the home page (taccuino)
	}

}





function toggle3D() {

	if ($("#canvas_dolore_back").is(":visible") || $("#canvas_dolore").is(":visible")) {
		$("#3d_button").html('<i class=" icon-resize-horizontal icon-2x"></i> Visuale 2D');
		$("#canvas_dolore_back").hide();
		$("#canvas_dolore").hide();
		$("#c").show();	//#c is the id of the 3d men canvas (controlled from Man3d_taccuino.js)

	} else {
		$("#3d_button").html('<i class=" icon-resize-horizontal icon-2x"></i> Visuale 3D');
		$("#canvas_dolore_back").hide();
		$("#canvas_dolore").show();
		$("#c").hide(); //#c is the id of the 3d men canvas (controlled from script1.js)

	}

}

function prepareCanvas(fb) {
	//console.log("Canvas: " + 'canvas_dolore' + fb);
	if (fb == "_back") {
		canvasback = document.getElementById('canvas_dolore' + fb);
		ctxback = canvasback.getContext("2d");
		ctxback.fillStyle = "#00ff00";

		w = canvasback.width;
		h = canvasback.height;
		ctxback.fillRect(0, 0, w, h);

		ctxback.drawImage(outlineImageBack, 0, 0, w, h);

	} else {
		canvas1 = document.getElementById('canvas_dolore' + fb);
		ctx = canvas1.getContext("2d");
		ctx.fillStyle = "#00ff00";
		w = canvas1.width;
		h = canvas1.height;
		ctx.fillRect(0, 0, w, h);
		ctx.drawImage(outlineImage, 0, 0, w, h);
	}
	if (window.mobileAndTabletcheck == false) {
		$("#canvas_dolore" + fb).mousemove(function (e) {
			findxy('move', e, fb);
		});
		$("#canvas_dolore" + fb).mousedown(function (e) {
			findxy('down', e, fb);
		});
		$("#canvas_dolore" + fb).mouseup(function (e) {
			findxy('up', e, fb);
		});
		$("#canvas_dolore" + fb).mouseout(function (e) {
			findxy('out', e, fb);
		});
	} else {
		$("#canvas_dolore" + fb).bind("touchmove", function (e) {
			// console.log("touchmove");
			e.preventDefault();
			e.stopImmediatePropagation();
			findxy_touch('move', e, fb);
			findxy_touch('down', e, fb);
		});

		$("#canvas_dolore" + fb).bind("touchstart", function (e) {
			// console.log("touchstart");
			e.preventDefault();
			e.stopImmediatePropagation();
			findxy_touch('down', e, fb);
		});

		$("#canvas_dolore" + fb).bind("touchend", function (e) {
			// console.log("touchend");
			e.preventDefault();
			e.stopImmediatePropagation();
			findxy_touch('up', e, fb);
			findxy_touch('out', e, fb);
		})
	};
}



function findxy_touch(res, e, fb) {
	//console.log(res);
	var rect = e.target.getBoundingClientRect();
	e.offsetX = e.touches[0].pageX - rect.left;
	e.offsetY = e.touches[0].pageY - rect.top;

	if (fb == "_back") {
		if (res == 'down') {
			prevXback = currXback;
			prevYback = currYback;
			currXback = e.offsetX;// - canvas.offsetLeft;
			currYback = e.offsetY;// - canvas.offsetTop;

			flagback = true;
			dot_flagback = true;
			if (dot_flagback) {
				ctxback.beginPath();
				ctxback.fillStyle = colorepennello;
				ctxback.fillRect(currXback, currYback, 0, 0);
				ctxback.closePath();
				dot_flagback = false;
			}
		}
		if (res == 'up' || res == "out") {
			flagback = false;
		}
		if (res == 'move') {
			if (flagback) {
				prevXback = currXback;
				prevYback = currYback;
				currXback = e.offsetX;// - canvas.offsetLeft;
				currYback = e.offsetY;// - canvas.offsetTop;
				draw(fb);
			}
		}
	} else {
		if (res == 'down') {
			prevX = currX;
			prevY = currY;
			currX = e.offsetX;// - canvas.offsetLeft;
			currY = e.offsetY;// - canvas.offsetTop;

			flag = true;
			dot_flag = true;
			if (dot_flag) {
				ctx.beginPath();
				ctx.fillStyle = colorepennello;
				ctx.fillRect(currX, currY, 0, 0);
				ctx.closePath();
				dot_flag = false;
			}
		}
		if (res == 'up' || res == "out") {
			flag = false;
		}
		if (res == 'move') {
			if (flag) {
				prevX = currX;
				prevY = currY;
				currX = e.offsetX;// - canvas.offsetLeft;
				currY = e.offsetY;// - canvas.offsetTop;
				draw(fb);
			}
		}
	}
}

function findxy(res, e, fb) {
	//console.log(res);

	if (fb == "_back") {
		if (res == 'down') {
			prevXback = currXback;
			prevYback = currYback;
			currXback = e.offsetX;// - canvas.offsetLeft;
			currYback = e.offsetY;// - canvas.offsetTop;

			flagback = true;
			dot_flagback = true;
			if (dot_flagback) {
				ctxback.beginPath();
				ctxback.fillStyle = colorepennello;
				ctxback.fillRect(currXback, currYback, 0, 0);
				ctxback.closePath();
				dot_flagback = false;
			}
		}
		if (res == 'up' || res == "out") {
			flagback = false;
		}
		if (res == 'move') {
			if (flagback) {
				prevXback = currXback;
				prevYback = currYback;
				currXback = e.offsetX;// - canvas.offsetLeft;
				currYback = e.offsetY;// - canvas.offsetTop;
				draw(fb);
			}
		}
	} else {
		if (res == 'down') {
			prevX = currX;
			prevY = currY;
			currX = e.offsetX;// - canvas.offsetLeft;
			currY = e.offsetY;// - canvas.offsetTop;

			flag = true;
			dot_flag = true;
			if (dot_flag) {
				ctx.beginPath();
				ctx.fillStyle = colorepennello;
				ctx.fillRect(currX, currY, 0, 0);
				ctx.closePath();
				dot_flag = false;
			}
		}
		if (res == 'up' || res == "out") {
			flag = false;
		}
		if (res == 'move') {
			if (flag) {
				prevX = currX;
				prevY = currY;
				currX = e.offsetX;// - canvas.offsetLeft;
				currY = e.offsetY;// - canvas.offsetTop;
				draw(fb);
			}
		}
	}
}

function findOffsetY() {
	return e.offsetY;
}

function findOffsetX() {
	return e.offsetX;
}

function draw(fb) {

	if (fb == "_back") {

		// console.log('dietro');
		userDrawnBack = 1;
		ctxback.beginPath();
		ctxback.moveTo(prevXback, prevYback);
		ctxback.lineTo(currXback, currYback);
		ctxback.strokeStyle = colorepennello;
		ctxback.lineWidth = dimpennello;
		ctxback.lineJoin = 'round';
		ctxback.lineCap = 'round';

		//ctxback.stroke();
		//ctxback.closePath();

		//ctxback.clearRect(0, 0, w, h);

		ctxback.stroke();
		ctxback.closePath();

		ctxback.drawImage(outlineImageBack, 0, 0, w, h);
	} else {
		// console.log('avanti');
		userDrawnFront = 1;
		ctx.beginPath();
		ctx.moveTo(prevX, prevY);
		ctx.lineTo(currX, currY);
		ctx.strokeStyle = colorepennello;
		ctx.lineWidth = dimpennello;
		ctx.lineJoin = 'round';
		ctx.lineCap = 'round';


		//ctx.clearRect(0, 0, w, h);

		ctx.stroke();
		ctx.closePath();

		ctx.drawImage(outlineImage, 0, 0, w, h);
	}
}

function color_dolore(obj) {
	colorepennello = obj;
	changeSelectedColor(obj); //function from script1.js to change the selected color on the 3d man inside the modal
}


function erase_dolore(_3d_2d_front_back) {

	var m = confirm("Cancellare le modifiche selezionate?");


	let displayMessage = false;
	if (m) {

		userDrawnFront = 0;
		ctx.fillStyle = "#00ff00";
		ctx.fillRect(0, 0, w, h);
		ctx.drawImage(outlineImage, 0, 0);

		if (_3d_2d_front_back == 'all') {
			erase_dolore_back(true, false);
			eraseAll();	//function from script1.js to delete all the selected meshes on the 3d man inside the modal
		}

	}
}

function erase_dolore_back(erase, displayMessage) {
	if (erase) {
		userDrawnBack = 0;
		if (displayMessage) {
			// console.log("ciao");
			var m = confirm("Cancellare le modifiche selezionate?");
		} else {
			m = true;
		}

		if (m) {
			ctxback.fillStyle = "#00ff00";
			ctxback.fillRect(0, 0, w, h);
			ctxback.drawImage(outlineImageBack, 0, 0);
		}
	}
	//  else {
	// 	ctxback.fillStyle = "#00ff00";
	// 	ctxback.fillRect(0, 0, w, h);
	// 	ctxback.drawImage(outlineImageBack, 0, 0);
	// }


}

function save_dolore(fb) {
	if (fb == "_back") {
		//document.getElementById("canvasimg"+fb).style.border = "2px solid";
		var dataURL = canvasback.toDataURL();
		document.getElementById("canvasimg" + fb).src = dataURL;
	} else {
		//document.getElementById("canvasimg"+fb).style.border = "2px solid";
		var dataURL = canvas1.toDataURL();
		document.getElementById("canvasimg" + fb).src = dataURL;
	}

	//document.getElementById("canvasimg").style.display = "inline";
}


$(document).ready(function () {

	let showButtons = document.getElementsByClassName('showpain');

	for (button of showButtons) {
		if ($(button).val() == '3D') {

			var idShow = $(button).attr('id').split('_')[1];
			let strActivated = $("#man3D_" + idShow).val();

			if (strActivated == "empty") {
				$(button).hide();
			}
		} else {
			$(button).show();
		}
		// if ($(button).val() == '2D') {
		// 	console.log("ciao ci sono");
		// 	var idShow = $(button).attr('id').split('_')[1];

		// 	$(button).show();

		// }
	}
});



$('.showPain').click(function () {

	clickable = true;
	eraseAll();
	var idShow = $(this).attr('id').split('_')[1];

	//document.getElementById("canvasimg").style.border = "2px solid";
	document.getElementById("canvasimg_back").src = $('#painBack_' + idShow).val();
	document.getElementById("canvasimg").src = $('#painFront_' + idShow).val();
	//document.getElementById("canvasimg_back").style.border = "2px solid";


	let strActivated = $("#man3D_" + idShow).val();
	// console.log(strActivated);

	if (strActivated != "empty" && strActivated != null) {


		let activated = JSON.parse(strActivated);
		// console.log(activated);
		clickable = true;
		for (mesh of activated) {
			color = readSelectedColor(mesh.dolore);
			// console.log(mesh.dolore);
			// console.log(color);
			setMaterial(theModel, mesh.name, color);


		}
	}


	let showButtons = document.getElementsByClassName('showpain');

	for (button of showButtons) {
		$(button).removeClass('selected');
	}

	//if the selected button is that about the 3D visualization, hide 2D man and show 3D and viceversa
	if ($(this).val() == "3D") {
		$('#c').show();
		$("#canvasimg").hide();
		$("#canvasimg_back").hide();
		$(this).addClass('selected');
	} else {
		$('#c').hide();
		$("#canvasimg").show();
		$("#canvasimg_back").show();
		$(this).addClass('selected');
	}


	clickable = false;

});
//save all data in the db
function save_pain() {
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	//document.getElementById("canvasimg").style.border = "2px solid";
	var dataURLFront = canvas1.toDataURL('image/png');

	//document.getElementById("canvasimg_back").style.border = "2px solid";
	var dataURLBack = canvasback.toDataURL('image/png');

	var datan = document.getElementById("datanota").value;



	let activated = [

	];

	for (obj of selectedPlaces) {
		if (obj.dolore != "INITIAL_MTL") {
			activated.push(obj);
		}
	}


	let activatedMeshes = JSON.stringify(activated);



	$('#meshes').val(activatedMeshes);
	// $('#meshes').val("ciao");

	if ($('#save_pain_textarea').val() == '')
		$('#save_pain_textarea').val('Nessun commento.');

	$('#textarea').val($('#save_pain_textarea').val());
	$('#datan').val(datan);
	$('#dataURLBack').val(dataURLBack);
	$('#dataURLFront').val(dataURLFront);
	if (userDrawnBack == 1 || userDrawnFront == 1) {
		$('#drawn_2d').val('1');
	} else {
		$('#drawn_2d').val('0');
	}

	// console.log($('#dataURLBack').val(dataURLBack));


	// console.log($('#drawn_2d').val());
	$('#myform').submit();

	// $.ajax({
	// 	url: "/pazienti/taccuino/addReporting",
	// 	method: "POST",

	// 	headers: {
	// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	},
	// 	data: {/* _token: CSRF_TOKEN,*/ datanota: datan, front: dataURLFront, back: dataURLBack, save_pain_textarea: $('#save_pain_textarea').val() },
	// 	dataType: "json",
	// 	complete: function (data) {
	// 		$('#canvasModal').modal('hide');
	// 		// location.reload();
	// 	}
	// });
}



function getFront() {
	prepareCanvas("");
	return canvas1.toDataURL('image/png');
}
function getBack() {
	prepareCanvas("_back");
	return canvasback.toDataURL('image/png');
}

//delete data from the db ==> useless function, it does not do anything 
// $('.removePain').click(function () {
// 	var idDelete = $(this).attr('id').split('_')[1];

// 	$.post("formscripts/deleteTaccuino.php",
// 		{
// 			id: idDelete
// 		},
// 		function (data, status) {
// 			//alert(data + status);
// 			$('#canvasModal').modal('hide');
// 			location.reload();
// 		}
// 	);

// });



function checkNumberFiles() {



	let downloadButtons = document.getElementsByClassName("dropButton");
	for (button of downloadButtons) {
		let remove_pain = document.getElementById('removePain_' + button.value);


		let id_taccuino = button.value;
		let files = document.getElementsByClassName("download_" + id_taccuino);
		let filesLength = files.length;
		if (filesLength <= 0) {
			button.innerHTML = 'Scarica ' + filesLength + " documenti <span class='caret'> </span>";
			button.classList.remove('btn-success');
			button.classList.add('btn-secondary');
			$('#myDrop_' + id_taccuino).css({ 'height': 'auto' });
			remove_pain.style.right = "-1%";

		} else {
			$('#myDrop_' + id_taccuino).css({ 'height': '250px' });
			button.innerHTML = 'Scarica ' + filesLength + " documenti <span class='caret'> </span>";
			remove_pain.style.right = "-1%";
			if (filesLength < 6) {
				$('#myDrop_' + id_taccuino).css({ 'height': 'auto' });
			}

		}

	}

}




function fileDownload(id_taccuino) {

	let files = document.getElementsByClassName("download_" + id_taccuino);
	let filesLength = files.length;

	let download;
	// console.log(filesLength);
	values = "0";
	if (filesLength > 0) {
		for (let i = 0; i < filesLength; i++) {
			download = $('#download_' + id_taccuino + '_' + i);
			// console.log(download.val());
			values = values + "_" + download.val().toString();
		}

		window.open("downloadMultipleFiles/" + values);
	}

}