<?php
session_start();
require_once("../config/conexion.php");
require_once("../models/Turno.php");

$turno = new Turno();

switch ($_GET["op"]) {

    case 'listar_usuario':
        if (empty($_SESSION['usuario'])) {
            echo json_encode(["sEcho" => 1, "iTotalRecords" => 0, "iTotalDisplayRecords" => 0, "aaData" => []]);
            break;
        }

        $usu_rol = $_SESSION['usuario']['rol'];
        if ($usu_rol === 1){
            $datos = $turno->get_all();
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["tur_pre"] . $row["tur_n_tur"];
                $sub_array[] = $row["ser_nom"]; 
                $sub_array[] = $row["tur_fec_hor"];
                $sub_array[] = $row["usu_nom"];

                switch ($row["tur_est"]) {
                    case 1:
                        $sub_array[] = '<span class="badge" style="font-size:1em; background-color:#f0ad4e; cursor:pointer;" 
                            onclick="cambiarEstado(' . $row["tur_id"] . ', 2, \'' . $row["tur_pre"] . $row["tur_n_tur"] . '\')">EN ESPERA</span>';
                        break;
                    case 2:
                        $sub_array[] = '<span class="badge" style="font-size:1em; background-color:#0275d8; cursor:pointer;" 
                            onclick="cambiarEstado(' . $row["tur_id"] . ', 4, \'' . $row["tur_pre"] . $row["tur_n_tur"] . '\')">ATENDIENDO</span>';
                        break;
                    case 4:
                        $sub_array[] = '<span class="badge" style="font-size:1em; background-color:green;">ATENDIDO</span>';
                        break;
                    case 3:
                        $sub_array[] = '<span class="badge" style="font-size:1em; background-color:red;">CANCELADO</span>';
                        break;
                    default:
                        $sub_array[] = '<span class="badge" style="font-size:1em; background-color:gray;">' . $row["tur_est"] . '</span>';
                        break;
                }

                $data[] = $sub_array;
            }

            echo json_encode([
                "sEcho"                => 1,
                "iTotalRecords"        => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData"               => $data
            ]);
            break;            
        } else{
            $usu_id = $_SESSION['usuario']['id'];
            $datos = $turno->get_turnos_by_usuario($usu_id);
            $data = array();

            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["tur_pre"] . $row["tur_n_tur"];
                $sub_array[] = $row["ser_nom"];
                $sub_array[] = $row["tur_fec_hor"];

                switch ($row["tur_est"]) {
                    case 1:
                        $sub_array[] = '<span class="badge" style="font-size:0.85em; background-color:#CECBF6; color:#3C3489;">EN ESPERA</span>';
                        break;
                    case 2:
                        $sub_array[] = '<span class="badge" style="font-size:0.85em; background-color:#534AB7; color:#FFFFFF;">EN ATENCIÓN</span>';
                        break;
                    case 4:
                        $sub_array[] = '<span class="badge" style="font-size:0.85em; background-color:#1DB97A; color:#FFFFFF;">ATENDIDO</span>';
                        break;
                    case 3:
                        $sub_array[] = '<span class="badge" style="font-size:0.85em; background-color:#E24B4A; color:#FFFFFF;">CANCELADO</span>';
                        break;
                    default:
                        $sub_array[] = '<span class="badge" style="font-size:0.85em; background-color:#CECBF6; color:#3C3489;">' . $row["tur_est"] . '</span>';
                }

                // Botón cancelar solo si está en espera
                if ($row["tur_est"] == 1) {
                    $sub_array[] = '<button type="button" onClick="cancelar(' . $row["tur_id"] . ');" class="btn btn-outline-danger btn-icon"><div><i class="mdi mdi-trash-can"></i></div></button>';
                } else {
                    $sub_array[] = '-';
                }

                $data[] = $sub_array;
            }

            echo json_encode([
                "sEcho"                => 1,
                "iTotalRecords"        => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData"               => $data
            ]);
            break;
        }

    case 'turno_activo':
        if (empty($_SESSION['usuario'])) {
            echo json_encode(["success" => false, "message" => "No autenticado"]);
            break;
        }

        $usu_id = $_SESSION['usuario']['id'];
        $datos = $turno->get_turno_activo($usu_id);

        if ($datos && count($datos) > 0) {
            echo json_encode(["success" => true, "data" => $datos]);
        } else {
            echo json_encode(["success" => false, "message" => "Sin turno activo"]);
        }
        break;

    case 'reservar':
        if (empty($_SESSION['usuario'])) {
            echo json_encode(["success" => false, "message" => "No autenticado"]);
            break;
        }

        try {
            $ser_id = $_POST["ser_id"];

            if (empty($ser_id) || !is_numeric($ser_id)) {
                throw new Exception("Servicio inválido.");
            }

            $usu_id = (int) $_SESSION['usuario']['id'];
            $ser_id = (int) $ser_id;

            if ($turno->usuario_tiene_turno_activo($usu_id)) {
                throw new Exception("Ya tienes un turno activo. Debes esperar a que finalice antes de solicitar otro.");
            }

            if ($turno->usuario_tiene_turno_en_servicio($usu_id, $ser_id)) {
                throw new Exception("Ya tienes un turno activo para este servicio.");
            }

            $result = $turno->insert_turno($usu_id, $ser_id);

            if (!$result['success']) {
                throw new Exception($result['error']);
            }

            $response = [
                "success"    => true,
                "message"    => "Turno reservado correctamente.",
                "tur_id"     => $result['id'],
                "tur_n_tur"  => $result['n_turno'],
                "tur_pre"    => $result['cod_turno']
            ];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    case 'cancelar':
        if (empty($_SESSION['usuario'])) {
            echo json_encode(["success" => false, "message" => "No autenticado"]);
            break;
        }

        try {
            $tur_id = $_POST["tur_id"];

            if (empty($tur_id) || !is_numeric($tur_id)) {
                throw new Exception("ID de turno inválido.");
            }

            $usu_id = (int) $_SESSION['usuario']['id'];
            $tur_id = (int) $tur_id;
            $result = $turno->cancelar_turno($tur_id, $usu_id);

            if (!$result['success']) {
                throw new Exception($result['error']);
            }

            $response = ["success" => true, "message" => "Turno cancelado correctamente."];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    case 'cancelar_directo':
        if (empty($_SESSION['usuario'])) {
            header("Location: ../../views/Login/index.php");
            exit();
        }

        $tur_id = (int) $_GET['tur_id'];
        $usu_id = (int) $_SESSION['usuario']['id'];
        $turno->cancelar_turno($tur_id, $usu_id);

        header("Location: ../views/Inicio/index.php");
        exit();
        break;

    case 'mostrar':
        $tur_id = $_POST['tur_id'];
        $dato = $turno->get_turno_x_id($tur_id);
        echo json_encode($dato);
        break;

    case 'cambiar_estado':
        $tur_id     = (int) $_POST['tur_id'];
        $ser_id = (int) $_POST['ser_id'];
        $estado = (int) $_POST['estado'];

        // Validar que el estado sea válido
        $permitidos = [2, 3, 4];
        if (!in_array($estado, $permitidos)) {
            echo json_encode(["success" => false, "mensaje" => "Estado no válido"]);
            break;
        }

        // Regla: no dos 'atendiendo' al mismo tiempo por servicio
        if ($estado === 2) {
            $hayAtendiendo = $turno->servicio_tiene_turno_activo($ser_id);
            if ($hayAtendiendo) {
                echo json_encode(["success" => false, "mensaje" => "Ya hay un turno en atención para este servicio"]);
                break;
            }
        }

        $ok = $turno->cambiar_estado($tur_id, $estado);
        echo json_encode(["success" => $ok]);
        break;

    default:
        break;
}
?>