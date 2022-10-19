$(document).ready(function () {
    $('form#formCrearNotaria').submit(function (e) {
        e.preventDefault();

        var Datos = $(this).serialize();

        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/notarias/guardar-notaria',
            type: 'POST',
            data: Datos,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);

                if (data.estado == 1) {
                    //Limpiar el formulario e ir a listar
                    $("form#formCrearNotaria")[0].reset();
                    setTimeout(function () {
                        window.location.href = $('#urlBase').val() + '/gestionNotarias/notarias/listar';
                    }, 1000);
                }
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });

    });

    $('form#formCrearMemorando').submit(function (e) {
        e.preventDefault();

        var Datos = $(this).serialize();

        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/memorandos/guardar-memorando',
            type: 'POST',
            data: Datos,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);

                if (data.estado == 1) {
                    //Limpiar el formulario e ir a listar
                    $("form#formCrearMemorando")[0].reset();
                    setTimeout(function () {
                        window.location.href = $('#urlBase').val() + '/gestionNotarias/memorandos/cargar-archivos?IdMemorandos=' + data.IdMemorandos;
                    }, 500);
                }
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });

    });

    $('form#formCrearComunicacion').submit(function (e) {
        e.preventDefault();

        var Datos = $(this).serialize();

        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/comunicaciones/guardar-comunicacion',
            type: 'POST',
            data: Datos,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);

                if (data.estado == 1) {
                    //Limpiar el formulario e ir a listar
                    $("form#formCrearComunicacion")[0].reset();
                    setTimeout(function () {
                        window.location.href = $('#urlBase').val() + '/gestionNotarias/comunicaciones/cargar-archivos?IdComunicaciones=' + data.IdComunicaciones;
                    }, 500);
                }
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });

    });


    $('form#formEditarNotaria').submit(function (e) {
        e.preventDefault();

        var Datos = $(this).serialize();

        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/notarias/guardar-notaria',
            type: 'POST',
            data: Datos,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });

    });

    $('form#formEditarMemorando').submit(function (e) {
        e.preventDefault();

        var Datos = $(this).serialize();

        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/memorandos/guardar-memorando',
            type: 'POST',
            data: Datos,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });

    });

    $('form#formEditarComunicacion').submit(function (e) {
        e.preventDefault();

        var Datos = $(this).serialize();

        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/comunicaciones/guardar-comunicacion',
            type: 'POST',
            data: Datos,
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });

    });
});

function EliminarMemorando(IdMemorandos) {
    if (confirm("Deseas eliminar el registro?") == true) {
        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/memorandos/eliminar-memorando',
            type: 'POST',
            data: {'IdMemorandos': IdMemorandos},
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);

                if (data.estado == 1) {
                    window.location.reload();
                }
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });
    }
}

function EliminarComunicacion(IdComunicaciones) {
    if (confirm("Deseas eliminar el registro?") == true) {
        $.ajax({
            url: $('#urlBase').val() + '/gestionNotarias/comunicaciones/eliminar-comunicado',
            type: 'POST',
            data: {'IdComunicaciones': IdComunicaciones},
            dataType: 'json',
            beforeSend: function () {
                $.blockUI({
                    message: '<img src="' + $('#urlBase').val() + '/images/loading.gif" />',
                    css: {
                        'border': 'none',
                        'padding': '15px',
                        'background': 'none',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        'color': '#fff'
                    }
                });
            },
            success: function (data) {
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }

                alert(data.mensaje);

                if (data.estado == 1) {
                    window.location.reload();
                }
            },
            error: function () {
                console.log("No se ha podido obtener la informacion");
                $.unblockUI();
            }
        }).done(function () {
            $.unblockUI();
        });
    }
}