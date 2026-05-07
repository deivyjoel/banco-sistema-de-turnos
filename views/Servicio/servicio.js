$(document).ready(function() {
    $('#servicio_data').DataTable({
        responsive: true,
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: "../../controller/servicioController.php?op=listar",
            type: "post",
            dataType: "json",
            error: function(e) {
                console.log("Error al cargar datos: ", e.responseText);
            }
        },
        "bDestroy": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});

// Ver detalle del servicio
function ver(ser_id) {
    $.post("/controllers/servicio.php?op=mostrar", { ser_id: ser_id }, function(data) {
        try {
            data = JSON.parse(data);

            $('#view_ser_nom').text(data.ser_nom);
            $('#view_ser_dur_prom').text(data.ser_dur_prom + ' min');
            $('#view_ser_est').html(data.ser_est == 1
                ? '<span class="badge" style="font-size:1em; background-color:green;">ACTIVO</span>'
                : '<span class="badge" style="font-size:1em; background-color:red;">INACTIVO</span>'
            );

            $("#modalmantenimiento").modal('show');
        } catch (e) {
            Swal.fire('Error', 'No se pudo cargar la información del servicio.', 'error');
        }
    }).fail(function() {
        Swal.fire('Error', 'Error de conexión al servidor.', 'error');
    });
}

// Cerrar modal
$(document).on("click", "#btnclosemodal", function() {
    $("#modalmantenimiento").modal('hide');
});

// Reservar turno
function reservar(ser_id) {
    Swal.fire({
        title: '¿Reservar este servicio?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, reservar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/turnoController.php?op=reservar", { ser_id: ser_id }, function(data) {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Turno reservado',
                        html: 'Tu turno es: <strong>' + data.tur_pre + '</strong>',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // 1. Recargar la tabla
                        var table = $('#servicio_data').DataTable();
                        table.ajax.reload(function(json) {
                            // 2. Redirigir una vez recargada (callback)
                            window.location.href = '../Inicio/index.php';
                        }, false); // 'false' mantiene la paginación actual
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            }, "json").fail(function() {
                Swal.fire('Error', 'Error de conexión.', 'error');
            });
        }
    });
}
