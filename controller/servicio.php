<?php
require_once("../config/config.php");
require_once("../models/Servicio.php");

$servicio = new Servicio();

switch($_GET["op"]){

    case "listar":
        $data = $servicio->get_servicio();

        if ($data["success"]) {
            echo json_encode($data["object"]);
        } else {
            echo json_encode([]);
        }
        exit;
}
?>