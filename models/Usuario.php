<?php

class Usuario extends Conectar {

    public function login($email, $password) {
        try {
            $conectar = parent::Conexion();

            $sql = "SELECT * FROM b_usuario WHERE usu_email = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["usu_pass"])) {
                return ["success" => true, "user" => $user];
            }

            return ["success" => false]; //1 es admin, 2 es usuario
        } catch (Throwable $e) {
            error_log("ERROR en login: " . $e->getMessage());
            return ["success" => false, "error" => "Error al logear el usuario"];
        }
    }

}
?>