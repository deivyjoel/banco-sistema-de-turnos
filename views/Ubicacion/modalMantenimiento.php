<!-- modalMantenimiento.php -->
<div class="modal fade" id="modalmantenimiento" tabindex="-1" aria-labelledby="lbltitulo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="ubicacion_form" id="ubicacion_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="lbltitulo">Nueva Ubicación</h5>
                    <button type="button" class="btn-close" id="btnclosemodal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_ubicacion" id="id_ubicacion">
                    <div class="mb-3">
                        <label>Nombre de la ubicación *</label>
                        <input type="text" name="nom_ubicacion" id="nom_ubicacion" class="form-control" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea name="desc_ubicacion" id="desc_ubicacion" class="form-control" rows="3" maxlength="200"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnclosemodal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnagregar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>