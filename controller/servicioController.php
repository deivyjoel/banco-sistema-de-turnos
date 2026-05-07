<?php
session_start();
require_once("../config/conexion.php");
require_once("../models/Servicio.php");

$servicio = new Servicio();

switch ($_GET["op"]) { 
    
    case 'listar':
        $datos = $servicio->get_servicios();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ser_nom"];
            $sub_array[] = $row["ser_dur_prom"] . ' min';

            // Badge estado
            if ($row["ser_est"] == 1) {
                $sub_array[] = '<span class="badge" style="background-color:#1DB97A; color:#FFFFFF; font-size:0.85em;">ACTIVO</span>';
            } else {
                $sub_array[] = '<span class="badge" style="background-color:#E24B4A; color:#FFFFFF; font-size:0.85em;">INACTIVO</span>';
            }

            // Columna Detalle
            if ($_SESSION['usuario']['rol'] == 1) {
                $sub_array[] = '
                    <button onclick="ver(' . $row["ser_id"] . ');" class="btn btn-sm" style="background-color:#CECBF6; color:#3C3489; border:none;">
                        <i class="mdi mdi-eye"></i> Detalle
                    </button>
                    <button onclick="eliminar(' . $row["ser_id"] . ');" class="btn btn-sm" style="background-color:#E24B4A; color:#FFFFFF; border:none;">
                        <i class="mdi mdi-trash-can"></i>
                    </button>';
            } else {
                $sub_array[] = '
                    <button onclick="reservar(' . $row["ser_id"] . ');" class="btn btn-sm" style="background-color:#534AB7; color:#FFFFFF; border:none;">
                        <i class="mdi mdi-calendar-plus"></i> Reservar
                    </button>';
            }

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
        break;

    case 'listar_usuario':
        $datos = $servicio->get_servicios_activos();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ser_nom"];
            $sub_array[] = $row["ser_dur_prom"] . ' min';
            $sub_array[] = '<span class="badge text-bg-success" style="font-size: 1em; background-color: green;">ACTIVO</span>';
            $sub_array[] = '<button type="button" onClick="ver('.$row["ser_id"].');" class="btn btn-outline-info btn-icon"><div><i class="fa fa-eye"></i></div></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
        break;

    case 'guardaryeditar':
        try {
            $ser_id = empty($_POST["ser_id"]) ? null : $_POST["ser_id"];
            $ser_nom = trim($_POST["ser_nom"]);
            $ser_dur_prom = $_POST["ser_dur_prom"];

            // Verificar nombre duplicado
            $existe = $servicio->get_servicio_x_nombre($ser_nom);
            if (is_array($existe) && count($existe) > 0) {
                if (empty($ser_id) || $existe[0]["ser_id"] != $ser_id) {
                    throw new Exception("Ya existe un servicio con ese nombre.");
                }
            }

            if (empty($ser_id)) {
                $servicio->insert_servicio($ser_nom, $ser_dur_prom);
                $response = ["success" => true, "message" => "Servicio registrado correctamente."];
            } else {
                $servicio->update_servicio($ser_id, $ser_nom, $ser_dur_prom, $_POST["ser_est"]);
                $response = ["success" => true, "message" => "Servicio actualizado correctamente."];
            }
        } catch (PDOException $e) {
            $response = ["success" => false, "message" => "Error de base de datos: " . $e->getMessage()];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    case 'mostrar':
        $datos = $servicio->get_servicio_x_id($_POST["ser_id"]);
        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $output["ser_id"]       = $row["ser_id"];
                $output["ser_nom"]      = $row["ser_nom"];
                $output["ser_dur_prom"] = $row["ser_dur_prom"];
                $output["ser_est"]      = $row["ser_est"];
            }
            echo json_encode($output);
        }
        break;

    case 'eliminar':
        try {
            $servicio->delete_servicio($_POST["ser_id"]);
            $response = ["success" => true, "message" => "Servicio eliminado correctamente."];
        } catch (PDOException $e) {
            $response = ["success" => false, "message" => "Error al eliminar: " . $e->getMessage()];
        }
        echo json_encode($response);
        break;

    default:
        break;
}
?>