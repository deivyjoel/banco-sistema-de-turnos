function init() {
    $("#inventario_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(function() {
    $('#inventario_data').DataTable({
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
            url: "../../controllers/inventarioControlador.php?op=listar",
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

    // Cargar categorías, proveedores y ubicaciones al iniciar
    cargarCategorias();
    cargarProveedores();
    cargarUbicaciones();
});

// Cargar categorías en el <select>
function cargarCategorias() {
    $.post("../../controllers/inventarioControlador.php?op=listar_categorias", function(data) {
        data = JSON.parse(data);
        var select = $('#id_categoria');
        select.empty();
        select.append('<option value="">Seleccione categoría</option>');
        $.each(data, function(index, item) {
            select.append('<option value="' + item.id_categoria + '">' + item.nom_categoria + '</option>');
        });
    }).fail(function() {
        console.log("Error al cargar categorías.");
    });
}

// Cargar proveedores en el <select>
function cargarProveedores() {
    $.post("../../controllers/inventarioControlador.php?op=listar_proveedores", function(data) {
        data = JSON.parse(data);
        var select = $('#id_proveedor');
        select.empty();
        select.append('<option value="">Seleccione proveedor</option>');
        $.each(data, function(index, item) {
            select.append('<option value="' + item.id_proveedor + '">' + item.nom_proveedor + '</option>');
        });
    }).fail(function() {
        console.log("Error al cargar proveedores.");
    });
}

// Cargar ubicaciones en el <select>
function cargarUbicaciones() {
    $.post("../../controllers/inventarioControlador.php?op=listar_ubicaciones", function(data) {
        data = JSON.parse(data);
        var select = $('#id_ubicacion');
        select.empty();
        select.append('<option value="">Seleccione ubicación</option>');
        $.each(data, function(index, item) {
            select.append('<option value="' + item.id_ubicacion + '">' + item.nom_ubicacion + '</option>');
        });
    }).fail(function() {
        console.log("Error al cargar ubicaciones.");
    });
}

// Guardar o editar ítem
function guardaryeditar(e) {
    e.preventDefault();

    var formData = new FormData($("#inventario_form")[0]);

    $.ajax({
        url: "../../controllers/inventarioControlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            try {
                response = JSON.parse(response);

                if (response.success) {
                    Swal.fire('Éxito', response.message, 'success');
                    $("#inventario_form")[0].reset();
                    $("#modalmantenimiento").modal('hide');
                    $("#inventario_data").DataTable().ajax.reload();
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

// Editar ítem
function editar(id_item) {
    $("#lbltitulo").html('Editar Ítem de Inventario');

    $.post("../../controllers/inventarioControlador.php?op=mostrar", { id_item: id_item }, function(data) {
        try {
            data = JSON.parse(data);

            $('#id_item').val(data.id_item);
            $('#nom_item').val(data.nom_item);
            $('#id_categoria').val(data.id_categoria);
            $('#stock_actual').val(data.stock_actual);
            $('#stock_minimo').val(data.stock_minimo);
            $('#id_proveedor').val(data.id_proveedor || '');
            $('#id_ubicacion').val(data.id_ubicacion || ''); // Aquí va el ID, no texto
            $('#est').val(data.est);

            $("#btnagregar").show();
            $('#estado_detalle_container').show();
        } catch (e) {
            Swal.fire('Error', 'No se pudo cargar la información del ítem.', 'error');
        }
    });

    $("#modalmantenimiento").modal('show');
}

// Eliminar ítem (desactivar)
function eliminar(id_item) {
    Swal.fire({
        title: "¿Eliminar ítem?",
        text: "Esta acción desactivará el ítem del inventario.",
        icon: "warning",
        confirmButtonText: "Sí, eliminar",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controllers/inventarioControlador.php?op=eliminar", { id_item: id_item }, function(data) {
                try {
                    data = JSON.parse(data);
                    if (data.success) {
                        $('#inventario_data').DataTable().ajax.reload();
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

// Botón "Nuevo ítem"
$(document).on("click", "#btnnuevo", function() {
    $("#lbltitulo").html('Nuevo Ítem de Inventario');
    $('#inventario_form')[0].reset();
    $('#id_item').val('');
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