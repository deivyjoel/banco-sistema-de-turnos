<?php
session_start();
require_once("../config/conexion.php");
require_once("../models/Usuario.php");

$usuario = new Usuario();

switch ($_GET["op"]) {

    // ─── AUTH ────────────────────────────────────────────────────────────────
    case 'login':
        try {
            $email    = trim($_POST["email"] ?? '');
            $password = $_POST["password"] ?? '';

            if (empty($email) || empty($password)) {
                throw new Exception("Completa todos los campos.");
            }

            $result = $usuario->login($email, $password);

            if (!$result['success']) {
                throw new Exception("Credenciales incorrectas.");
            }

            $_SESSION['usuario'] = [
                'id'     => $result['user']['usu_id'],
                'nombre' => $result['user']['usu_nom'],
                'email'  => $result['user']['usu_email'],
                'rol'    => (int) $result['user']['usu_rol']
            ];

            $response = [
                "success" => true,
                "message" => "Bienvenido.",
                "rol"     => $result['user']['usu_rol']
            ];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    case 'deslog':
        session_destroy();
        echo json_encode(["success" => true, "message" => "Sesión cerrada."]);
        break;

    // ─── CRUD (Admin) ─────────────────────────────────────────────────────────

    case 'listar':
        $datos = $usuario->get_usuarios();
        $data  = array();

        foreach ($datos as $row) {
            $sub_array   = array();
            $sub_array[] = $row["usu_nom"];
            $sub_array[] = $row["usu_email"];
            $sub_array[] = $row["usu_rol"] == 1 ? 'Administrador' : 'Usuario'; // ← CAMBIADO

            if ($row["usu_est"] == 1) {
                $sub_array[] = '<span class="badge" style="font-size:1em; background-color:green;">ACTIVO</span>';
            } else {
                $sub_array[] = '<span class="badge" style="font-size:1em; background-color:red;">INACTIVO</span>';
            }

            $sub_array[] = '
                <button type="button" onClick="editar(' . $row["usu_id"] . ');" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>
                <button type="button" onClick="eliminar(' . $row["usu_id"] . ');" class="btn btn-outline-danger btn-icon"><div><i class="mdi mdi-trash-can"></i></div></button>
            ';

            $data[] = $sub_array;
        }

        echo json_encode([
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data
        ]);
        break;

    case 'mostrar':
        try {
            $usu_id = $_POST["usu_id"];

            if (empty($usu_id) || !is_numeric($usu_id)) {
                throw new Exception("ID inválido.");
            }

            $datos = $usuario->get_usuario_x_id((int) $usu_id);

            if (is_array($datos) && count($datos) > 0) {
                $row = $datos[0];
                echo json_encode([
                    "usu_id"    => $row["usu_id"],
                    "usu_nom"   => $row["usu_nom"],
                    "usu_email" => $row["usu_email"],
                    "usu_rol"   => $row["usu_rol"],
                    "usu_est"   => $row["usu_est"]
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Usuario no encontrado."]);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        break;

    case 'guardaryeditar':
        try {
            $usu_id   = empty($_POST["usu_id"]) ? null : $_POST["usu_id"];
            $nom      = trim($_POST["usu_nom"] ?? '');
            $email    = trim($_POST["usu_email"] ?? '');
            $rol      = $_POST["usu_rol"] ?? 2; // ← CAMBIADO
            $password = $_POST["usu_password"] ?? '';

            if (empty($nom) || empty($email)) {
                throw new Exception("Nombre y email son obligatorios.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email inválido.");
            }

            // Verificar email duplicado
            $existe = $usuario->get_usuario_x_email($email);
            if (is_array($existe) && count($existe) > 0) {
                if (empty($usu_id) || $existe[0]["usu_id"] != $usu_id) {
                    throw new Exception("El email ya está registrado.");
                }
            }

            if (empty($usu_id)) {
                // Nuevo usuario — password obligatorio
                if (empty($password) || strlen($password) < 8) {
                    throw new Exception("La contraseña debe tener al menos 8 caracteres.");
                }
                $usuario->insert_usuario($nom, $email, $password, $rol);
                $response = ["success" => true, "message" => "Usuario registrado correctamente."];
            } else {
                // Editar — password opcional
                $nueva_pass = (!empty($password) && strlen($password) >= 8) ? $password : null;
                $usuario->update_usuario((int) $usu_id, $nom, $email, $rol, $_POST["usu_est"], $nueva_pass);
                $response = ["success" => true, "message" => "Usuario actualizado correctamente."];
            }
        } catch (PDOException $e) {
            $response = ["success" => false, "message" => "Error de base de datos: " . $e->getMessage()];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    case 'eliminar':
        try {
            $usu_id = $_POST["usu_id"];

            if (empty($usu_id) || !is_numeric($usu_id)) {
                throw new Exception("ID inválido.");
            }

            $usuario->delete_usuario((int) $usu_id);
            $response = ["success" => true, "message" => "Usuario eliminado correctamente."];
        } catch (PDOException $e) {
            $response = ["success" => false, "message" => "Error al eliminar: " . $e->getMessage()];
        } catch (Exception $e) {
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    default:
        break;
}
?>