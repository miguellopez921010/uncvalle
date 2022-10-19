$(document).ready(function(){

    $('.slider').bxSlider({

      auto: true,

      autoControls: false,

      stopAutoOnClick: true,

      pager: true,

    });



    $('form#FormContactenos').submit(function(e){

        e.preventDefault();



        var Datos = $(this).serializeArray();

        //xxxDatos.push({name: 'Mensaje', value: $('textArea#Mensaje')});



        $.ajax({ 

            url: $('#urlBase').val() + '/site/guardar-contactenos',

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



                if(data.estado == 1){

                    $('#FormContactenos')[0].reset();

                }

                alert(data.mensaje);

            },

            error: function() {

                console.log("No se ha podido obtener la informacion");

                $.unblockUI();

            }

        }).done(function() {

            $.unblockUI();

        });



    });

});



function CargarModal(NombreModal, TipoCargue, Url, Parametros, TituloModal = null, MostrarBotonesFooter = true, MostrarOpcionCerrarSuperior = true) {

    $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-header>h4.modal-title').html('');

    if (TituloModal != null) {

        $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-header>h4.modal-title').html(TituloModal);

    }



    $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-body').html('');

    if (TipoCargue == 1) {

        $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-body').load($('#urlBase').val() + Url, Parametros);

    } else if (TipoCargue == 2) {

        $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-body').html(Url);

    }

    

    if(!MostrarBotonesFooter){

        $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-footer').html('');

    }    

    if(!MostrarOpcionCerrarSuperior){

        $("#" + NombreModal + '>.modal-dialog>.modal-content>.modal-header>button.close').html('');

    }



    $("#" + NombreModal).modal({backdrop: 'static', keyboard: false, show: true});

}



function VerImagenesProducto(IdProducto){

    CargarModal('modalNormal', 1, '/productos/productos/ver-imagenes-producto', {'IdProducto': IdProducto});

}



function CargarDiv(IdDiv, TipoCargue, Url, Parametros){ //Si el TipoCargue es 1, se carga la informacion de la Url ingresada, si es 2, se carga lo que venga en Url como html

    $("#" + IdDiv).html('');

    if (TipoCargue == 1) {

        $("#" + IdDiv).load($('#urlBase').val() + Url, Parametros);

    } else if (TipoCargue == 2) {

        $("#" + IdDiv).html(Url);

    }

}



function ListarCiudadesPorDepartamento(){

    var IdDepartamento = $('select#IdDepartamento').val();

    

    $.ajax({ 

        url: $('#urlBase').val() + '/site/cargar-ciudades-por-departamento',

        type: 'POST',

        data: {IdDepartamento: IdDepartamento},

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



            var opciones_select = '<option value="">Seleccionar ciudad</option>';

            if(data.Ciudades.length > 0){

                for(var i=0;i<data.Ciudades.length;i++){

                    opciones_select+='<option value="'+data.Ciudades[i]['IdCiudad']+'">'+data.Ciudades[i]['NombreCiudad']+'</option>';

                }

            }

            

            $('select#IdCiudad').empty();

            $('select#IdCiudad').html(opciones_select);

        },

        error: function() {

            console.log("No se ha podido obtener la informacion");

            $.unblockUI();

        }

    }).done(function() {

        $.unblockUI();

    });

}



function AgregarFilaTabla(NombreTabla, FilaACopiar){

    var CodigoHtmlFilaCopiar = $('tr#'+FilaACopiar).html();

    $('table#'+NombreTabla+'>tbody').append('<tr>'+CodigoHtmlFilaCopiar+'</tr>');

}



function CargarDocumentoEnModal(IdDocumento){

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

    CargarModal('modalLarge', 1, '/site/ver-documento', {'IdDocumento': IdDocumento});

    $.unblockUI();

}

function CargarImagenEnModal(IdImagen){
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

    CargarModal('modalLarge', 1, '/site/ver-imagen', {'IdImagen': IdImagen});

    $.unblockUI();
}



function PestanaActual(IdPestana, ClasePEstana){

    $('.'+ClasePEstana).each(function(){

        if($(this).hasClass('active')){

            $(this).removeClass('active');

        }

    });

    

    $('#'+IdPestana).addClass('active');

}



function AbrirUrlExterna(Url){

    var win = window.open(Url, '_blank');

    win.focus();

}



function VerMensajeContactenos(IdMensaje){
    CargarModal('modalNormal', 1, '/administrador/mensajes/ver-mensaje-contactenos', {'IdMensaje': IdMensaje});
}

function CambiarEstadoImagen(IdImagen, ActivarDesactivar){
    //ActivarDesactivar 1. ACTIVAR 0. DESACTIVAR

    $.ajax({ 
        url: $('#urlBase').val() + '/maestras/imagenes/cambiar-estado-imagen',
        type: 'POST',
        data: {'IdImagen': IdImagen, 'NuevoEstado': ActivarDesactivar},
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

            alert(data.Mensaje);
            window.location.reload();
        },
        error: function() {
            console.log("No se ha podido obtener la informacion");
            $.unblockUI();
        }
    }).done(function() {
        $.unblockUI();
    });
}

function EliminarImagen(IdImagen){
    //Se elimina por completo la imagen de la base de datos
    $.ajax({ 
        url: $('#urlBase').val() + '/maestras/imagenes/eliminar-imagen',
        type: 'POST',
        data: {'IdImagen': IdImagen},
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

            alert(data.Mensaje);
            window.location.reload();
        },
        error: function() {
            console.log("No se ha podido obtener la informacion");
            $.unblockUI();
        }
    }).done(function() {
        $.unblockUI();
    });
}