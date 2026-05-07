function init() {
    $("#movimiento_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(function() {
    $('#movimiento_data').DataTable({
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
            url: "../../controllers/movimientoControlador.php?op=listar",
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
        "order": [[0, "desc"]], // Ordenar por fecha descendente
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
        "columnDefs": [
            {
                "targets": [6, 7], // Columnas de botones (editar/eliminar)
                "orderable": false,
                "searchable": false
            }
        ]
    });

    // Cargar ítems al iniciar
    cargarItems();
});

// Cargar ítems en el <select>
function cargarItems() {
    $.post("../../controllers/movimientoControlador.php?op=listar_items", function(data) {
        try {
            data = JSON.parse(data);
            var select = $('#id_item');
            select.empty();
            select.append('<option value="">Seleccione un ítem</option>');
            $.each(data, function(index, item) {
                select.append('<option value="' + item.id_item + '">' + item.nom_item + '</option>');
            });
        } catch (e) {
            console.log("Error al parsear items: ", e);
            Swal.fire('Error', 'Error al cargar los ítems', 'error');
        }
    }).fail(function() {
        console.log("Error al cargar ítems.");
        Swal.fire('Error', 'Error de conexión al cargar ítems', 'error');
    });
}

// Guardar o editar movimiento
function guardaryeditar(e) {
    e.preventDefault();

    // Validaciones adicionales en cliente
    var id_item = $('#id_item').val();
    var tipo = $('#tipo').val();
    var cantidad = $('#cantidad').val();
    var motivo = $('#motivo').val();

    if (!id_item) {
        Swal.fire('Error', 'Debe seleccionar un ítem', 'error');
        return false;
    }
    if (!tipo) {
        Swal.fire('Error', 'Debe seleccionar un tipo de movimiento', 'error');
        return false;
    }
    if (cantidad <= 0) {
        Swal.fire('Error', 'La cantidad debe ser mayor a cero', 'error');
        return false;
    }
    if (!motivo.trim()) {
        Swal.fire('Error', 'El motivo es obligatorio', 'error');
        return false;
    }

    var formData = new FormData($("#movimiento_form")[0]);

    $.ajax({
        url: "../../controllers/movimientoControlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            try {
                response = JSON.parse(response);

                if (response.success) {
                    Swal.fire('Éxito', response.message, 'success');
                    $("#movimiento_form")[0].reset();
                    $("#modalmantenimiento").modal('hide');
                    $("#movimiento_data").DataTable().ajax.reload();
                    $("#btnagregar").show();
                    $('#estado_detalle_container').hide();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
                console.log("Error al parsear JSON: ", response);
            }
        },
        error: function() {
            Swal.fire('Error', 'Hubo un problema de conexión con el servidor.', 'error');
        }
    });
}

// Editar movimiento
function editar(id_movimiento) {
    $("#lbltitulo").html('Editar Movimiento');

    $.post("../../controllers/movimientoControlador.php?op=mostrar", { id_movimiento: id_movimiento }, function(data) {
        try {
            data = JSON.parse(data);

            $('#id_movimiento').val(data.id_movimiento);
            $('#id_item').val(data.id_item);
            $('#tipo').val(data.tipo);
            $('#cantidad').val(data.cantidad);
            $('#motivo').val(data.motivo);
            $('#id_usuario').val(data.id_usuario);
            $('#est').val(data.est);

            $("#btnagregar").show();
            $('#estado_detalle_container').show();
        } catch (e) {
            Swal.fire('Error', 'No se pudo cargar la información del movimiento.', 'error');
            console.log("Error al cargar movimiento: ", e);
        }
    });

    $("#modalmantenimiento").modal('show');
}

// Eliminar movimiento (desactivar)
function eliminar(id_movimiento) {
    Swal.fire({
        title: "¿Eliminar movimiento?",
        text: "Esta acción desactivará el movimiento del historial.",
        icon: "warning",
        confirmButtonText: "Sí, eliminar",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controllers/movimientoControlador.php?op=eliminar", { id_movimiento: id_movimiento }, function(data) {
                try {
                    data = JSON.parse(data);
                    if (data.success) {
                        $('#movimiento_data').DataTable().ajax.reload();
                        Swal.fire('Eliminado', data.message, 'success');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                } catch (e) {
                    Swal.fire('Error', 'Error al procesar la respuesta.', 'error');
                }
            }).fail(function() {
                Swal.fire('Error', 'Error de conexión al servidor.', 'error');
            });
        }
    });
}

// Botón "Nuevo movimiento"
$(document).on("click", "#btnnuevo", function() {
    $("#lbltitulo").html('Nuevo Movimiento');
    $('#movimiento_form')[0].reset();
    $('#id_movimiento').val('');
    $('#estado_detalle_container').hide();
    
    // Recargar items para asegurar que estén actualizados
    cargarItems();
    
    $("#modalmantenimiento").modal('show');
    $("#btnagregar").show();
});

// Cerrar modal
$(document).on("click", "#btnclosemodal", function() {
    $("#modalmantenimiento").modal('hide');
    $('#estado_detalle_container').hide();
});

// Validar que la cantidad sea positiva
$(document).on("input", "#cantidad", function() {
    if ($(this).val() <= 0) {
        $(this).addClass('is-invalid');
    } else {
        $(this).removeClass('is-invalid');
    }
});

// Validar que el motivo no esté vacío
$(document).on("input", "#motivo", function() {
    if ($(this).val().trim() === '') {
        $(this).addClass('is-invalid');
    } else {
        $(this).removeClass('is-invalid');
    }
});

// Inicializar
init();