<?php
require_once("../Main/sesion.php"); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../Main/mainhead.php"); ?>
    <title>Dashboard | Sistema de Banco ATC</title>
</head>
<body data-topbar="colored">
    <div id="layout-wrapper">
        <?php require_once("../Main/mainheader.php"); ?>
        //SIDEBAR
        <?php require_once("../Main/mainleftsiderbar.php"); ?>
        //
        <div class="main-content">
            // main contenttt
            <?php require_once("../Main/maindashboard.php"); ?>
        </div>
        <?php require_once("../Main/mainfooter.php"); ?>
    </div>

    <?php require_once("../Main/mainjs.php"); ?>
    <script src="./inicio.js"></script>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>