function init() {
    $("#ubicacion_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(function() {
    $('#ubicacion_data').DataTable({
        responsive: true,
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'pdfHtml5',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5'
        ],
        "ajax": {
            url: "../../controllers/ubicacionControlador.php?op=listar",
            type: "post",
            dataType: "json",
            error: function(e) {
                console.log("Error al cargar datos: ", e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
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
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
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
        },
    });
});

// Guardar o editar ubicación
function guardaryeditar(e) {
    e.preventDefault();

    var formData = new FormData($("#ubicacion_form")[0]);

    $.ajax({
        url: "../../controllers/ubicacionControlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            try {
                // Intentar parsear solo si no es JSON automático
                let data = typeof response === 'string' ? JSON.parse(response) : response;

                if (data.success) {
                    Swal.fire('Éxito', data.message, 'success');
                    $("#ubicacion_form")[0].reset();
                    $("#modalmantenimiento").modal('hide');
                    $("#ubicacion_data").DataTable().ajax.reload();
                    $("#btnagregar").show();
                    $('#estado_detalle_container').hide();
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
                console.log("Error al parsear JSON: ", response);
            }
        },
        error: function(xhr, status, error) {
            Swal.fire('Error', 'Hubo un problema de conexión con el servidor.', 'error');
            console.log("Error AJAX: ", error, xhr.responseText);
        }
    });
}

// Editar ubicación
function editar(id_ubicacion) {
    $("#lbltitulo").html('Editar Ubicación');

    $.post("../../controllers/ubicacionControlador.php?op=mostrar", { id_ubicacion: id_ubicacion }, function(data) {
        try {
            let response = typeof data === 'string' ? JSON.parse(data) : data;

            $('#id_ubicacion').val(response.id_ubicacion);
            $('#nom_ubicacion').val(response.nom_ubicacion);
            $('#desc_ubicacion').val(response.desc_ubicacion || '');

            $("#btnagregar").show();
            $('#estado_detalle_container').show();
        } catch (e) {
            Swal.fire('Error', 'No se pudo cargar la información de la ubicación.', 'error');
            console.log("Error al parsear datos: ", data);
        }
    });

    $("#modalmantenimiento").modal('show');
}

// Eliminar ubicación (desactivar lógicamente)
function eliminar(id_ubicacion) {
    Swal.fire({
        title: "¿Desactivar Ubicación?",
        text: "Esta acción desactivará la ubicación. Podrás reactivarla más adelante si es necesario.",
        icon: "warning",
        confirmButtonText: "Sí, desactivar",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controllers/ubicacionControlador.php?op=eliminar", { id_ubicacion: id_ubicacion }, function(data) {
                try {
                    let response = typeof data === 'string' ? JSON.parse(data) : data;
                    if (response.success) {
                        $('#ubicacion_data').DataTable().ajax.reload();
                        Swal.fire('Desactivado', response.message, 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                } catch (e) {
                    Swal.fire('Error', 'Error al procesar la respuesta.', 'error');
                }
            }).fail(function() {
                Swal.fire('Error', 'No se pudo completar la solicitud.', 'error');
            });
        }
    });
}

// Botón "Nueva Ubicación"
$(document).on("click", "#btnnuevo", function() {
    $("#lbltitulo").html('Nueva Ubicación');
    $('#ubicacion_form')[0].reset();
    $('#id_ubicacion').val('');
    $('#estado_detalle_container').hide();
    $("#modalmantenimiento").modal('show');
    $("#btnagregar").show();
});

// Cerrar modal
$(document).on("click", "#btnclosemodal", function() {
    $("#modalmantenimiento").modal('hide');
    $('#estado_detalle_container').hide();
});

// Inicializar
init();