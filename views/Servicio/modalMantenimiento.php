<div id="modalmantenimiento" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h4 class="modal-title" id="lbltitulo">Detalle del Servicio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--- Formulario servicio -->
            <form method="post" id="servicio_form">
                <div class="modal-body">
                    <input type="hidden" name="id_servicio" id="id_servicio">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="view_ser_nom" class="form-label fw-bold">Nombre del Servicio:</label>
                        <input type="text" class="form-control" id="view_ser_nom" name="view_ser_nom" required/>
                    </div>

                    <!-- Duración Promedio -->
                    <div class="mb-3">
                        <label for="view_ser_dur_prom" class="form-label fw-bold">Duración Promedio:</label>
                        <input type="number" class="form-control" id="view_ser_dur_prom" name="view_ser_dur_prom" min="0" placeholder="Minutos" required/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnclosemodal" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnagregar">Guardar</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>