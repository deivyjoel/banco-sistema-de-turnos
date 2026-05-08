<?php require_once("../Main/sesion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Main/mainhead.php"); ?>
    <title>Dashboard | Sistema de Banco ATC</title>
</head>
<body data-topbar="colored">
    <div id="layout-wrapper">
        // HEADER
        <?php require_once("../Main/mainheader.php"); ?>
        // SIDEBAR
        <?php require_once("../Main/mainleftsiderbar.php"); ?>
        // MAIN CONTENT 
        <div class="main-content">
            <?php require_once("../Main/maindashboard.php"); ?>
        </div>
        // FOOTER
        <?php require_once("../Main/mainfooter.php"); ?>
    </div>

    // SCRIPTS
    <?php require_once("../Main/mainjs.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="./inicio.js"></script>
</body>
</html>