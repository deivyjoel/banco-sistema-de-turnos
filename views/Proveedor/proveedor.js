function init() {
    $("#proveedor_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}

$(document).ready(function() {
    $('#proveedor_data').DataTable({
        responsive: true,
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'pdfHtml5',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax": {
            url: "../../controllers/proveedorControlador.php?op=listar",
            type: "post",
            dataType: "json",
            error: function(e) {
                console.log(e);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10, //Por cada 10 registros hace una paginación
        "order": [[0, "asc"]], //Ordenar (columna,orden)
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

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#proveedor_form")[0]);
    
    $.ajax({
        url: "../../controllers/proveedorControlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            response = JSON.parse(response);
            if (response.success) {
                $("#proveedor_form")[0].reset();
                $("#modalmantenimiento").modal('hide');
                $("#proveedor_data").DataTable().ajax.reload();
                $("#btnagregar").show();
                swal.fire('Éxito', response.message, 'success');
                $('#estado_detalle_container').hide();
            } else {
                swal.fire('Error', response.message, 'error');
            }
        },
        error: function() {
            swal.fire('Error', 'Hubo un problema de conexión', 'error');
        }
    });
}

function editar(id_proveedor) {
    $("#lbltitulo").html('Editar Proveedor');

    $.post("../../controllers/proveedorControlador.php?op=mostrar", { id_proveedor: id_proveedor }, function(data) {
        data = JSON.parse(data);
        $('#id_proveedor').val(data.id_proveedor);
        $('#nom_proveedor').val(data.nom_proveedor);
        $('#ruc').val(data.ruc);
        $('#telef_proveedor').val(data.telef_proveedor);
        $('#direc_proveedor').val(data.direc_proveedor);
        $('#est').val(data.est);
        
        $("#btnagregar").show();
        $('#estado_detalle_container').show();
    });

    $("#modalmantenimiento").modal('show');
}

function eliminar(id_proveedor) {
    Swal.fire({
        title: "Eliminar!",
        text: "¿Desea eliminar el proveedor?",
        icon: "warning",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controllers/proveedorControlador.php?op=eliminar", { id_proveedor: id_proveedor }, function(data) {
                data = JSON.parse(data);
                if (data.success) {
                    $('#proveedor_data').DataTable().ajax.reload();
                    Swal.fire({
                        title: "Correcto!",
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    title: "Error!",
                    text: "Error al procesar la solicitud",
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
}

$(document).on("click", "#btnnuevo", function() {
    $("#lbltitulo").html('Nuevo Proveedor');
    $('#proveedor_form')[0].reset();
    $('#id_proveedor').val('');
    $("#modalmantenimiento").modal('show');
    $("#btnagregar").show();
    $('#estado_detalle_container').hide();
});

$(document).on("click", "#btnclosemodal", function() {
    $("#modalmantenimiento").modal('hide');
    $('#estado_detalle_container').hide();
});

init();