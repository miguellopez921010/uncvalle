$(document).ready(function(){	
	$('form#formCargarEmpleados').submit(function(e){
		e.preventDefault();

		var f = $(this);
        var formData = new FormData(document.getElementById("formCargarEmpleados"));
        //formData.append("Proyectos", $('#Proyectos').val());
        formData.append(f.attr("ArchivoEmpleados"), $('#ArchivoEmpleados')[0].files[0]);

        $.ajax({
            url: $('#urlBase').val() + '/maestras/empleados/cargar-empleados-masivo',
            type: "post",
            dataType: "json",
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
        	data: formData,
            cache: false,
            contentType: false,
     		processData: false,
            success: function(data){
            	alert(data.mensaje);
            },
        }).done(function(res){
        	$.unblockUI();            
        });

	});

	$('form#formCrearEmpleado').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/empleados/guardar-empleado',
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

	$('form#formRegistrarme').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/empleados/guardar-empleado',
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

	$('#formMiCuenta').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/cuenta/cuenta/guardar-mi-cuenta',
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

	$('#formCambioContrasenaUsuario').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/maestras/empleados/cambiar-contrasena-usuario',
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

	$('#formCambioContrasenaMiCuenta').submit(function(e){
		e.preventDefault();

		var Datos = $(this).serialize();

		$.ajax({ 
		    url: $('#urlBase').val() + '/cuenta/cuenta/cambiar-contrasena-mi-cuenta',
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

function CambiarEstadoUsuario(IdUsuario, NuevoEstado){
	$.ajax({ 
	    url: $('#urlBase').val() + '/maestras/empleados/cambiar-estado-usuario',
	    type: 'POST',
	    data: {'IdUsuario': IdUsuario, 'NuevoEstado': NuevoEstado},
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
	        	$('td#tdBtnActivarUsuario_'+IdUsuario).html('');

	        	var html = '';
	        	if(data.NuevoEstado == 0){
	        		html+='<a class="btn btn-link" onclick="CambiarEstadoUsuario('+IdUsuario+', 1)">Activar</a> / <b>Desactivar</b>';	        			        		
	        	}else{
	        		html+='<b>Activar</b> / <a class="btn btn-link" onclick="CambiarEstadoUsuario('+IdUsuario+', 0)">Desactivar</a>';
	        	}
	        	$('td#tdBtnActivarUsuario_'+IdUsuario).html(html);
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