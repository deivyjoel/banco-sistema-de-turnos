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

            return ["success" => false];
        } catch (Throwable $e) {
            error_log("ERROR en login: " . $e->getMessage());
            return ["success" => false, "error" => "Error al logear el usuario"];
        }
    }

    public function get_usuarios() {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT usu_id, usu_nom, usu_email, usu_rol, usu_est FROM b_usuario";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function get_usuario_x_id($usu_id) {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT usu_id, usu_nom, usu_email, usu_rol FROM b_usuario WHERE usu_id = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_usuario_x_id: " . $e->getMessage());
            return [];
        }
    }

    public function get_usuario_x_email($email) {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT usu_id FROM b_usuario WHERE usu_email = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_usuario_x_email: " . $e->getMessage());
            return [];
        }
    }

    public function insert_usuario($nom, $email, $password, $rol) {
        try {
            $conectar = parent::Conexion();
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO b_usuario (usu_nom, usu_email, usu_pass, usu_rol) VALUES (?, ?, ?, ?)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $nom);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $hash);
            $stmt->bindValue(4, $rol);
            $stmt->execute();
            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en insert_usuario: " . $e->getMessage());
            return ["success" => false, "error" => "Error al insertar usuario"];
        }
    }

    public function update_usuario($usu_id, $nom, $email, $rol, $est, $password = null) {
        try {
            $conectar = parent::Conexion();

            if ($password !== null) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $sql  = "UPDATE b_usuario SET usu_nom = ?, usu_email = ?, usu_rol = ?, usu_pass = ? WHERE usu_id = ?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $nom);
                $stmt->bindValue(2, $email);
                $stmt->bindValue(3, $rol);;
                $stmt->bindValue(4, $hash);
                $stmt->bindValue(5, $usu_id);
            } else {
                $sql  = "UPDATE b_usuario SET usu_nom = ?, usu_email = ?, usu_rol = ?  WHERE usu_id = ?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $nom);
                $stmt->bindValue(2, $email);
                $stmt->bindValue(3, $rol);
                $stmt->bindValue(4, $usu_id);
            }

            $stmt->execute();
            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en update_usuario: " . $e->getMessage());
            return ["success" => false, "error" => "Error al actualizar usuario"];
        }
    }

    public function delete_usuario($usu_id) {
        try {
            $conectar = parent::Conexion();

            $sql = "UPDATE b_usuario SET usu_est = 0 WHERE usu_id = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->execute();
            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en delete_usuario: " . $e->getMessage());
            return ["success" => false, "error" => "Error al eliminar usuario"];
        }
    }
}
?>