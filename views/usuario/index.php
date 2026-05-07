<?php require_once("../Main/sesion.php"); ?>
<!doctype html>
<html lang="es">
<head>
    <?php require_once("../Main/mainhead.php"); ?>
    <title>Usuarios - Gestión Administrativa</title>
</head>
<body data-topbar="colored">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ========== Header Start ========== -->
        <?php require_once("../main/mainheader.php"); ?>
        <!-- ========== Header Finish ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php require_once("../main/mainleftsiderbar.php"); ?>
        <!-- ========== Left Sidebar Finish ========== -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Page-Title -->
                <div class="page-title-box">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="page-title mb-1">Mantenimiento de Usuarios</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Usuarios</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="page-content-wrapper">
                    <div class="container-fluid">
                        <!-- Tabla de Usuarios -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Botón Nuevo Usuario -->
                                        <button class="btn btn-secondary waves-effect waves-light mb-4" id="btnnuevo">
                                            <i class="fa fa-plus-square me-2"></i> Nuevo Usuario
                                        </button>

                                        <!-- Tabla DataTable -->
                                        <table id="usuario_data" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Rol</th>
                                                    <th>DNI</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Dirección</th>
                                                    <th>Correo</th>
                                                    <th>Usuario</th>
                                                    <th>Clave</th>
                                                    <th>Celular</th>
                                                    <th>Estado</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Los datos se cargan dinámicamente desde usuarios.js -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div>
                <!-- end page-content-wrapper -->
            </div>
            <!-- End Page-content -->

            <!-- ========== Footer Start ========== -->
            <?php require_once("../Main/mainfooter.php"); ?>
            <!-- ========== Footer End ========== -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#chat-tab" role="tab" aria-selected="true">
                        <span class="d-none d-sm-block"><i class="mdi mdi-message-text font-size-22"></i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tasks-tab" role="tab" aria-selected="false" tabindex="-1">
                        <span class="d-none d-sm-block"><i class="mdi mdi-format-list-checkbox font-size-22"></i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings-tab" role="tab" aria-selected="false" tabindex="-1">
                        <span class="d-none d-sm-block"><i class="mdi mdi-settings font-size-22"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Right bar -->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <?php require_once("modalmantenimiento.php"); ?>
    <?php require_once("../Main/mainjs.php"); ?>

    <!-- PDFMake para exportar PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.72/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.72/vfs_fonts.js"></script>

    <!-- Script de Usuarios -->
    <script src="./usuarios.js"></script>
</body>
</html>