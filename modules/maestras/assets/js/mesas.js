$(document).ready(function(){
	$('form#formCrearMesa').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/mesas/guardar-mesa',
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

	$('form#FormAsignarEquipoaMesa').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/mesas/guardar-asignacion-equipo-mesa',
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

});

function CambiarEstadoMesa(IdMesa, NuevoEstado){
	$.ajax({ 
	    url: $('#urlBase').val() + '/maestras/mesas/cambiar-estado-mesa',
	    type: 'POST',
	    data: {'IdMesa': IdMesa, 'NuevoEstado': NuevoEstado},
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

	        if(data.estado == 1){
	        	$('td#tdBtnActivarMesa_'+IdMesa).html('');

	        	var html = '';
	        	if(data.NuevoEstado == 0){
	        		html+='<a class="btn btn-link" onclick="CambiarEstadoMesa('+IdMesa+', 1)">Activar</a> / <b>Desactivar</b>';	        			        		
	        	}else{
	        		html+='<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoMesa('+IdMesa+', 0)">Desactivar</a>';
	        	}
	        	$('td#tdBtnActivarMesa_'+IdMesa).html(html);
	        }
	    },
	    error: function() {
	      	console.log("No se ha podido obtener la información");
	      	$.unblockUI();
	    }
	}).done(function() {
	    $.unblockUI();
	});
}
