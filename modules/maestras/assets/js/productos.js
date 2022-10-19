$(document).ready(function(){
	$('form#formCrearProducto select#IdCategorias').change(function(){
		var IdCategorias = $(this).val();

		$.ajax({
            url: $('#urlBase').val() + '/maestras/productos/obtener-consecutivo-categoria-producto',
            type: "post",
            dataType: "json",            
        	data: {'IdCategorias': IdCategorias},
        	beforeSend: function() {
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

                $('form#formCrearProducto input#Consecutivo').val('');
            },	
            success: function(data) {
		    	if (typeof data == "string"){
		            data = JSON.parse(data);
		        }

		        $('form#formCrearProducto input#Consecutivo').val(data.SiguienteConsecutivo);
		    },
		    error: function() {
		      	console.log("No se ha podido obtener la información");
		      	$.unblockUI();
		    }
        }).done(function(res){
        	$.unblockUI();            
        });
	});

	$('form#formCrearProducto').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serializeArray();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/productos/guardar-producto',
		    type: 'POST',
		    data: Datos,
		    dataType: 'json',
		    beforeSend: function() {
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
		    success: function(data) {
		    	if (typeof data == "string"){
		            data = JSON.parse(data);
		        }

		        alert(data.mensaje);
		    },
		    error: function() {
		      	console.log("No se ha podido obtener la información");
		      	$.unblockUI();
		    }
		}).done(function() {
		    $.unblockUI();
		});
	});

	$('form#FormAdministrarImagenesProducto #ImagenPrincipal').change(function(){
		var fd = new FormData();
        var files = $('#ImagenPrincipal')[0].files[0];
        fd.append('Imagen',files);
        fd.append('Tipo',1);
        fd.append('IdProductos', $('#IdProductos').val());

        $.ajax({
            url: $('#urlBase').val() + '/maestras/productos/actualizar-imagen-producto',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function() {
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
            success: function(response){
                alert(response.mensaje);
            },
            error: function() {
		      	console.log("No se ha podido obtener la información");
		      	$.unblockUI();
		    }
        }).done(function() {
		    $.unblockUI();
		});
	});

	
})