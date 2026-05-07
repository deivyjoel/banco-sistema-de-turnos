<div id="modalmantenimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmantenimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h4 class="modal-title" id="lbltitulo">Crear un nuevo Usuario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario Mantenimiento -->
            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" name="usu_id" id="usu_id" />

                    <!-- Rol -->
                    <div class="mb-3">
                        <label for="rol_id" class="form-label">Rol: <span class="text-danger">*</span></label>
                        <select class="form-control" id="rol_id" name="rol_id" required>
                            <option value="">Seleccione un rol</option>
                        </select>
                    </div>

                    <!-- DNI -->
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="dni" name="dni" maxlength="15" required />
                        <small class="form-text text-muted">Máximo 15 caracteres.</small>
                    </div>

                    <!-- Nombres -->
                    <div class="mb-3">
                        <label for="usu_nom" class="form-label">Nombres: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="usu_nom" name="usu_nom" required />
                    </div>

                    <!-- Apellidos -->
                    <div class="mb-3">
                        <label for="usu_ape" class="form-label">Apellidos: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="usu_ape" name="usu_ape" required />
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label for="usu_direc" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="usu_direc" name="usu_direc" />
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label for="usu_correo" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="usu_correo" name="usu_correo" />
                    </div>

                    <!-- Usuario -->
                    <div class="mb-3">
                        <label for="usu_usuario" class="form-label">Usuario: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="usu_usuario" name="usu_usuario" required />
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="usu_clave" class="form-label">Contraseña: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="usu_clave" name="usu_clave" required />
                    </div>

                    <!-- Celular -->
                    <div class="mb-3">
                        <label for="usu_cel" class="form-label">Celular:</label>
                        <input type="text" class="form-control" id="usu_cel" name="usu_cel" maxlength="20" />
                        <small class="form-text text-muted">Máximo 20 caracteres.</small>
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
    // Limitar DNI a 15 caracteres
    document.getElementById('dni').addEventListener('input', function () {
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15);
        }
    });

    // Limitar Celular a 20 caracteres
    document.getElementById('usu_cel').addEventListener('input', function () {
        if (this.value.length > 20) {
            this.value = this.value.slice(0, 20);
        }
    });
</script>