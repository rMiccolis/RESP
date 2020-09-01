$(document).ready(function(){
    $('#modpatdonorg').validate({
        rules:  
        {
        'patdonorg':{  
            required: true
            },  
		},
        errorClass: 'help-block col-lg-6',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
		submitHandler: function(event) { 
                $.post("formscripts/modpatdonorg.php",
			{
				patgrsang:	$("#patdonorg").val(),
			},
  			function(status){
				alert("Cambio gruppo sanguigno effettuato con successo " + status );
				$('#modpatdonorgmodal').modal('hide');
				location.reload();
  			});
		}
    });
});