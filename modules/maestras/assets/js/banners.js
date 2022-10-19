$(document).ready(function(){
	$('form#formCrearBanner').submit(function(e){
		e.preventDefault();

    	var formData = new FormData();
    	var formParams = $(this).serializeArray();

    	/*$.each(form.find('input[type="file"]'), function(i, tag) {
	      	$.each($(tag)[0].files, function(i, file) {
	        	formData.append(tag.name, file);
	      	});
	    });*/

	    $.each(formParams, function(i, val) {
	      	formData.append(val.name, val.value);
	    });

	    formData.append('Imagen', $('input[type=file]')[0].files[0]); 

    	$.ajax({
	        url: $('#urlBase').val() + '/maestras/banners/guardar-banner',
	        data: formData,
	        processData: false,
	        type: 'POST',
	        contentType: false,
	        //contentType: 'multipart/form-data',
	        beforeSend: function () {
	        	$.blockUI({
                    message: '<img src="'+$('#urlBase').val()+'/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background' : 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
	        },
	        //mimeType: 'multipart/form-data',
	        success: function (data) {
	        	if (typeof data == "string"){
		            data = JSON.parse(data);
		        }
	            alert(data.Mensaje);
	        },
	        error: function() {
		      	console.log("No se ha podido obtener la información");
		      	$.unblockUI();
		    }
	    }).done(function() {
		    $.unblockUI();
		});
	});
});