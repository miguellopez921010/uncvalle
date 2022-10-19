$(document).ready(function(){
	$('form#formCrearEquipo').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/equipos/guardar-equipo',
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

function CambiarEstadoEquipo(IdEquipo, NuevoEstado){
	$.ajax({ 
	    url: $('#urlBase').val() + '/maestras/equipos/cambiar-estado-equipo',
	    type: 'POST',
	    data: {'IdEquipo': IdEquipo, 'NuevoEstado': NuevoEstado},
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
	        	$('td#tdBtnActivarEquipo_'+IdEquipo).html('');

	        	var html = '';
	        	if(data.NuevoEstado == 0){
	        		html+='<a class="btn btn-link" onclick="CambiarEstadoEquipo('+IdEquipo+', 1)">Activar</a> / <b>Desactivar</b>';	        			        		
	        	}else{
	        		html+='<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoEquipo('+IdEquipo+', 0)">Desactivar</a>';
	        	}
	        	$('td#tdBtnActivarEquipo_'+IdEquipo).html(html);
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
