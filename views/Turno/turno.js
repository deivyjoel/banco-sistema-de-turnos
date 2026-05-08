function init() {
    $("#turno_form").on("submit", function(e) {
        console.log("alo we")
        e.preventDefault();
        let nuevoEstado = $(document.activeElement).data("estado");
        confirmarEstado(nuevoEstado);

    });

    
}

$(document).ready(function() {
    $('#turno_data').DataTable({
        responsive: true,
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: "../../controller/turnoController.php?op=listar_usuario",
            type: "post",
            dataType: "json",
            error: function(e) {
                console.log("Error al cargar datos: ", e.responseText);
            }
        },
        "bDestroy": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[2, "desc"]],
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

function cambiarEstado(tur_id, estadoActual, codigo) {
    $.post("../../controller/turnoController.php?op=mostrar", { tur_id: tur_id }, function(data) {
        try {

            data = JSON.parse(data);
            console.log(data)
            $("#modal_tur_id").val(data.tur_id);
            $("#modal_ser_id").val(data.tur_ser_id);
            $("#modal_tur_codigo").text(data.tur_pre + data.tur_n_tur);
            $("#modal_tur_estado_actual").text(data.tur_est);

            // Armar botones según estado actual
            let botones = '';
            if (data.tur_est == 1) {
                botones += '<button type="submit" class="btn btn-primary" data-estado="2">Pasar a ATENDIENDO</button>';
                botones += '<button type="submit" class="btn btn-danger ms-2" data-estado="3">CANCELAR turno</button>';
            } else if (data.tur_est == 2) {
                botones += '<button class="btn btn-success" data-estado="4">Marcar como ATENDIDO</button>';
            }

            $('#modal_botones_estado').html(botones);
            $("#modalEstado").modal('show');

        } catch (e) {
            console.log("no llegue aki")
            Swal.fire('Error', 'No se pudo cargar la información del turno.', 'error');
        }
    });

}

function confirmarEstado(nuevoEstado) {
    console.log(nuevoEstado)
    let tur_id = $('#modal_tur_id').val();
    let ser_id = $('#modal_ser_id').val();

    $.post("../../controller/turnoController.php?op=cambiar_estado", {
        tur_id: tur_id,
        ser_id: ser_id,
        estado: nuevoEstado
    }, function(res) {
        if (res.success) {
            $('#modalEstado').modal('hide');
            $("#turno_data").DataTable().ajax.reload();
            console.log("siiii aki si llegue")
            
        } else {
            alert("Error: " + res.mensaje);
        }
    }, "json");
}


init();