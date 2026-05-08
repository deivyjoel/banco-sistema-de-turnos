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
    default:
        break;
}
?>