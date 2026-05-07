<?php
session_start();

$usu_rol = $_SESSION["usuario"]["rol"];
$usu_nom = $_SESSION["usuario"]["nombre"];
error_log("USU_ROL: " . $usu_rol);
?>