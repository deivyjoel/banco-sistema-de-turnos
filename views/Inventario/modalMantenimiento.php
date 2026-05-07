<div id="modalmantenimiento" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h4 class="modal-title" id="lbltitulo">Nuevo Ítem de Inventario</h4>
                <button type="button" class="btn-close" id="btnclosemodal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario Mantenimiento -->
            <form method="post" id="inventario_form">
                <div class="modal-body">
                    <input type="hidden" name="id_item" id="id_item">

                    <!-- Nombre del Ítem -->
                    <div class="mb-3">
                        <label for="nom_item" class="form-label">Nombre del Ítem: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nom_item" name="nom_item" maxlength="150" required />
                    </div>

                    <!-- Categoría -->
                    <div class="mb-3">
                        <label for="id_categoria" class="form-label">Categoría: <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_categoria" name="id_categoria" required>
                            <!-- Cargado dinámicamente -->
                        </select>
                    </div>

                    <!-- Stock Actual -->
                    <div class="mb-3">
                        <label for="stock_actual" class="form-label">Stock Actual: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock_actual" name="stock_actual" min="0" required />
                    </div>

                    <!-- Stock Mínimo -->
                    <div class="mb-3">
                        <label for="stock_minimo" class="form-label">Stock Mínimo: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" min="0" required />
                    </div>

                    <!-- Proveedor -->
                    <div class="mb-3">
                        <label for="id_proveedor" class="form-label">Proveedor:</label>
                        <select class="form-control" id="id_proveedor" name="id_proveedor">
                            <!-- Cargado dinámicamente -->
                        </select>
                    </div>

                    <!-- Ubicación -->
                    <div class="mb-3">
                        <label for="id_ubicacion" class="form-label">Ubicación:</label>
                        <select class="form-control" id="id_ubicacion" name="id_ubicacion">
                            <!-- Cargado dinámicamente -->
                        </select>
                    </div>

                    <!-- Estado (solo visible al editar) -->
                    <div id="estado_detalle_container" class="mb-3" style="display: none;">
                        <label for="est" class="form-label">Estado: <span class="text-danger">*</span></label>
                        <select class="form-control" id="est" name="est">
                            <option value="1">ACTIVO</option>
                            <option value="2">INACTIVO</option>
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
    document.getElementById('nom_item').addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\-\.&]/g, '');
    });
</script>