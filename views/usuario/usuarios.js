/*Mantenimiento usuario por Ajax (Tecnología de peticiones asíncronas)*/

function init() {
    $("#usuario_form").on("submit", function (e) {
        guardaryeditar(e);
    });
}

$(document).ready(function () {
    cargarRol();
    $('#usuario_data').DataTable({
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
            url: "../../controllers/UsuarioControlador.php?op=listar",
            type: "post",
            dataType: "json",
            error: function (e) {
                console.log("Error en AJAX listar: ", e);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[ 2, "asc" ]], // Ordenar por nombre (usu_nom)
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });
});

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#usuario_form")[0]);

    $.ajax({
        url: "../../controllers/UsuarioControlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            $("#usuario_form")[0].reset();
            $("#modalmantenimiento").modal('hide');
            $("#usuario_data").DataTable().ajax.reload();
            $("#btnagregar").show();
            Swal.fire({
                title: 'Registro',
                text: 'Se registró correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            $('#estado_detalle_container').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error en guardaryeditar: ", textStatus, errorThrown);
        }
    });
}

function editar(usu_id) {
    $("#lbltitulo").html('Editar registro de usuario');

    $.post("../../controllers/UsuarioControlador.php?op=mostrar", { usu_id: usu_id }, function (data) {
        data = JSON.parse(data);
        $('#usu_id').val(data.usu_id);
        $('#rol_id').val(data.rol_id);
        $('#dni').val(data.dni);
        $('#usu_nom').val(data.usu_nom);
        $('#usu_ape').val(data.usu_ape);
        $('#usu_direc').val(data.usu_direc);
        $('#usu_correo').val(data.usu_correo);
        $('#usu_usuario').val(data.usu_usuario);
        $('#usu_clave').val(data.usu_clave);
        $('#usu_cel').val(data.usu_cel);
        $('#est').val(data.est);

        $("#btnagregar").show();
        $('#estado_detalle_container').show();
    });

    $("#modalmantenimiento").modal('show');
}

function eliminar(usu_id) {
    Swal.fire({
        title: "Eliminar",
        text: "¿Desea eliminar el registro?",
        icon: "warning",
        confirmButtonText: "Sí, eliminar",
        showCancelButton: true,
        cancelButtonText: "No, cancelar",
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controllers/UsuarioControlador.php?op=eliminar", { usu_id: usu_id }, function (data) {
                $('#usuario_data').DataTable().ajax.reload();
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "El registro fue eliminado correctamente.",
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
}

function cargarRol() {
    $.ajax({
        url: "../../controllers/UsuarioControlador.php?op=listarSpinnerRol",
        type: "GET",
        dataType: "json",
        success: function (datos) {
            var options = '<option value="">Seleccione un Rol</option>';
            $.each(datos, function (index, rol) {
                options += '<option value="' + rol.rol_id + '">' + rol.rol_nom + '</option>';
            });
            $('#rol_id').html(options);
        },
        error: function (e) {
            console.log("Error al cargar roles: ", e);
        }
    });
}

$(document).on("click", "#btnnuevo", function () {
    $("#lbltitulo").html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    $('#usu_id').val('');
    $("#modalmantenimiento").modal('show');
    $("#btnagregar").show();
    $('#estado_detalle_container').hide();
});

$(document).on("click", "#btnclosemodal", function () {
    $("#modalmantenimiento").modal('hide');
    $('#estado_detalle_container').hide();
});

init();