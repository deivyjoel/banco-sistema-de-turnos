<div id="modalmantenimiento" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h4 class="modal-title" id="lbltitulo">Nuevo Movimiento de Inventario</h4>
                <button type="button" class="btn-close" id="btnclosemodal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario Mantenimiento -->
            <form method="post" id="movimiento_form">
                <div class="modal-body">
                    <input type="hidden" name="id_movimiento" id="id_movimiento">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['usu_id'] ?? ''; ?>">

                    <div class="row">
                        <!-- Ítem -->
                        <div class="col-md-6 mb-3">
                            <label for="id_item" class="form-label">Ítem: <span class="text-danger">*</span></label>
                            <select class="form-control" id="id_item" name="id_item" required>
                                <option value="">Seleccione un ítem</option>
                                <!-- Cargado dinámicamente -->
                            </select>
                        </div>

                        <!-- Tipo de Movimiento -->
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo: <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="">Seleccione tipo</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Salida">Salida</option>
                                <option value="Ajuste">Ajuste</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Cantidad -->
                        <div class="col-md-6 mb-3">
                            <label for="cantidad" class="form-label">Cantidad: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required />
                            <small class="form-text text-muted">La cantidad debe ser mayor a 0</small>
                        </div>

                        <!-- Fecha de Movimiento -->
                        <div class="col-md-6 mb-3">
                            <label for="fecha_movimiento" class="form-label">Fecha:</label>
                            <input type="datetime-local" class="form-control" id="fecha_movimiento" name="fecha_movimiento" readonly />
                            <small class="form-text text-muted">Fecha automática del sistema</small>
                        </div>
                    </div>

                    <!-- Motivo -->
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo: <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="motivo" name="motivo" rows="3" maxlength="200" required placeholder="Describa el motivo del movimiento..."></textarea>
                        <small class="form-text text-muted">Máximo 200 caracteres</small>
                    </div>

                    <!-- Información del Ítem (solo lectura) -->
                    <div class="card mb-3" id="info_item_card" style="display: none;">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">Información del Ítem Seleccionado</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Stock Actual:</strong> <span id="info_stock_actual">0</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Stock Mínimo:</strong> <span id="info_stock_minimo">0</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <strong>Estado Stock:</strong> 
                                    <span id="info_estado_stock" class="badge bg-success">Disponible</span>
                                </div>
                            </div>
                        </div>
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
                    <button type="button" class="btn btn-secondary" id="btnclosemodal" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnagregar">Registrar Movimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Validaciones en tiempo real -->
<script>
    // Validar cantidad positiva
    document.getElementById('cantidad').addEventListener('input', function () {
        if (this.value <= 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Validar motivo no vacío
    document.getElementById('motivo').addEventListener('input', function () {
        if (this.value.trim() === '') {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Validar caracteres especiales en motivo
    document.getElementById('motivo').addEventListener('input', function () {
        this.value = this.value.replace(/[<>]/g, '');
    });

</script>