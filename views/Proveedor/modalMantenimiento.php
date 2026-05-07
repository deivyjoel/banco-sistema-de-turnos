<div id="modalmantenimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmantenimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h4 class="modal-title" id="lbltitulo">Crear un nuevo Proveedor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario Mantenimiento -->
            <form method="post" id="proveedor_form">
                <div class="modal-body">
                    <input type="hidden" name="id_proveedor" id="id_proveedor" />

                    <!-- Nombre del Proveedor -->
                    <div class="mb-3">
                        <label for="nom_proveedor" class="form-label">Nombre del Proveedor: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nom_proveedor" name="nom_proveedor" required />
                    </div>

                    <!-- RUC -->
                    <div class="mb-3">
                        <label for="ruc" class="form-label">RUC: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ruc" name="ruc" maxlength="11" required />
                        <small class="form-text text-muted">Máximo 11 caracteres numéricos.</small>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label for="telef_proveedor" class="form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telef_proveedor" name="telef_proveedor" maxlength="20" />
                        <small class="form-text text-muted">Máximo 20 caracteres.</small>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label for="direc_proveedor" class="form-label">Dirección:</label>
                        <textarea class="form-control" id="direc_proveedor" name="direc_proveedor" rows="3"></textarea>
                    </div>

                    <!-- Estado (solo visible al editar) -->
                    <div id="estado_detalle_container" class="mb-3" style="display: none;">
                        <label for="est" class="form-label">Estado: <span class="text-danger">*</span></label>
                        <select class="form-control" id="est" name="est">
                            <option value="1">ACTIVO</option>
                            <option value="0">INACTIVO</option>
                        </select>
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

<!-- Validaciones en tiempo real -->
<script>
    // Limitar RUC a 11 caracteres
    document.getElementById('ruc').addEventListener('input', function () {
        // Solo permitir números
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });

    // Limitar Teléfono a 20 caracteres
    document.getElementById('telef_proveedor').addEventListener('input', function () {
        if (this.value.length > 20) {
            this.value = this.value.slice(0, 20);
        }
    });

    // Validar que el nombre no contenga números
    document.getElementById('nom_proveedor').addEventListener('input', function () {
        // Permitir letras, espacios y algunos caracteres especiales comunes en nombres
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s&.,-]/g, '');
    });
</script>