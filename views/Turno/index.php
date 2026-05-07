<?php require_once("../Main/sesion.php"); ?>
<!doctype html>
<html lang="es">
<head>
    <?php require_once("../Main/mainhead.php"); ?>
    <title>Banca Unión - Mis Turnos</title>
</head>
<body data-topbar="colored">
    <div id="layout-wrapper">

        <?php require_once("../Main/mainheader.php"); ?>
        <?php require_once("../Main/mainleftsiderbar.php"); ?>

        <div class="main-content">
            <div class="page-content">

                <!-- Page-Title -->
                <div class="page-title-box">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="page-title mb-1">Historial de Turnos</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Mis Turnos</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <table id="turno_data" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Servicio</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Cargado dinámicamente desde turno.js -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php require_once("../Main/mainfooter.php"); ?>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#chat-tab" role="tab">
                        <span class="d-none d-sm-block"><i class="mdi mdi-message-text font-size-22"></i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tasks-tab" role="tab">
                        <span class="d-none d-sm-block"><i class="mdi mdi-format-list-checkbox font-size-22"></i></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings-tab" role="tab">
                        <span class="d-none d-sm-block"><i class="mdi mdi-settings font-size-22"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="rightbar-overlay"></div>

    <?php require_once("../Main/mainjs.php"); ?>
    <script src="./turno.js"></script>
</body>
</html>