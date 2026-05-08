<?php
require_once("../../config/conexion.php");
require_once("../../models/Turno.php");

$turnoModel  = new Turno();
$usu_id      = $_SESSION['usuario']['id'];
$turnoActivo = $turnoModel->get_turno_activo($usu_id);
$tieneTurno  = $turnoActivo['success'] && $turnoActivo['object'] !== null;
$t           = $tieneTurno ? $turnoActivo['object'] : null;
?>

<?php if ($usu_rol == 2): ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">

                <?php if ($tieneTurno): ?>
                    <!-- Card turno activo -->
                    <div class="card" style="width: 360px; border: 1px solid #CECBF6; border-top: 3px solid #534AB7; border-radius: 4px;">
                        <div class="card-body text-center">

                            <h5 class="card-title mb-1" style="color: #26215C; font-weight: 600;">Tu turno actual</h5>
                            <p class="text-muted mb-3" style="font-size: 0.85rem;">Espera tu llamado</p>

                            <div style="font-size: 3rem; font-weight: 700; color: #26215C; letter-spacing: 4px;">
                                <?php echo htmlspecialchars($t['tur_pre'] . str_pad($t['tur_n_tur'], 3, '0', STR_PAD_LEFT)); ?>
                            </div>

                            <hr style="border-color: #CECBF6;">

                            <div class="text-start mt-3">
                                <p class="mb-1">
                                    <strong>Servicio:</strong>
                                    <?php echo htmlspecialchars($t['ser_nom']); ?>
                                </p>
                                <p class="mb-1">
                                    <strong>Duración estimada:</strong>
                                    <?php echo htmlspecialchars($t['ser_dur_prom']); ?> min
                                </p>
                                <p class="mb-0">
                                    <strong>Estado:</strong>
                                    <?php if ($t['tur_est'] == 1): ?>
                                        <span class="badge" style="background-color:#EEEDFE; color:#3C3489; font-size:0.85em;">EN ESPERA</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color:#534AB7; color:#fff; font-size:0.85em;">EN ATENCIÓN</span>
                                    <?php endif; ?>
                                </p>
                            </div>

                            <?php if ($t['tur_est'] == 1): ?>
                                <a href="../../controller/turnoController.php?op=cancelar_directo&tur_id=<?php echo $t['tur_id']; ?>" 
                                class="btn mt-4 w-100" style="border: 1px solid #534AB7; color: #534AB7; background-color: transparent; border-radius: 4px;">
                                    <i class="mdi mdi-close me-1"></i> Cancelar turno
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>

                <?php else: ?>
                    <!-- Botón reservar -->
                    <a href="../../views/Servicio/" class="btn btn-lg px-5 py-3" style="font-size: 1.2rem; background-color: #534AB7; color: #fff; border-radius: 4px;">
                        <i class="mdi mdi-calendar-plus me-2"></i> Reservar
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>